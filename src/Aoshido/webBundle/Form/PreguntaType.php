<?php

namespace Aoshido\webBundle\Form;

use Aoshido\webBundle\Form\TemaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Aoshido\webBundle\Form\EventListener\AddTemaFieldSuscriber;
use Aoshido\webBundle\Form\EventListener\AddMateriaFieldSuscriber;
use Aoshido\webBundle\Form\EventListener\AddCarreraFieldSuscriber;

class PreguntaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $propertyPathToTema = 'temas';

        $builder->addEventSubscriber(new AddTemaFieldSuscriber($propertyPathToTema));
        $builder->addEventSubscriber(new AddMateriaFieldSuscriber($propertyPathToTema));
        $builder->addEventSubscriber(new AddCarreraFieldSuscriber($propertyPathToTema));

        $builder->add('contenido', 'text', array(
            'label' => 'Pregunta:',
        ));

        $builder->add('save', 'submit', array(
            'label' => 'Agregar Pregunta',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
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
