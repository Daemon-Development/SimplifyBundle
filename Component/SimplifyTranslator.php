<?php


namespace Daemon\SimplifyBundle\Component;



use Symfony\Component\Translation\DataCollectorTranslator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class SimplifyTranslator
 *
 * The Default translator added with an option to set a default translation domain
 * transSimple uses this domain so just the id and optional parameters are necessary
 *
 * @package Daemon\SimplifyBundle\Component
 */
class SimplifyTranslator extends DataCollectorTranslator {

    protected $defaultTranslationDomain;

    public function __construct(TranslatorInterface $translator, $defaultTranslationDomain = null)
    {
        parent::__construct($translator);
        $this->defaultTranslationDomain = $defaultTranslationDomain;
    }

    public function setDefaultTranslationDomain($defaultTranslationDomain) {
        $this->defaultTranslationDomain = $defaultTranslationDomain;

        return $this;
    }

    public function getDefaultTranslationDomain() {
        return $this->defaultTranslationDomain;
    }

    public function transSimple($id, array $parameters = array())
    {
        return parent::trans($id, $parameters, $this->defaultTranslationDomain);
    }

    public function trans($id, array $parameters = array(), $domain = null, $locale = null)
    {
        if (!isset($domain)) {
            $domain = $this->defaultTranslationDomain;
        }
        return parent::trans($id, $parameters, $domain, $locale);
    }

    public function transChoice($id, $number, array $parameters = array(), $domain = null, $locale = null)
    {
        if (!isset($domain)) {
            $domain = $this->defaultTranslationDomain;
        }
        return parent::transChoice($id, $number, $parameters, $domain, $locale);
    }


}