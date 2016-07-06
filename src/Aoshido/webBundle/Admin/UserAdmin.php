<?php

namespace Aoshido\webBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class UserAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $container = $this->getConfigurationPool()->getContainer();
        $roles = $container->getParameter('security.role_hierarchy.roles');

        $rolesChoices = self::flattenRoles($roles);

        $formMapper->add('username', 'text');
        $formMapper->add('email', 'text');
        $formMapper->add('roles', 'text');
        $formMapper->add('enabled', 'text');
        $formMapper
                //...
                ->add('roles', 'choice', array(
                    'choices' => $rolesChoices,
                    'multiple' => true
                        )
        );
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
        return $object instanceof User ? $object->getUsername() : 'User'; // shown in the breadcrumb on the create view
    }

    /**
     * Turns the role's array keys into string <ROLES_NAME> keys.
     * @todo Move to convenience or make it recursive ? ;-)
     */
    protected static function flattenRoles($rolesHierarchy) {
        $flatRoles = array();
        foreach ($rolesHierarchy as $roles) {

            if (empty($roles)) {
                continue;
            }

            foreach ($roles as $role) {
                if (!isset($flatRoles[$role])) {
                    $flatRoles[$role] = $role;
                }
            }
        }

        return $flatRoles;
    }

}
