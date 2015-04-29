<?php

namespace Aoshido\webBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MateriaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('descripcion', 'text', array(
            'label' => 'Materia',
            'label_attr' => array(
                'class' => 'col-md-2 control-label'
            ),
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('aniocarrera', 'integer', array(
            'label' => 'Año',
            'label_attr' => array(
                'class' => 'col-md-2 control-label'
            ),
            'attr' => array(
                'class' => 'form-control'
            )
        ));

        $builder->add('carreras', 'entity', array(
            'class' => 'AoshidowebBundle:Carrera',
            'required' => false,
            'expanded' => false,
            'multiple' => true,
            'property' => 'descripcion',
        ));

        $builder->add('save', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Materia',
        ));
    }

    public function getName() {
        return 'materia';
    }

}
