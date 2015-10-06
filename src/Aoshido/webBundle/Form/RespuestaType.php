<?php

namespace Aoshido\webBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RespuestaType extends AbstractType {

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

        //https://github.com/symfony/symfony/issues/14712
        $builder->add('correcta', 'choice', array(
            'label' => 'Correcta:',
            'choices'  => array(TRUE => 'Verdadero', FALSE => 'Falso'),
            'required' => true,
            'expanded' => true,
            'multiple' => false,
            'mapped'=> true,
        ));

        $builder->add('save', 'submit', array(
            'label' => 'Agregar Respuesta',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Respuesta',
        ));
    }

    public function getName() {
        return 'respuesta';
    }

}
