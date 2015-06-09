<?php

namespace Aoshido\webBundle\Form;

use Aoshido\webBundle\Form\TemaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Aoshido\webBundle\Form\EventListener\AddTemaFieldSuscriber;
use Aoshido\webBundle\Form\EventListener\AddMateriaFieldSuscriber;
use Aoshido\webBundle\Form\EventListener\AddCarreraFieldSuscriber;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class PreguntaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $propertyPathToTema = 'temas';

        $builder->addEventSubscriber(new AddTemaFieldSuscriber($propertyPathToTema));
        $builder->addEventSubscriber(new AddMateriaFieldSuscriber($propertyPathToTema));
        $builder->addEventSubscriber(new AddCarreraFieldSuscriber($propertyPathToTema));
        
        //Esto se agrega porque cuando submiteas la form, campos como por ejemplo
        // temas, vienen vacios, pero sin embarog viene un child "Temas" con el cual
        // uno despues completa la entity, pero symfony antes hace una validacion
        // Entonces hay qeu agregarle esto apra que no haga esa validacion
        // http://symfony.com/doc/current/cookbook/form/dynamic_form_modification.html#suppressing-form-validation
       
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $event->stopPropagation();
        }, 900);
        
        $builder->add('contenido', 'text', array(
            'label' => 'Pregunta:',
        ));

        $builder->add('save', 'submit', array(
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
