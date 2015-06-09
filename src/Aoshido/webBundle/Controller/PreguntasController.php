<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Tema;
use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class PreguntasController extends Controller {

    public function newAction(Request $request) {
        $preguntas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Pregunta')
                ->findBy(array('activo' => TRUE));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($preguntas);
        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta);

        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pregunta->setActivo(TRUE);
            $pregunta->setVecesVista(0);
            $pregunta->setVecesAcertada(0);
            dump($pregunta);
            dump($form);
            die();
            /*$temas = $form->get('temas')->getData();
            foreach ($temas as $tema) {
                $pregunta->addTema($tema);
                $em->persist($tema);
            }*/
            
            $em->persist($pregunta);
            $em->flush();

            return $this->redirect($this->generateUrl('abms_preguntas'));
        }

        return $this->render('AoshidowebBundle:Preguntas:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
        ));
    }

    public function editAction(Request $request,$idPregunta) {
        $preguntas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Pregunta')
                ->findBy(array('activo' => TRUE));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($preguntas);

        $pregunta = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Pregunta')
                ->find($idPregunta);
        
        $form = $this->createForm(new PreguntaType(), $pregunta , array('method' => 'PATCH'));
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            dump($form);
            dump($form->get('temas')->getData());
            dump($pregunta);
            die();
            //$temas = $form->get('temas')->getData();
                    
            
            foreach ($pregunta->getTemas() as $tema) {
                $pregunta->removeTema($tema);
                $em->persist($tema);
            }
            
            foreach ($temas as $tema) {
                $pregunta->addTema($tema);
                $em->persist($tema);
            }
            
            $em->persist($pregunta);
            $em->flush();

            return $this->redirect($this->generateUrl('abms_preguntas'));
        }

        return $this->render('AoshidowebBundle:Preguntas:edit.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
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
