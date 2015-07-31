<?php

namespace Aoshido\webBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class BugType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('contenido', 'textarea', array(
            'label' => 'Descripcion:',
        ));

        $builder->add('save', 'submit', array(
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Aoshido\webBundle\Entity\Bug',
        ));
    }

    public function getName() {
        return 'bug';
    }

}
