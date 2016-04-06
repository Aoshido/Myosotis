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
                ->createQueryBuilder('t')
                ->where('t.activo = TRUE')
                ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($temas, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

        $tema = new Tema();
        $form = $this->createForm(new TemaType(), $tema);

        $form->add('save', 'submit', array(
            'label' => 'Agregar Tema',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));

        $form->handleRequest($request);


        if ($form->isValid()) {
            $tema->setActivo(TRUE);

            $materia = $form->get('materia')->getData();
            $tema->setMateria($materia);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tema);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Tema agregado !');
            return $this->redirect($this->generateUrl('abms_temas'));
        }

        return $this->render('AoshidowebBundle:Temas:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function editAction(Request $request, $idTema) {

        //Display a list of all Temas activos
        $temas = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Tema')
                ->findBy(array('activo' => TRUE));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($temas, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

        $tema = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Tema')
                ->find($idTema);

        $form = $this->createForm(new TemaType(), $tema, array('method' => 'PATCH'));
        
        $form->add('save', 'submit', array(
            'label' => 'Guardar Cambios',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $tema->setActivo(TRUE);

            $materia = $form->get('materia')->getData();
            $tema->setMateria($materia);

            $em = $this->getDoctrine()->getManager();
            $em->persist($tema);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Tema editado !');
            return $this->redirect($this->generateUrl('abms_temas'));
        }

        return $this->render('AoshidowebBundle:Temas:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function disableAction($idTema) {

        $this->get('service_disabler')->disableTema($idTema);
        
        $this->get('session')->getFlashBag()->add('success', 'Tema eliminado !');
        return $this->redirect($this->generateUrl('abms_temas'));
    }

}
