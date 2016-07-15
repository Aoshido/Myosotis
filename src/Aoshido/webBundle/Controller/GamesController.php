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
            $preguntas = $this->getPreguntasFromTemas($pregunta->getTemasActivos(), 0, FALSE);
            if (count($preguntas) == 0) {
                $this->get('session')->getFlashBag()->add('error', 'Oops! Parece que no hay preguntas de esos temas');
                return $this->redirectToRoute('games_cards');
            }
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 4);
        $pagination->setPageRange(6);

        return $this->render('AoshidowebBundle:Games:cards.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function quizAction(Request $request) {

        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta, array(
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $quiz = new Examen();

            $preguntas = $this->getPreguntasFromTemas($pregunta->getTemasActivos(), 0, TRUE);

            if (sizeof($preguntas) == 0) {
                $this->get('session')->getFlashBag()->add('error', 'Oops! Parece que no hay preguntas de esos temas');
                return $this->redirectToRoute('games_quiz');
            }

            $quiz->addPreguntasCollection($preguntas);

            $quizForm = $this->createForm(new ExamenType(), $quiz, array(
                'method' => 'PATCH',
                'action' => $this->generateUrl('games_resultados')
            ));

            $quizForm->add('save', 'submit', array(
                'label' => 'Entregar Examen',
                'attr' => array(
                    'class' => 'btn btn-success'
                ),
            ));
        }

        return $this->render('AoshidowebBundle:Games:quiz.html.twig', array(
                    'form' => $form->createView(),
                    'quizForm' => isset($quizForm) ? $quizForm->createView() : NULL,
                    'quiz' => isset($quiz) ? $quiz : NULL
        ));
    }

    public function resultadosAction(Request $request) {
        $preguntas = $request->get('quiz')['preguntas'];
        $resultados = $this->corregirPreguntas($preguntas);
        
        $session = $request->getSession();
        $session->set('resultados', $resultados);

        return $this->redirectToRoute('games_resultados_show',array(),301);

    }

    public function showAction(Request $request) {
        $session = $request->getSession();
        $resultados = $session->get('resultados');
        
        return $this->render('AoshidowebBundle:Games:results.html.twig', array(
                    'correctas' => $resultados['correctas'],
                    'incorrectas' => $resultados['incorrectas'],
                    'incorrectasEntity' => $resultados['incorrectasEntity'],
                    'noContestadas' => $resultados['noContestadas'],
                    'total' => $resultados['total']
        ));
    }

    public function challengeAction(Request $request) {

        $pregunta = new Pregunta();
        $temasIds = array();

        $form = $this->createForm(new PreguntaType(), $pregunta, array(
            'method' => 'GET',
        ));

        $form->handleRequest($request);

        $preguntas = new ArrayCollection();
        $quizForm = NULL;

        if ($form->isValid()) {
            foreach ($pregunta->getTemas() as $tema) {
                $preguntas_temp = $tema->getPreguntas();
                $temasIds[] = $tema->getId();

                foreach ($preguntas_temp as $pregunta_temp) {
                    if ($pregunta_temp != $pregunta && !$preguntas->contains($pregunta_temp) && $pregunta_temp->getActivo() && count($pregunta_temp->getRespuestas()) > 0) {
                        $preguntas->add($pregunta_temp);
                    }
                }
            }

            if (count($preguntas) == 0) {
                $this->get('session')->getFlashBag()->add('error', 'Oops! Parece que no hay preguntas de esos temas');
                return $this->redirectToRoute('games_challenge');
            }

            $random = rand(0, count($preguntas) - 1);

            $quiz = new Examen();

            $quiz->addPregunta($preguntas[$random]);

            $quizForm = $this->createForm(new ExamenType(), $quiz, array(
                'method' => 'POST',
                'action' => '#'
            ));

            $quizForm->add('save', 'submit', array(
                'label' => 'Contestar',
                'attr' => array(
                    'class' => 'btn btn-primary'
                ),
            ));

            $session = $request->getSession();

            $session->set('temas', $temasIds);
        }

        return $this->render('AoshidowebBundle:Games:challenge.html.twig', array(
                    'quizForm' => $quizForm == NULL ? NULL : $quizForm->createView(),
                    'form' => $form->createView()
        ));
    }

    public function newPreguntaAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $preguntas = $request->get('quiz')['preguntas'];
        $preguntasCorrectasCounter = $request->get('correctas');
        $preguntasIncorrectasCounter = $request->get('incorrectas');

        foreach ($preguntas as $pregunta) {
            $preguntaEntity = $this->getDoctrine()
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->find($pregunta['id']);

            $preguntaEntity->increaseVecesVista();
            $answers = new ArrayCollection();

            foreach ($pregunta['respuestas'] as $respuesta) {
                if (array_key_exists('elegida', $respuesta)) {
                    $respuestaEntity = $this->getDoctrine()
                            ->getRepository('AoshidowebBundle:Respuesta')
                            ->find($respuesta['id']);

                    $answers->add($respuestaEntity);
                }
            }

            if ($preguntaEntity->isAnsweredWith($answers)) {
                $preguntaEntity->increaseVecesAcertada();
                $preguntasCorrectasCounter++;
            } else {
                $preguntasIncorrectasCounter++;
            }
            $em->persist($preguntaEntity);
            $em->flush();
        }

        $session = $request->getSession();
        $temasIds = $session->get('temas');

        $preguntasNuevas = $this->getDoctrine()
                        ->getRepository('AoshidowebBundle:Pregunta')
                        ->createQueryBuilder('p')
                        ->innerJoin('p.respuestas', 'r')
                        ->innerJoin('p.temas', 't')
                        ->where('p.activo = TRUE')
                        ->andWhere('r.activo = TRUE')
                        ->andWhere('t.id IN (:ids)')
                        ->setParameter('ids', $temasIds)
                        ->getQuery()->getResult();

        $random = rand(0, count($preguntasNuevas) - 1);

        $quiz = new Examen();
        $quiz->addPregunta($preguntasNuevas[$random]);

        $quizForm = $this->createForm(new ExamenType(), $quiz, array(
            'method' => 'POST',
            'action' => '#'
        ));

        $quizForm->add('save', 'submit', array(
            'label' => 'Contestar',
            'attr' => array(
                'class' => 'btn btn-primary'
            ),
        ));

        $accuracy = ($preguntasCorrectasCounter / ($preguntasIncorrectasCounter + $preguntasCorrectasCounter)) * 100;

        return $this->render('AoshidowebBundle:Games:pregunta.html.twig', array(
                    'quizForm' => $quizForm->createView(),
                    'accuracy' => $accuracy,
                    'correctas' => $preguntasCorrectasCounter,
                    'incorrectas' => $preguntasIncorrectasCounter,
        ));
    }

    public function corregirPreguntas(array $preguntas) {

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
                        if (!$preguntasIncorrectas->contains($pregunta)) {

                            $preguntasIncorrectas->add($pregunta);
                            $preguntasIncorrectasEntity->add($preguntaEntity);
                        }
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
                    if (!$preguntasIncorrectas->contains($pregunta)) {
                        $preguntasIncorrectas->add($pregunta);
                        $preguntasIncorrectasEntity->add($preguntaEntity);
                    }
                }
            }
            $this->getDoctrine()->getManager()->persist($preguntaEntity);
        }
        $this->getDoctrine()->getManager()->flush();

        $resultados = new ArrayCollection();

        $resultados['correctas'] = $preguntasCorrectas;
        $resultados['incorrectas'] = $preguntasIncorrectas;
        $resultados['incorrectasEntity'] = $preguntasIncorrectasEntity;
        $resultados['noContestadas'] = $preguntasNoContestadas;
        $resultados['total'] = count($preguntas);

        return ($resultados);
    }

    public function getPreguntasFromTemas($temas, $cantidad = 0, $conRespuestas = FALSE) {
        $preguntas = new ArrayCollection();
        foreach ($temas as $tema) {
            $preguntasTemp = $tema->getPreguntasActivas();
            if (count($preguntasTemp) > 0) {
                foreach ($preguntasTemp as $preguntaTemp) {
                    if (!$preguntas->contains($preguntaTemp)) {
                        if ($conRespuestas) {
                            if (count($preguntaTemp->getRespuestas()) > 0) {
                                $preguntas->add($preguntaTemp);
                            }
                        } else {
                            $preguntas->add($preguntaTemp);
                        }
                    }
                }
            }
        }
        //TODO: Split by "cantidad"


        return $preguntas;
    }

}
