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
                    if ($pregunta_temp != $pregunta && !$quiz->getPreguntas()->contains($pregunta_temp) && $pregunta_temp->getActivo()) {
                        $quiz->addPregunta($pregunta_temp);
                    }
                }
            }

            $quizForm = $this->createForm(new ExamenType(), $quiz, array(
                'method' => 'PATCH',
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
        $preguntas = $request->get('quiz')['preguntas'];
        $preguntasCorrectas = new ArrayCollection();
        $preguntasIncorrectas = new ArrayCollection();
        $preguntasIncorrectasEntity = new ArrayCollection();
        $preguntasNoContestadas = new ArrayCollection();

        foreach ($preguntas as &$pregunta) {
            $noContestada = FALSE;
            $bienContestada = FALSE;
            $malContestada = FALSE;

            $preguntaEntity = $this->getDoctrine()
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->find($pregunta['id']);

            $preguntaEntity->increaseVecesVista();

            //Reviso si la respuesta que eligio es alguna de las correctas
            $correctas = 0;
            foreach ($pregunta['respuestas'] as &$respuesta) {
                if (array_key_exists('elegida', $respuesta)) {

                    $respuestaEntity = $this->getDoctrine()
                            ->getRepository('AoshidowebBundle:Respuesta')
                            ->find($respuesta['id']);

                    if ($preguntaEntity->getRespuestasCorrectas()->contains($respuestaEntity)) {
                        $correctas++;
                    } else {
                        $malContestada = TRUE;
                        $preguntasIncorrectas->add($pregunta);
                        $preguntasIncorrectasEntity->add($preguntaEntity);
                    }
                } else {
                    $respuesta['elegida'] = "0"; 
                }
            }

            //Si no hay nignuna opcion correcta , ni incorrecta es pq no contesto
            if ($correctas == 0 && $malContestada == FALSE) {
                $noContestada = TRUE;
                $preguntasNoContestadas->add($preguntaEntity);
            } else {
                //Me fijo que haya elegido TODAS las respuestas correctas
                if ($correctas == count($preguntaEntity->getRespuestasCorrectas()) && $malContestada == FALSE) {
                    $bienContestada = TRUE;
                    $preguntasCorrectas->add($preguntaEntity);
                    $preguntaEntity->increaseVecesAcertada();
                } else {
                    $malContestada = TRUE;
                }
            }
        }
        
        $this->getDoctrine()->getManager()->persist($preguntaEntity);
        $this->getDoctrine()->getManager()->flush();

        /*
         * Esto va a tene que redirigir a otra pagina (Show) para evitar
         * Que le sigan dando al f5 y sigan posetando sus resultados, cual plebe
         */
        return $this->render('AoshidowebBundle:Games:results.html.twig', array(
                    'correctas' => $preguntasCorrectas,
                    'incorrectas' => $preguntasIncorrectas,
                    'incorrectasEntity' => $preguntasIncorrectasEntity,
                    'noContestadas' => $preguntasNoContestadas,
                    'total' => count($preguntas)
        ));
    }

}
