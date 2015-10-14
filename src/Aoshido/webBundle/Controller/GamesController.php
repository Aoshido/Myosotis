<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Entity\Examen;

use Aoshido\webBundle\Form\PreguntaType;
use Aoshido\webBundle\Form\ExamenType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

class GamesController extends Controller {

    public function cardsAction(Request $request) {

        $pregunta = new Pregunta();

        $form = $this->createForm(new PreguntaType(), $pregunta, array(
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        $preguntas = new ArrayCollection();

        if ($form->isValid()) {
            foreach ($pregunta->getTemas() as $tema) {
                $preguntas_temp = $tema->getPreguntas();
                foreach ($preguntas_temp as $pregunta_temp) {
                    if ($pregunta_temp != $pregunta && !$preguntas->contains($pregunta_temp) && $pregunta_temp->getActivo()) {
                        $preguntas->add($pregunta_temp);
                    }
                }
            }
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 4);
        $pagination->setPageRange(6);

        $cantidad = count($preguntas);

        return $this->render('AoshidowebBundle:Games:cards.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
        ));
    }

    public function quizAction(Request $request) {

        $pregunta = new Pregunta();

        $form = $this->createForm(new PreguntaType(), $pregunta, array(
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        $preguntas = new ArrayCollection();

        if ($form->isValid()) {
            $quiz = new Examen();

            foreach ($pregunta->getTemas() as $tema) {
                $preguntas_temp = $tema->getPreguntas();
                foreach ($preguntas_temp as $pregunta_temp) {
                    if ($pregunta_temp != $pregunta && !$preguntas->contains($pregunta_temp) && $pregunta_temp->getActivo()) {
                        $quiz->addPregunta($pregunta_temp);
                    }
                }
            }

            $quizForm = $this->createForm(new ExamenType(), $quiz, array(
                'method' => 'POST',
                'action' => $this->generateUrl('games_resultados')
            ));

            return $this->render('AoshidowebBundle:Games:quiz.html.twig', array(
                        'form' => $form->createView(),
                        'quizForm' => $quizForm->createView(),
                        'quiz' => $quiz
            ));
        }

        return $this->render('AoshidowebBundle:Games:quiz.html.twig', array(
                    'form' => $form->createView(),
                    'quizForm' => NULL,
                    'quiz' => NULL
        ));
    }

    public function resultadosAction(Request $request) {

        $quiz = new Examen();
        /*$preguntas = $this->getDoctrine()
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->findBy(array('activo' => TRUE));
        
        foreach ($preguntas as $pregunta){
            $quiz->addPregunta($pregunta);
        }*/

        
        $quizForm = $this->createForm(new ExamenType(), $quiz, array(
            'method' => 'POST',
            'action' => $this->generateUrl('games_resultados')
        ));
        
        $quizForm->handleRequest($request);
        
        if ($quizForm->isValid()){
            dump($quizForm);
            dump($quiz);
            die();
        }else{
            dump($quizForm->getErrors());
            //die();
        }
        

        return $this->render('AoshidowebBundle:Games:results.html.twig', array(
                    'quizForm' => $quizForm->createView(),
        ));
    }

}
