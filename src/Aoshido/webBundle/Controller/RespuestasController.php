<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Respuesta;
use Aoshido\webBundle\Form\RespuestaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RespuestasController extends Controller {

    public function newAction(Request $request, $idPregunta) {
        $respuestas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Respuesta')
                ->findBy(array('activo' => TRUE, 'pregunta' => $idPregunta));

        $pregunta = $this->getDoctrine()->getRepository('AoshidowebBundle:Pregunta')->find($idPregunta);


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($respuestas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($respuestas);

        $respuesta = new Respuesta();
        $form = $this->createForm(new RespuestaType(), $respuesta);

        $form->add('save', 'submit', array(
            'label' => 'Agregar Respuesta',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $respuesta->setActivo(TRUE);
            $respuesta->setPregunta($pregunta);

            $em = $this->getDoctrine()->getManager();
            $em->persist($respuesta);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Respuesta agregada !');
            return $this->redirect($this->generateUrl('respuestas_new', array('idPregunta' => $idPregunta)));
        }

        return $this->render('AoshidowebBundle:Respuestas:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
                    'pregunta' => $pregunta,
        ));
    }

    public function editAction(Request $request, $idPregunta, $idRespuesta) {
        $respuestas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Respuesta')
                ->findBy(array('activo' => TRUE, 'pregunta' => $idPregunta));

        $pregunta = $this->getDoctrine()->getRepository('AoshidowebBundle:Pregunta')->find($idPregunta);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($respuestas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($respuestas);

        $respuesta = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Respuesta')
                ->find($idRespuesta);

        $form = $this->createForm(new RespuestaType(), $respuesta, array('method' => 'PATCH'));
        
        $form->add('save', 'submit', array(
            'label' => 'Guardar Cambios',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));
        
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($respuesta);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Respuesta editada !');
            return $this->redirect($this->generateUrl('respuestas_new', array(
                                'idPregunta' => $idPregunta)));
        }

        return $this->render('AoshidowebBundle:Respuestas:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
                    'pregunta' => $pregunta,
        ));
    }

    public function disableAction($idRespuesta) {

        $respuesta = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Respuesta')
                ->find($idRespuesta);

        $idPregunta = $respuesta->getPregunta()->getId();
        $respuesta->setActivo(false);
        $respuesta->setPregunta(null);

        $em = $this->getDoctrine()->getManager();
        $em->persist($respuesta);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Respuesta eliminada !');
        return $this->redirect($this->generateUrl('respuestas_new', array(
                            'idPregunta' => $idPregunta)));
    }

}
