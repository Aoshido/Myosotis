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

        $builder->add('correcta', 'choice', array(
            'label' => 'Correcta:',
            'choices'  => array('1' => 'Verdadero', '0' => 'Falso'),
            'required' => true,
            'expanded' => true,
            'multiple' => false,
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
