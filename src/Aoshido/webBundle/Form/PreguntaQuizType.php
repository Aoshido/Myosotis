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

class PreguntaQuizType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('contenido', 'textarea', array(
            'label' => 'Pregunta:',
        ));
        
        $builder->add('respuestas', 'collection', array(
            'type' => new RespuestaType(),
            'mapped' => true,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Pregunta',
        ));
    }

    public function getName() {
        return 'pregunta_quiz';
    }

}
