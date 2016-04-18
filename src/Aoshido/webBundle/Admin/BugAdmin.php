<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BugAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Contenido')
                    ->add('contenido', 'text')
                    ->add('respuesta', 'text')
                ->end()
                
                ->with('Lifecycle')
                    ->add('activo','choice', array(
                            'choices' => array('true' => TRUE, 'false' => FALSE),
                        ))
                    ->add('status', 'text')
                    ->add('reportedUser', 'entity', array(
                        'class' => 'Aoshido\UserBundle\Entity\User',
                        'property' => 'username',
                    ))
                    //->add('creada', 'datetime')
                ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('contenido');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('contenido');
    }
    
    public function toString($object){
        return $object instanceof Bug
            ? $object->getTitle()
            : 'Bug'; // shown in the breadcrumb on the create view
    }

}
