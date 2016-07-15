<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

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
    protected $id;

    /**
     * @var string
     * @Assert\NotNull(message = "El contenido no puede estar vacio")
     * @Assert\NotBlank(message = "El contenido no puede estar vacio")
     * @ORM\Column(name="Contenido", type="text")
     */
    protected $contenido;

    /**
     * @var integer
     *
     * @ORM\Column(name="VecesVista", type="integer")
     */
    protected $vecesVista;

    /**
     * @var integer
     *
     * @ORM\Column(name="VecesAcertada", type="integer")
     */
    protected $vecesAcertada;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    protected $activo;

    /**
     * @ORM\OneToMany(targetEntity="Respuesta", mappedBy="pregunta", cascade={"persist"})
     */
    protected $respuestas;

    /**
     * @ORM\ManyToOne(targetEntity="Aoshido\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="IdUser", referencedColumnName="id")
     */
    protected $creatorUser;

    /**
     * @ORM\ManyToMany(targetEntity="Tema", inversedBy="preguntas", cascade={"persist"}, fetch="EAGER")
     * @ORM\JoinTable(name="PreguntasTemas")
     * */
    protected $temas;

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
     * increase vecesVista
     *
     * @return Pregunta
     */
    public function increaseVecesVista() {
        $this->vecesVista++;
        return $this;
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
     * increase vecesAcertada
     *
     * @return Pregunta
     */
    public function increaseVecesAcertada() {
        $this->vecesAcertada++;
        return $this;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Pregunta
     */
    public function setActivo($activo) {
        $this->activo = $activo;

        if (!$activo) {
            foreach ($this->respuestas as $respuesta) {
                $this->removeRespuesta($respuesta);
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
     * Set creatorUser
     *
     * @param \Aoshido\UserBundle\Entity\User $creatorUser
     * @return creatorUser
     */
    public function setCreatorUser(\Aoshido\UserBundle\Entity\User $creatorUser = null) {
        $this->creatorUser = $creatorUser;

        return $this;
    }

    /**
     * Get creatorUser
     *
     * @return \Aoshido\UserBundle\Entity\User
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
        $respuestas->setActivo(FALSE);
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
        if (count($this->temas) == 0) {
            $this->setActivo('false');
        }
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

    /**
     * Set examen
     *
     * @param \Aoshido\webBundle\Entity\Examen $examen
     *
     * @return Pregunta
     */
    public function setExamen(\Aoshido\webBundle\Entity\Examen $examen = null) {
        $this->examen = $examen;

        return $this;
    }

    /**
     * Get examen
     *
     * @return \Aoshido\webBundle\Entity\Examen
     */
    public function getExamen() {
        return $this->examen;
    }

    /**
     * getRespuestasCorectas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestasCorrectas() {
        $respuestasCorrectas = new ArrayCollection();

        foreach ($this->respuestas as $respuesta) {
            if ($respuesta->getCorrecta()) {
                $respuestasCorrectas->add($respuesta);
            }
        }
        return $respuestasCorrectas;
    }

    /**
     * getDificultad
     *
     * @return float
     */
    public function getDificultad() {
        if ($this->vecesVista > 0) {
            $dificultad = 101 - ($this->vecesAcertada > 0 ? ($this->vecesAcertada / $this->vecesVista) * 100 : 1);
        } else {
            $dificultad = 0;
        }
        return $dificultad;
    }

    /**
     * isAnsweredWith
     * 
     * @param \Doctrine\Common\Collections\Collection $answers
     *
     * @return boolean
     */
    public function isAnsweredWith($answers) {
        $correctAnswers = $this->getRespuestasCorrectas();

        if (sizeof($correctAnswers) != sizeof($answers)) {
            return false;
        }

        foreach ($answers as $answer) {
            if (!$correctAnswers->contains($answer)) {
                return false;
            }
        }

        return true;
    }
    
    /**
     * getMateria()
     *
     * @return \Aoshido\webBundle\Entity\Materia
     */
    public function getMateria(){
        $temaPivote = $this->getTemasActivos()->first();
        return $temaPivote->getMateria();      
    }

}
