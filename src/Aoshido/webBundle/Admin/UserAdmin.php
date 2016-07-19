<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('username', 'text');
        $formMapper->add('email', 'text');
        $formMapper->add('roles', 'text');
        $formMapper->add('enabled', 'text');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('id');
        $datagridMapper->add('username');
        $datagridMapper->add('email');
        $datagridMapper->add('roles');
        $datagridMapper->add('lastLogin');
        $datagridMapper->add('enabled');
        $datagridMapper->add('locked');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('id');
        $listMapper->add('username');
        $listMapper->add('email');
        $listMapper->add('roles');
        $listMapper->add('lastLogin');
        $listMapper->add('enabled');
        $listMapper->add('locked');
    }
    
    public function toString($object) {
        return $object instanceof User 
                ? $object->getUsername() 
                : 'User'; // shown in the breadcrumb on the create view
    }


}
