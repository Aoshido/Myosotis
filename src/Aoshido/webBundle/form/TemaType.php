<?php

namespace Aoshido\webBundle\form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class TemaType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('descripcion', 'text', array(
            'label' => 'Tema:',
            'label_attr' => array(
                'class' => 'col-md-2 control-label'
            ),
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Tema',
        ));
    }
    public function getName() {
        return 'tema';
    }
}