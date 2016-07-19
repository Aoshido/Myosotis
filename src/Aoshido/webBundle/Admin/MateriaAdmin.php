<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MateriaAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper->add('descripcion', 'text');
        $formMapper->add('anioCarrera', 'text');
        $formMapper->add('temas', 'sonata_type_collection', array('by_reference' => true), array(
            'edit' => 'inline',
            'sortable' => 'pos',
            'inline' => 'table',));
        $formMapper->add('carreras', 'sonata_type_collection', array('by_reference' => true), array(
            'edit' => 'inline',
            'sortable' => 'pos',
            'inline' => 'table',));
        $formMapper->add('activo');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper->add('id');
        $datagridMapper->add('descripcion');
        $datagridMapper->add('anioCarrera');
        $datagridMapper->add('activo');
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper->addIdentifier('id');
        $listMapper->add('descripcion');
        $listMapper->add('anioCarrera');
        $listMapper->add('activo');
    }

    public function toString($object) {
        return $object instanceof Materia 
                ? $object->getDescripcion() 
                : 'Materia'; // shown in the breadcrumb on the create view
    }

}
