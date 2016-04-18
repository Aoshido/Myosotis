<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->with('Contenido')
                    ->add('username', 'text')
                    ->add('email', 'text')
                    ->add('password', 'text')
                ->end()
                ->with('Lifecycle')
                    ->add('locked', 'choice')
                    ->add('lastLogin', 'datetime')
                ->end()
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('username')
                ->add('email')
                ->add('password')
                ->add('locked')
                ->add('lastLogin')
        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('username')
                ->addIdentifier('email')
                //->addIdentifier('password')
                ->addIdentifier('locked')
                ->addIdentifier('lastLogin');
    }

}
