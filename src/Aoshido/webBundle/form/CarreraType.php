<?php

namespace Aoshido\webBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CarreraType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('descripcion', 'text', array(
            'label' => 'Nombre:',
        ));

        $builder->add('materias', 'collection', array(
            'type' => new Materiatype(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));

        /*         * ********** SUBMIT *************** */
        $builder->add('save', 'submit', array(
            'label' => 'Agregar Carrera',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Carrera',
        ));
    }

    public function getName() {
        return 'carrera';
    }

}
