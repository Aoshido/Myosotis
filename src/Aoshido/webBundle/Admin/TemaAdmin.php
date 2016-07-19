<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class TemaAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('descripcion', 'text');
        $formMapper->add('activo');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('id');
        $datagridMapper->add('descripcion');
        $datagridMapper->add('activo');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('id');
        $listMapper->add('descripcion');
        $listMapper->add('activo');
    }

    public function toString($object) {
        return $object instanceof Tema
                ? $object->getDescripcion() 
                : 'Tema'; // shown in the breadcrumb on the create view
    }

}
