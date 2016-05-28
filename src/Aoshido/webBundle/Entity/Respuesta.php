<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Respuesta
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Respuesta {

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
     * @Assert\NotNull(message = "El contenido no puede estar vacio")
     * @Assert\NotBlank(message = "El contenido no puede estar vacio")
     * @ORM\Column(name="Contenido", type="text")
     */
    private $contenido;

    /**
     * @var boolean
     * @Assert\NotBlank(message = "La respuesta debe ser verdadera o falsa")
     * @ORM\Column(name="Correcta", type="boolean")
     */
    private $correcta;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Aceptada", type="boolean", options={"default" = FALSE})
     */
    private $aceptada;

    /**
     * @ORM\ManyToOne(targetEntity="Pregunta", inversedBy="respuestas")
     * @ORM\JoinColumn(name="IdPregunta", referencedColumnName="id")
     */
    protected $pregunta;

    /**
     * @var datetime
     *
     * @ORM\Column(type="datetime")
     */
    protected $creada;

    /**
     * Now we tell doctrine that before we persist or update we call the updatedTimestamps() function.
     *
     * @ORM\PrePersist
     */
    public function setDefaults() {
        $this->aceptada = false;
        $this->creada = new \DateTime();
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
     * Set contenido
     *
     * @param string $contenido
     * @return Respuesta
     */
    public function setContenido($contenido) {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido() {
        return $this->contenido;
    }

    /**
     * Set correcta
     *
     * @param boolean $correcta
     * @return Respuesta
     */
    public function setCorrecta($correcta) {
        $this->correcta = $correcta;

        return $this;
    }

    /**
     * Get correcta
     *
     * @return boolean 
     */
    public function getCorrecta() {
        return $this->correcta;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Respuesta
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
     * Get aceptada
     *
     * @return boolean 
     */
    public function getAceptada() {
        return $this->aceptada;
    }

    /**
     * Set aceptada
     *
     * @param boolean $aceptada
     * @return Respuesta
     */
    public function setAceptada($aceptada) {
        $this->aceptada = $aceptada;
    }

    /**
     * Set Pregunta
     *
     * @param \Aoshido\webBundle\Entity\Pregunta $pregunta
     * @return Respuesta
     */
    public function setPregunta(\Aoshido\webBundle\Entity\Pregunta $pregunta = null) {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get Pregunta
     *
     * @return \Aoshido\webBundle\Entity\Pregunta 
     */
    public function getPregunta() {
        return $this->pregunta;
    }

    /**
     * Set creada
     *
     * @param \DateTime $creada
     *
     * @return Respuesta
     */
    public function setCreada($creada) {
        $this->creada = $creada;

        return $this;
    }

    /**
     * Get creada
     *
     * @return \DateTime
     */
    public function getCreada() {
        return $this->creada;
    }

}
