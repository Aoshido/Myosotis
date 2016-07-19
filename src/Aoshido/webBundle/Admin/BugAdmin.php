<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BugAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('contenido', 'text');
        $formMapper->add('respuesta', 'text');
        $formMapper->add('status', 'text');
        $formMapper->add('activo', 'text');
        $formMapper->add('reportedUser', 'entity', array(
            'class' => 'Aoshido\UserBundle\Entity\User',
            'property' => 'username'
        ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('id');
        $datagridMapper->add('contenido');
        $datagridMapper->add('respuesta');
        $datagridMapper->add('status');
        $datagridMapper->add('reportedUser',null,array(),'entity',array(
            'class' => 'Aoshido\UserBundle\Entity\User',
            'property' => 'username'
        ));
        $datagridMapper->add('activo');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('id');
        $listMapper->add('contenido');
        $listMapper->add('respuesta');
        $listMapper->add('status');
        $listMapper->add('reportedUser.username');
        $listMapper->add('activo');
    }

    public function toString($object) {
        return $object instanceof Bug 
                ? $object->getId() 
                : 'Bug'; // shown in the breadcrumb on the create view
    }

}
