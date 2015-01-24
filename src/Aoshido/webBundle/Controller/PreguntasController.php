<?php

namespace Aoshido\webBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PreguntasController extends Controller {

    public function newAction(Request $request) {
        //Display a list of all Preguntas
        $preguntas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Pregunta')
                ->findBy(array('activo' => TRUE));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($preguntas);
        
        $pregunta = new Pregunta();
        $form = $this->createFormPregunta($pregunta);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $pregunta->setActivo(TRUE);
            $pregunta->setVecesVista(0);
            $pregunta->setVecesAcertada(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($pregunta);
            $em->flush();
            return $this->redirect($this->generateUrl('preguntas_ABM'));
        }



        return $this->render('AoshidowebBundle:Preguntas:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
        ));
    }

}
