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

class ExamenType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('preguntas', 'collection', array(
            'type' => new PreguntaQuizType(),
            'mapped' => true,
            'allow_add' => false,
            'allow_delete' => true,
            'by_reference' => false,
        ));

        $builder->add('save', 'submit', array(
            'label' => 'Entregar Examen',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));
        
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $event->stopPropagation();
        }, 900);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Examen',
        ));
    }

    public function getName() {
        return 'quiz';
    }

}
