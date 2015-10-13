<?php

namespace Aoshido\webBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RespuestaQuizType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('contenido', 'textarea', array(
            'label' => 'Contenido:',
            'label_attr' => array(
                'class' => 'col-md-2 control-label'
            ),
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('elegida', 'checkbox', array(
            'required' => false,
            'mapped' => false
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Respuesta',
        ));
    }

    public function getName() {
        return 'respuesta_quiz';
    }

}
