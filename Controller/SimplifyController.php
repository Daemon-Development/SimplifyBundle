<?php

namespace Daemon\SimplifyBundle\Controller;

use Daemon\SimplifyBundle\Component\Enum\SyncType;
use Daemon\SimplifyBundle\Component\Enum\TranslationDomain;
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
     * Sets the container, initializes the entityManager
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->loadParameters();
        $this->em = $this->getDoctrine()->getManager();
        $this->trans = $this->container->get('daemon_simplify_translator');
        $this->trans->setDefaultTranslationDomain(TranslationDomain::SIMPIFIY);

    }

    protected function setDefaultTranslationDomain($defaultTranslationDomain) {
        $this->trans->setDefaultTranslationDomain($defaultTranslationDomain);

        return $this;
    }

    private function loadParameters() {
        $viewContext = $this->container->getParameter('daemon_simplify.view_context');
        RouterContext::setContext($viewContext);
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
            $action = $this->generateUrl($route, $parameters);
        }
        else {
            $parameters = $options->getRouteParameters();
            $customRoute = $options->getRoute();
            if (isset($customRoute)) {
                $action = $this->generateUrl($customRoute, $parameters);
            }
            else {
                $action = $this->generateUrl($route, $parameters);
            }
            $customMethod = $options->getMethod();
            if (!isset($customMethod)) {
                $options->setMethod(RouterContext::guessMethodByRoute($route));
            }
        }


        $form = $this->createForm($formType, $entity, array(
            'action' => $action,
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
     * Checks if entity exists, if not adds an error message to the flashbag
     *
     * usage:
     *  $result = $this->entityExists(new BaseEntity($entity, EntityTypeInterface::...), $id);
     *  if (is_string($result)) {
     *      return $this->redirect($result);
     *  }
     *
     * @param EntityInterface $entity
     * @param $id
     * @return bool|string
     */
    protected function entityExists(EntityInterface $entity, Request $request, $id)
    {
        if (!isset($entity)) {
            $errorMessage = $this->trans->trans('entity.error.notFound', array('%className%' => get_class($entity), '%id%' => $id));
            $errorFlashBag = $this->get('session')->getFlashBag()->get('error');

            if (!in_array($errorMessage, $errorFlashBag)) {
                $this->get('session')->getFlashBag()->add('error', $errorMessage);
            }
            return $this->generateUrl($request->get('_route'));
        }
        return true;
    }



}