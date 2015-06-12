<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use Aoshido\webBundle\Form\Filter\PreguntaFilterType;

class GamesController extends Controller {

    public function settingsAction(Request $request) {

        
        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta , array('method' => 'PATCH'));
        
        $form->handleRequest($request);
        
        $preguntas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Pregunta')
                ->findBy(array('activo' => TRUE));
        
        if ($form->isValid()) {
            
            if ($pregunta->getTemas() != ""){
                
            }
            
            
            return $this->redirect($this->generateUrl('abms_preguntas'));
        }
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);


        return $this->render('AoshidowebBundle:Games:quiz.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function disableAction($idPregunta) {

        $this->get('service_disabler')->disablePregunta($idPregunta);

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
