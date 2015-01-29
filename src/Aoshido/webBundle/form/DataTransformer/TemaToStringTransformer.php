<?php

namespace Aoshido\webBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class TemaToStringTransformer implements DataTransformerInterface
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
     * @param \Aoshido\webBundle\Entity\Tema|null $tema
     * @return string
     */
    public function transform($tema)
    {
        if (null === $tema) {
            return '';
        }       
        return $tema->getIdtema();
    }

    /**
     * @param  string $temareverse
     * @return \Aoshido\webBundle\Entity\Tema
     */
    public function reverseTransform($temareverse)
    {
        $tema = $this->om
            ->getRepository('AoshidowebBundle:Tema')
            ->find($temareverse);
        
        return $tema
;    }
} 