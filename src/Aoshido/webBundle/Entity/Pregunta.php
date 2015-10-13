<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Pregunta
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Pregunta {

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
     * @ORM\Column(name="Contenido", type="text")
     */
    private $contenido;

    /**
     * @var integer
     *
     * @ORM\Column(name="VecesVista", type="integer")
     */
    private $vecesVista;

    /**
     * @var integer
     *
     * @ORM\Column(name="VecesAcertada", type="integer")
     */
    private $vecesAcertada;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\OneToMany(targetEntity="Respuesta", mappedBy="pregunta")
     */
    protected $respuestas;

    /**
     * @ORM\ManyToOne(targetEntity="Aoshido\userBundle\Entity\User")
     * @ORM\JoinColumn(name="IdUser", referencedColumnName="id")
     */
    protected $creatorUser;

    /**
     * @ORM\ManyToMany(targetEntity="Tema", inversedBy="preguntas", cascade={"persist"})
     * @ORM\JoinTable(name="PreguntasTemas")
     * */
    private $temas;

    /**
     * @var datetime
     *
     * @ORM\Column(type="datetime")
     */
    protected $creada;
    
     /**
     * @ORM\ManyToOne(targetEntity="Examen", inversedBy="preguntas")
     * @ORM\JoinColumn(name="IdExamen", referencedColumnName="id")
     */
    protected $examen;

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
     * Set contenido
     *
     * @param string $contenido
     * @return Pregunta
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
     * Set vecesVista
     *
     * @param integer $vecesVista
     * @return Pregunta
     */
    public function setVecesVista($vecesVista) {
        $this->vecesVista = $vecesVista;

        return $this;
    }

    /**
     * Get vecesVista
     *
     * @return integer 
     */
    public function getVecesVista() {
        return $this->vecesVista;
    }

    /**
     * Set vecesAcertada
     *
     * @param integer $vecesAcertada
     * @return Pregunta
     */
    public function setVecesAcertada($vecesAcertada) {
        $this->vecesAcertada = $vecesAcertada;

        return $this;
    }

    /**
     * Get vecesAcertada
     *
     * @return integer 
     */
    public function getVecesAcertada() {
        return $this->vecesAcertada;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Pregunta
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
     * Set creatorUser
     *
     * @param \Aoshido\userBundle\Entity\User $creatorUser
     * @return creatorUser
     */
    public function setCreatorUser(\Aoshido\userBundle\Entity\User $creatorUser = null) {
        $this->creatorUser = $creatorUser;

        return $this;
    }

    /**
     * Get creatorUser
     *
     * @return \Aoshido\userBundle\Entity\User
     */
    public function getCreatorUser() {
        return $this->creatorUser;
    }

    /**
     * Add respuestas
     *
     * @param \Aoshido\webBundle\Entity\Respuesta $respuestas
     * @return Pregunta
     */
    public function addRespuesta(\Aoshido\webBundle\Entity\Respuesta $respuestas) {
        $this->respuestas[] = $respuestas;

        return $this;
    }

    /**
     * Remove respuestas
     *
     * @param \Aoshido\webBundle\Entity\Respuesta $respuestas
     */
    public function removeRespuesta(\Aoshido\webBundle\Entity\Respuesta $respuestas) {
        $this->respuestas->removeElement($respuestas);
    }

    /**
     * Get respuestas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestas() {
        return $this->respuestas;
    }

    /**
     * Add temas
     *
     * @param \Aoshido\webBundle\Entity\Tema $temas
     * @return Pregunta
     */
    public function addTema(\Aoshido\webBundle\Entity\Tema $temas) {
        $temas->addPregunta($this);
        $this->temas[] = $temas;

        return $this;
    }

    /**
     * Remove temas
     *
     * @param \Aoshido\webBundle\Entity\Tema $temas
     */
    public function removeTema(\Aoshido\webBundle\Entity\Tema $temas) {
        $this->temas->removeElement($temas);
    }

    /**
     * Get temas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTemas() {
        return $this->temas;
    }

    /**
     * Get temas Activos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTemasActivos() {
        $temasActivos = new ArrayCollection();

        foreach ($this->temas as $tema) {
            if ($tema->getActivo()) {
                $temasActivos->add($tema);
            }
        }
        return $temasActivos;
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
     * Set examen
     *
     * @param \Aoshido\webBundle\Entity\Examen $examen
     *
     * @return Pregunta
     */
    public function setExamen(\Aoshido\webBundle\Entity\Examen $examen = null)
    {
        $this->examen = $examen;

        return $this;
    }

    /**
     * Get examen
     *
     * @return \Aoshido\webBundle\Entity\Examen
     */
    public function getExamen()
    {
        return $this->examen;
    }
}
