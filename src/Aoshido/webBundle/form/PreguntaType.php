<?php

namespace Aoshido\webBundle\form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class PreguntaType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('contenido', 'text', array(
            'label' => 'Pregunta:'
        ));
        
        $builder->add('save', 'submit', array(
            'label' => 'Agregar',
        ));
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Pregunta',
        ));
    }
    public function getName() {
        return 'pregunta';
    }
}