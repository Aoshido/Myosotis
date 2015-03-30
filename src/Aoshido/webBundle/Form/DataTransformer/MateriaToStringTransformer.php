<?php

namespace Aoshido\webBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class MateriaToStringTransformer implements DataTransformerInterface
{

    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * @param \Aoshido\webBundle\Entity\Materia|null $materia
     * @return string
     */
    public function transform($materia)
    {
        if (null === $materia) {
            return '';
        }       
        return $materia->getIdmateria();
    }

    /**
     * @param  string $materiareverse
     * @return \Aoshido\webBundle\Entity\Materia
     */
    public function reverseTransform($materiareverse)
    {
        $materia = $this->om
            ->getRepository('AoshidowebBundle:Materia')
            ->find($materiareverse);
        
        return $materia;
    }
} 