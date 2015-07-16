<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Respuesta;
use Aoshido\webBundle\Form\RespuestaType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class RespuestasController extends Controller {

    public function newAction(Request $request,$idPregunta) {
        $respuestas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Respuesta')
                ->findBy(array('activo' => TRUE , 'pregunta' => $idPregunta));

        $pregunta = $this->getDoctrine()->getRepository('AoshidowebBundle:Pregunta')->find($idPregunta);
        
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($respuestas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($respuestas);

        $respuesta = new Respuesta();
        $form = $this->createForm(new RespuestaType(),$respuesta);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $respuesta->setActivo(TRUE);
            $respuesta->setPregunta($pregunta);

            $em = $this->getDoctrine()->getManager();
            $em->persist($respuesta);
            $em->flush();

            return $this->redirect($this->generateUrl('respuestas_new' , array ('idPregunta' => $idPregunta)));
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
        
        $respuesta->setActivo(false);
        $respuesta->setPregunta(null);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($respuesta);
        $em->flush();
        
        return $this->redirect($this->generateUrl('abms_preguntas'));
    }

    public function MateriasByCarreraAction(Request $request) {
        $idcarrera = $request->request->get('idcarrera');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("AoshidowebBundle:Materia")->createQueryBuilder('m')
                ->where('m.activo=true')
                ->innerJoin('m.carreras', 'c')
                ->andWhere('c.activo=true')
                ->andWhere('c=:idcarrera')
                ->setParameter('idcarrera', $idcarrera)
                ->addOrderBy('m.descripcion', 'ASC');

        $materias = $qb->getQuery()->getArrayResult();

        return new JsonResponse($materias);
    }

    public function TemasByMateriaAction(Request $request) {
        $idmateria = $request->request->get('idmateria');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("AoshidowebBundle:Tema")->createQueryBuilder('t')
                ->where('t.activo=true')
                ->innerJoin('t.materia', 'm')
                ->andWhere('m.activo=true')
                ->andWhere('m=:idmateria')
                ->setParameter('idmateria', $idmateria)
                ->addOrderBy('m.descripcion', 'ASC');

        $temas = $qb->getQuery()->getArrayResult();

        return new JsonResponse($temas);
    }

}
