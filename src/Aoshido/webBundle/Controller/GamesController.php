<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

class GamesController extends Controller {

    public function settingsAction(Request $request) {

        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta, array('method' => 'PATCH'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $preguntas = new ArrayCollection();
            foreach ($pregunta->getTemas() as $tema) {
                $preguntas_temp = $tema->getPreguntas();
                foreach ($preguntas_temp as $pregunta_temp) {
                    if ($pregunta_temp != $pregunta && !$preguntas->contains($pregunta_temp)){
                        $preguntas->add($pregunta_temp);
                    }
                }
            }


            return $this->quizAction($preguntas);
        }

        return $this->render('AoshidowebBundle:Games:quiz.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function quizAction($preguntas) {
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($preguntas);

        return $this->render('AoshidowebBundle:Games:play.html.twig', array(
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
        ));
    }

}
