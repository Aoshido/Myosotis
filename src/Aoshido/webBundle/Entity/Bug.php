<?php

namespace Aoshido\webBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bug
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Bug {

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
     * @ORM\Column(name="contenido", type="string", length=600)
     */
    private $contenido;

    /**
     * @var string
     *
     * @ORM\Column(name="respuesta", type="string", length=600)
     */
    private $respuesta;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Aoshido\userBundle\Entity\User", inversedBy="reportedBugs")
     * @ORM\JoinColumn(name="IdUser", referencedColumnName="id")
     */
    protected $reportedUser;

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
     *
     * @return Bug
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
     * Set respuesta
     *
     * @param string $respuesta
     *
     * @return Bug
     */
    public function setRespuesta($respuesta) {
        $this->respuesta = $respuesta;

        return $this;
    }

    /**
     * Get respuesta
     *
     * @return string
     */
    public function getRespuesta() {
        return $this->respuesta;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Bug
     */
    public function setStatus($status) {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

}
