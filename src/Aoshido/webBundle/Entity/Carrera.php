<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carrera
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Carrera
{
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Descripcion
     *
     * @param string $Descripcion
     * @return Carrera
     */
    public function setDescripcion($Descripcion)
    {
        $this->Descripcion = $Descripcion;

        return $this;
    }

    /**
     * Get Descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->Descripcion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Carrera
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;

        return $this;
    }

    /**
     * Get activo
     *
     * @return boolean 
     */
    public function getActivo()
    {
        return $this->activo;
    }
}
