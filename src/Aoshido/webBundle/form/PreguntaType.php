<?php

namespace Aoshido\webBundle\Form;

use Aoshido\webBundle\Form\TemaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
//use Aoshido\webBundle\Form\DataTransformer\MateriaToStringTransformer;
use Aoshido\webBundle\Form\EventListener\AddMateriaByCarreraFieldSuscriber;
use Aoshido\webBundle\Form\EventListener\AddTemaByMateriaFieldSuscriber;

class PreguntaType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        /* $entityManager = $options['em'];

          $materiatransformer = new MateriaToStringTransformer($entityManager); */
        $builder->add('contenido', 'text', array(
            'label' => 'Pregunta:',
        ));
                        
        $builder->add('idcarrera', 'entity', array(
            'class' => 'AoshidowebBundle:Carrera',
            'label' => 'Carrera:',
            'mapped' => false,
            'required' => false,
            'expanded' => false,
            'multiple' => false,
            'property' => 'descripcion',
            'empty_value' => '- Seleccione Carrera -',
        ));
        
        $builder->add('temas', 'collection', array(
            'type' => new Tematype(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ));

        $builder->add('save', 'submit', array(
            'label' => 'Agregar Pregunta',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));
        $builder->addEventSubscriber(new AddMateriaByCarreraFieldSuscriber());
        $builder->addEventSubscriber(new AddTemaByMateriaFieldSuscriber());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
                    'data_class' => 'Aoshido\webBundle\Entity\Pregunta',
                ))
                ->setRequired(array(
                    'em',
                ))
                ->setAllowedTypes(array(
                    'em' => 'Doctrine\Common\Persistence\ObjectManager',
        ));
    }

    public function getName() {
        return 'pregunta';
    }

}
