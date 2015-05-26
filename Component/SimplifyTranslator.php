<?php


namespace Daemon\SimplifyBundle\Component;



use Symfony\Component\Translation\DataCollectorTranslator;
use Symfony\Component\Translation\TranslatorInterface;

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