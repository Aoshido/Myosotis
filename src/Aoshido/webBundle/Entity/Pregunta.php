<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pregunta
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Pregunta
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set contenido
     *
     * @param string $contenido
     * @return Pregunta
     */
    public function setContenido($contenido)
    {
        $this->contenido = $contenido;

        return $this;
    }

    /**
     * Get contenido
     *
     * @return string 
     */
    public function getContenido()
    {
        return $this->contenido;
    }

    /**
     * Set vecesVista
     *
     * @param integer $vecesVista
     * @return Pregunta
     */
    public function setVecesVista($vecesVista)
    {
        $this->vecesVista = $vecesVista;

        return $this;
    }

    /**
     * Get vecesVista
     *
     * @return integer 
     */
    public function getVecesVista()
    {
        return $this->vecesVista;
    }

    /**
     * Set vecesAcertada
     *
     * @param integer $vecesAcertada
     * @return Pregunta
     */
    public function setVecesAcertada($vecesAcertada)
    {
        $this->vecesAcertada = $vecesAcertada;

        return $this;
    }

    /**
     * Get vecesAcertada
     *
     * @return integer 
     */
    public function getVecesAcertada()
    {
        return $this->vecesAcertada;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Pregunta
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
