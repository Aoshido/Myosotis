<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Carrera
 *
 * @ORM\Table()
 * @UniqueEntity( 
 *          fields = "Descripcion",
 *          message = "Ya existe una carrera con ese nombre",
 * )
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
     * @Assert\NotBlank(message = "La descripcion no puede estar vacia")
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
     * @ORM\ManyToMany(targetEntity="Materia", mappedBy="carreras", cascade={"persist"} , fetch="EAGER")
     * @Assert\Valid
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
        if (!$activo) {
            foreach ($this->materias as $materia) {
                $this->removeMateria($materia);
            }
        }

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
        $materias->setActivo(true);
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

    /**
     * Get materias activas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMateriasActivas() {
        $materiasActivas = new ArrayCollection();
        foreach ($this->materias as $materia) {
            if ($materia->getActivo()) {
                $materiasActivas->add($materia);
            }
        }
        return $materiasActivas;
    }
    
    /**
     * Get preguntas activas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntasActivas(){
        $preguntasTotales = new ArrayCollection();
        
        foreach ($this->getMateriasActivas() as $materia) {
            $preguntasTotales = $materia->getPreguntasActivas();
        }
        
        return $preguntasTotales;
    }

}
