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
        //Display a list of all Preguntas
        $preguntas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Pregunta')
                ->findBy(array('activo' => TRUE));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($preguntas);

        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta, array(
            'em' => $this->getDoctrine()->getManager()));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $pregunta->setActivo(TRUE);
            $pregunta->setVecesVista(0);
            $pregunta->setVecesAcertada(0);

            foreach ($pregunta->getTemas() as $tema) {
                $tema->setActivo(TRUE);
            }

            $em = $this->getDoctrine()->getManager();
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

}
