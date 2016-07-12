<?php

namespace Aoshido\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="current_experience", type="integer")
     */
    protected $currentExperience;

    public function __construct() {
        parent::__construct();
        // your own logic
        $this->addRole('ROLE_STUDENT');
    }

    /**
     * Set currentExperience
     *
     * @param integer $currentExperience
     *
     * @return User
     */
    public function setCurrentExperience($currentExperience) {
        $this->currentExperience = $currentExperience;

        return $this;
    }

    /**
     * Get currentExperience
     *
     * @return integer
     */
    public function getCurrentExperience() {
        return $this->currentExperience;
    }
    
    
    /**
     * Set currentExperience
     *
     * @param integer $experience
     *
     * @return User
     */
    public function addExperience($experience) {
        $this->currentExperience += $experience;

        return $this;
    }

}
