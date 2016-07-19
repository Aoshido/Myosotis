<?php

namespace Aoshido\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('currentExperience');
    }

    public function getParent() {
        

        // Or for Symfony < 2.8
        return 'fos_user_profile';
    }

    public function getBlockPrefix() {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName() {
        return $this->getBlockPrefix();
    }

}
