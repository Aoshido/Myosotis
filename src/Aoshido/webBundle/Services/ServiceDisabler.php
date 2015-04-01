<?php

namespace Aoshido\webBundle\Services;

class ServiceDisabler {

    protected $entityManager;

    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    public function disablePregunta($idPregunta) {

        $pregunta = $this->entityManager
                ->getRepository('AoshidowebBundle:Pregunta')
                ->find($idPregunta);

        $pregunta->setActivo(false);

        $this->entityManager->persist($pregunta);
        $this->entityManager->flush();

        return TRUE;
    }

    public function disableTema($idTema) {

        $em = $this->entityManager;

        $tema = $em->getRepository('AoshidowebBundle:Tema')
                ->find($idTema);

        $preguntas = $tema->getPreguntas();

        foreach ($preguntas as $pregunta) {
            $temas = $pregunta->getTemasActivos();

            //Si este es el ultimo tema activo de esta pregunta, se vá
            if (count($temas) == 1) {
                $this->disablePregunta($pregunta->getId());
            }
        }
        $tema->setActivo(false);

        $em->persist($tema);
        $em->flush();

        return TRUE;
    }

    public function disableMateria($idMateria) {

        $em = $this->entityManager;

        $materia = $em->getRepository('AoshidowebBundle:Materia')
                ->find($idMateria);

        $temas = $materia->getTemas();

        foreach ($temas as $tema) {
            $this->disableTema($tema->getId());
        }
        $materia->setActivo(false);

        $em->persist($materia);
        $em->flush();

        return TRUE;
    }

}
