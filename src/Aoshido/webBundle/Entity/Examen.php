<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Quiz
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Examen {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Pregunta", mappedBy="examen")
     */
    protected $preguntas;

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
    public function updatedTimestamps() {
        $this->creada = new \DateTime();
    }

    public function __construct() {
        $this->temas = new ArrayCollection();
        $this->respuestas = new ArrayCollection();
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
     * Add preguntas
     *
     * @param \Aoshido\webBundle\Entity\Pregunta $preguntas
     * @return Examen
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
        $this->respuestas->removeElement($preguntas);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPregunta() {
        return $this->preguntas;
    }

    /**
     * Set creada
     *
     * @param \DateTime $creada
     *
     * @return Pregunta
     */
    public function setCreada($creada)
    {
        $this->creada = $creada;

        return $this;
    }

    /**
     * Get creada
     *
     * @return \DateTime
     */
    public function getCreada()
    {
        return $this->creada;
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }
}
