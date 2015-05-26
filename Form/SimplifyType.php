<?php

namespace Daemon\SimplifyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class SimplifyType extends AbstractType {


    /**
     * {@inheritdoc}
     *
     * adds config options for simplify
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'options' => array(),
        ));

    }

    
}