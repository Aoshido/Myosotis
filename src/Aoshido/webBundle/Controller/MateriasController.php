<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Materia;
use Aoshido\webBundle\Form\MateriaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MateriasController extends Controller {

    public function newAction(Request $request) {

        //Display a list of all Materias
        $materias = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Materia')
                ->createQueryBuilder('m')
                ->where('m.activo = TRUE')
                ->getQuery();
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($materias, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

        $materia = new Materia();
        $form = $this->createForm(new MateriaType(), $materia);

        $form->handleRequest($request);
        

        if ($form->isValid()) {
            $materia->setActivo(TRUE);

            $em = $this->getDoctrine()->getManager();
            $em->persist($materia);
            $em->flush();

            return $this->redirect($this->generateUrl('abms_materias'));
        }

        return $this->render('AoshidowebBundle:Materias:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function editAction(Request $request, $idMateria) {

        //Display a list of all Materias
        $materias = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Materia')
                ->createQueryBuilder('m')
                ->where('m.activo = TRUE')
                ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($materias, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);
        
        $materia = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Materia')
                ->find($idMateria);

        $form = $this->createForm(new MateriaType(), $materia, array('method' => 'PATCH'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $materia->setActivo(TRUE);

            $em = $this->getDoctrine()->getManager();
            $em->persist($materia);
            $em->flush();

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
        
        foreach ($materia->getTemas() as $tema){
            $materia->removeTema($tema);
            $em->persist($tema);
        }
        
        $materia->setActivo(FALSE);
        $em->persist($materia);
        $em->flush();

        return $this->redirect($this->generateUrl('abms_materias'));
    }

}
