<?php

namespace Aoshido\webBundle\Form;

use Aoshido\webBundle\Form\TemaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Aoshido\webBundle\Form\DataTransformer\MateriaToStringTransformer;
use Aoshido\webBundle\Form\EventListener\AddMateriaByCarreraFieldSuscriber;
use Aoshido\webBundle\Form\EventListener\AddTemaByMateriaFieldSuscriber;




use Aoshido\webBundle\Form\EventListener\AddTemaFieldSuscriber;

class PreguntaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $propertyPathToTema = 'tema';

       // $builder->addEventSubscriber(new AddTemaFieldSuscriber($propertyPathToTema));
        //$builder->addEventSubscriber(new AddMateriaByCarreraFieldSuscriber($propertyPathToTema));
        //$builder->addEventSubscriber(new AddTemaByMateriaFieldSuscriber($propertyPathToTema));

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
