<?php

namespace Daemon\SimplifyBundle\Controller;

use Daemon\SimplifyBundle\Component\Enum\HTTP;
use Daemon\SimplifyBundle\Component\Enum\SyncType;
use Daemon\SimplifyBundle\Component\Enum\TranslationDomain;
use Daemon\SimplifyBundle\Component\Enum\ViewContext;
use Daemon\SimplifyBundle\Component\FormOptions;
use Daemon\SimplifyBundle\Component\RouterContext;
use Daemon\SimplifyBundle\Interfaces\EntityInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

abstract class SimplifyController extends Controller
{

    /** @var  \Doctrine\ORM\EntityManager */
    protected $em;

    /** @var  \Daemon\SimplifyBundle\Component\SimplifyTranslator */
    protected $trans;

    /** @var  string */
    protected $translationDomain;




    /**
     * Sets the container, loads configuration, initializes the entityManager and translator
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->loadParameters();
        $this->em = $this->getDoctrine()->getManager();
        $this->trans = $this->container->get('daemon_simplify_translator');
        $this->trans->setDefaultTranslationDomain(TranslationDomain::SIMPlIFY);

    }

    protected function setDefaultTranslationDomain($defaultTranslationDomain) {
        $this->trans->setDefaultTranslationDomain($defaultTranslationDomain);

        return $this;
    }

    /**
     *  Creates a new or update form
     *
     * @param EntityInterface $entity
     * @param AbstractType $formType
     * @param Request $request
     * @param FormOptions $options
     * @return \Symfony\Component\Form\Form
     */
    protected function buildForm(EntityInterface $entity, AbstractType $formType, Request $request, FormOptions $options = null)
    {
        $route = $request->get('_route');

        if (!isset($options)) {
            $options = new FormOptions();
            $parameters = array();
        }
        else {
            $parameters = $options->getRouteParameters();
            $method = RouterContext::guessMethodByRoute($route);
            $viewContext = RouterContext::guessViewContextByRoute($route);

            $customRoute = $options->getRoute();
            if ($customRoute) {
                $route = $customRoute;
            }

            // sets the method to the guessed value if the existing method value is not the default value
            if ($method && $method != $options->getMethod() && $options->getMethod() == HTTP::GET)  {
                $options->setMethod($method);
            }

            // sets the ViewContext to the guessed value if the existing ViewContext value is not the default value
            if ($viewContext && $viewContext != $options->getViewContext() && $options->getViewContext() == ViewContext::CREATE)  {
                $options->setViewContext($viewContext);
            }

        }

        $form = $this->createForm($formType, $entity, array(
            'action' => $this->generateUrl($route, $parameters),
            'method' => $options->getMethod(),
            'options' => $options,
        ));
        return $form;
    }


    /**
     * Syncing actions with DB
     * Can be called on a valid form
     *
     * To expand it if you have a more complex structure to store simply overwrite it (or overload it depends on your needs) and copy the structure inside the method
     *
     * @param EntityInterface $entity
     * @param null $syncType defines DB sync-action by using SyncTypeInterface
     */
    protected function syncDataWithDB(EntityInterface $entity = null, $syncType = null)
    {
        if ($syncType == SyncType::DELETE) {
            $this->em->remove($entity);
        } else {
            if ($syncType && $syncType == SyncType::CREATE) {
                $this->em->persist($entity);
            }
        }
        $this->em->flush();
    }


    /**
     * Checks if entity exists, if not adds an error message to the error flash-bag
     *
     * usage:
     *  $result = $this->entityExists($entity, $request, $id);
     *  if (is_string($result)) {
     *      return $this->redirect($result);
     *  }
     *
     * @param EntityInterface $entity
     * @param Request $request
     * @return bool|string
     */
    protected function entityExists(EntityInterface $entity, Request $request, $id)
    {
        if (!isset($entity)) {
            $errorMessage = $this->trans->transSimple('entity.error.notFound', array('%className%' => get_class($entity), '%id%' => $id));
            $errorFlashBag = $this->get('session')->getFlashBag()->get('error');

            if (!in_array($errorMessage, $errorFlashBag)) {
                $this->get('session')->getFlashBag()->add('error', $errorMessage);
            }
            return $this->generateUrl($request->get('_route'));
        }
        return true;
    }


    /**
     * Loads parameters from the configuration
     */
    private function loadParameters() {
        $viewContext = $this->container->getParameter('daemon_simplify.view_context');
        RouterContext::setContext($viewContext);
    }

}