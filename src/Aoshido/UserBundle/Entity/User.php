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

    /**
     * @ORM\Column(name="level", type="integer")
     */
    protected $level;

    /**
     * @ORM\Column(name="class", type="integer")
     */
    protected $class;

    public function __construct() {
        parent::__construct();
        // your own logic
        $this->addRole('ROLE_STUDENT');
        $this->setCurrentExperience(0);
        $this->setLevel(1);
        $this->setClass(0);
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
        $nextLevelExp = pow($this->getLevel(), 2);

        if ($this->currentExperience >= $nextLevelExp) {
            $this->currentExperience = 0;
            $this->level += 1;
        }

        return $this;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return User
     */
    public function setLevel($level) {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel() {
        return $this->level;
    }

    /**
     * Set class
     *
     * @param integer $class
     *
     * @return User
     */
    public function setClass($class) {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return integer
     */
    public function getClass() {
        return $this->class;
    }

}
