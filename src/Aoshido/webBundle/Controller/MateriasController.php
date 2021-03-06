<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Materia;
use Aoshido\webBundle\Form\MateriaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MateriasController extends Controller {

    public function newAction(Request $request) {

        $materias = $this->getMaterias();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($materias, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

        $materia = new Materia();
        $form = $this->createForm(new MateriaType(), $materia);

        $form->add('save', 'submit', array(
            'label' => 'Agregar Materia',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $materia->setActivo(TRUE);

            $em = $this->getDoctrine()->getManager();
            $em->persist($materia);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Materia agregada !');
            return $this->redirect($this->generateUrl('abms_materias'));
        } else {
            //die($form->getErrorsAsString());
        }

        return $this->render('AoshidowebBundle:Materias:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function editAction(Request $request, $idMateria) {

        $materias = $this->getMaterias();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($materias, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

        $materia = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Materia')
                ->find($idMateria);

        $form = $this->createForm(new MateriaType(), $materia, array('method' => 'PATCH'));

        $form->add('save', 'submit', array(
            'label' => 'Guardar Cambios',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $materia->setActivo(TRUE);

            $em = $this->getDoctrine()->getManager();
            $em->persist($materia);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Materia editada !');
            return $this->redirect($this->generateUrl('abms_materias'));
        }

        return $this->render('AoshidowebBundle:Materias:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function disableAction($idMateria) {
        $em = $this->getDoctrine()->getManager();

        $materia = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Materia')
                ->find($idMateria);

        $materia->setActivo(FALSE);
        $em->persist($materia);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Materia eliminada !');
        return $this->redirect($this->generateUrl('abms_materias'));
    }

    private function getMaterias() {
        //Display a list of all Materias
        $materias = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Materia')
                ->createQueryBuilder('m')
                ->where('m.activo = TRUE')
                ->orderBy('m.id', 'desc')
                ->getQuery();

        return ($materias);
    }

}
