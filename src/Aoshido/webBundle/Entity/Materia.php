<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Materia
 *
 * @ORM\Table()
 * @UniqueEntity( 
 *          fields = "descripcion",
 *          message = "Ya existe una materia con ese nombre",
 * )
 * @ORM\Entity
 */
class Materia {

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
     * @Assert\NotNull(message = "La descripcion no puede estar vacia")
     * @Assert\NotBlank(message = "La descripcion no puede estar vacia")
     */
    private $descripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="AnioCarrera", type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 6,
     *      minMessage = "La materia debe pertenecer al menos al {{ limit }}er año",
     *      maxMessage = "La materia debe pertenecer como maximo {{ limit }}to año"
     * )
     */
    private $anioCarrera;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Activo", type="boolean")
     */
    private $activo;

    /**
     * @ORM\OneToMany(targetEntity="Tema", mappedBy="materia")
     */
    protected $temas;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="Carrera", inversedBy="materias"  )
     * @ORM\JoinTable(name="MateriasCarreras")
     * @Assert\Count(
     *      min = "1",
     *      minMessage = "La materia debe pertenecer a alguna carrera",
     * )
     * */
    private $carreras;

    public function __construct() {
        $this->temas = new ArrayCollection();
        $this->carreras = new ArrayCollection();
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
     * @return Materia
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
     * Set anioCarrera
     *
     * @param integer $anioCarrera
     * @return Materia
     */
    public function setAnioCarrera($anioCarrera) {
        $this->anioCarrera = $anioCarrera;

        return $this;
    }

    /**
     * Get anioCarrera
     *
     * @return integer 
     */
    public function getAnioCarrera() {
        return $this->anioCarrera;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Materia
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
     * Add temas
     *
     * @param \Aoshido\webBundle\Entity\Tema $temas
     * @return Materia
     */
    public function addTema(\Aoshido\webBundle\Entity\Tema $temas) {
        $this->temas[] = $temas;

        return $this;
    }

    /**
     * Remove temas
     *
     * @param \Aoshido\webBundle\Entity\Tema $temas
     */
    public function removeTema(\Aoshido\webBundle\Entity\Tema $temas) {
        $temas->setActivo(false);
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
     * Add carreras
     *
     * @param \Aoshido\webBundle\Entity\Carrera $carreras
     * @return Materia
     */
    public function addCarrera(\Aoshido\webBundle\Entity\Carrera $carreras) {
        $this->carreras[] = $carreras;

        return $this;
    }

    /**
     * Remove carreras
     *
     * @param \Aoshido\webBundle\Entity\Carrera $carreras
     */
    public function removeCarrera(\Aoshido\webBundle\Entity\Carrera $carreras) {
        //Si me quedo sin Carreras asociadas, me borro al chizo
        $this->carreras->removeElement($carreras);
        if (count($this->carreras) == 0) {
            $this->setActivo('false');
        }
    }

    /**
     * Get carreras
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCarreras() {
        return $this->carreras;
    }

    /**
     * Get Carreras Activos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCarrerasActivas() {
        $carrerasActivos = new ArrayCollection();

        foreach ($this->carreras as $carrera) {
            if ($carrera->getActivo()) {
                $carrerasActivos->add($carrera);
            }
        }
        return $carrerasActivos;
    }

}
