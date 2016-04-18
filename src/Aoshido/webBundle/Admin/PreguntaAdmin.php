<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PreguntaAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->tab('Pregunta')
                    ->with('Contenido')
                        ->add('contenido', 'text')
                        ->add('vecesVista', 'integer')
                        ->add('vecesAcertada', 'integer')
                    ->end()

                    ->with('Lifecycle')
                        ->add('activo', 'choice')
                        ->add('creatorUser', 'entity', array(
                            'class' => 'Aoshido\UserBundle\Entity\User',
                            'property' => 'username',
                        ))
                        ->add('creada', 'datetime')
                    ->end()
                ->end()
                
                ->tab('Jerarquia')
                    ->add('temas', 'entity', array(
                        'class' => 'Aoshido\webBundle\Entity\Tema',
                        'property' => 'descripcion',
                    ))
                ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('contenido');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('contenido')
                ->addIdentifier('creatorUser.username');
    }

}
