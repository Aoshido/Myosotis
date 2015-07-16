<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Tema
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Tema {

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
    private $descripcion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\ManyToOne(targetEntity="Materia", inversedBy="temas")
     * @ORM\JoinColumn(name="IdMateria", referencedColumnName="id")
     */
    protected $materia;

    /**
     * @ORM\ManyToMany(targetEntity="Pregunta", mappedBy="temas")
     * */
    private $preguntas;

    public function __construct() {
        $this->preguntas = new ArrayCollection();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Tema
     */
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Tema
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
     * Set materia
     *
     * @param \Aoshido\webBundle\Entity\Materia $materia
     * @return Tema
     */
    public function setMateria(\Aoshido\webBundle\Entity\Materia $materia = null) {
        $this->materia = $materia;

        return $this;
    }

    /**
     * Get materia
     *
     * @return \Aoshido\webBundle\Entity\Materia 
     */
    public function getMateria() {
        return $this->materia;
    }

    /**
     * Add preguntas
     *
     * @param \Aoshido\webBundle\Entity\Pregunta $preguntas
     * @return Tema
     */
    public function addPregunta(\Aoshido\webBundle\Entity\Pregunta $preguntas) {
        $this->preguntas[] = $preguntas;

        return $this;
    }

    /**
     * Remove preguntas
     *
     * @param \Aoshido\webBundle\Entity\Pregunta $preguntas
     */
    public function removePregunta(\Aoshido\webBundle\Entity\Pregunta $preguntas) {
        $preguntas->removeTema($this);
        $this->preguntas->removeElement($preguntas);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntas() {
        return $this->preguntas;
    }

}
