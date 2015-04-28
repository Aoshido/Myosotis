<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Carrera
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Carrera {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Descripcion", type="text")
     */
    private $Descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToMany(targetEntity="Materia", mappedBy="carreras", cascade={"persist"})
     * */
    private $materias;

    public function __construct() {
        $this->materias = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set Descripcion
     *
     * @param string $Descripcion
     * @return Carrera
     */
    public function setDescripcion($Descripcion) {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    /**
     * Get Descripcion
     *
     * @return string 
     */
    public function getDescripcion() {
        return $this->Descripcion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Carrera
     */
    public function setActivo($activo) {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo() {
        return $this->activo;
    }

    /**
     * Add materias
     *
     * @param \Aoshido\webBundle\Entity\Materia $materias
     * @return Carrera
     */
    public function addMateria(\Aoshido\webBundle\Entity\Materia $materias) {
        $materias->addCarrera($this);
        $this->materias[] = $materias;

        return $this;
    }

    /**
     * Remove materias
     *
     * @param \Aoshido\webBundle\Entity\Materia $materias
     */
    public function removeMateria(\Aoshido\webBundle\Entity\Materia $materias) {
        $materias->removeCarrera($this);
        $this->materias->removeElement($materias);
    }

    /**
     * Get materias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaterias() {
        return $this->materias;
    }

}
