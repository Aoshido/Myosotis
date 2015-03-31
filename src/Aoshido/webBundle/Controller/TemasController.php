<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Tema;
use Aoshido\webBundle\Form\TemaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TemasController extends Controller {

    public function newAction(Request $request) {

        //Display a list of all Temas activos
        $temas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Tema')
                ->findBy(array('activo' => TRUE));

        $preguntasTemas = array();
        foreach ($temas as $c_tema) {                                           //C= Counter
            $preguntasTemas[$c_tema->getId()] = count($c_tema->getPreguntas());
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($temas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($temas);

        $tema = new Tema();
        $form = $this->createForm(new TemaType(), $tema);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $tema->setActivo(TRUE);

            $materia = $form->get('materia')->getData();
            $tema->setMateria($materia);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($tema);
            $em->flush();

            return $this->redirect($this->generateUrl('abms_temas'));
        }

        return $this->render('AoshidowebBundle:Temas:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
                    'preguntasTemas' => $preguntasTemas,
        ));
    }
    
    public function editAction(Request $request,$idTema) {

        //Display a list of all Temas activos
        $temas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Tema')
                ->findBy(array('activo' => TRUE));

        $preguntasTemas = array();
        foreach ($temas as $c_tema) {                                           //C= Counter
            $preguntasTemas[$c_tema->getId()] = count($c_tema->getPreguntas());
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($temas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($temas);

        $tema = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Tema')
                ->find($idTema);
        
        $form = $this->createForm(new TemaType(), $tema);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $tema->setActivo(TRUE);

            $materia = $form->get('materia')->getData();
            $tema->setMateria($materia);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($tema);
            $em->flush();

            return $this->redirect($this->generateUrl('abms_temas'));
        }

        return $this->render('AoshidowebBundle:Temas:edit.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
                    'preguntasTemas' => $preguntasTemas,
        ));
    }
}
