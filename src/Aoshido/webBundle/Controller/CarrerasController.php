<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Carrera;
use Aoshido\webBundle\Form\CarreraType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CarrerasController extends Controller {

    public function newAction(Request $request) {
        //Display a list of all Carreras
        $carreras = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Carrera')
                ->findBy(array('activo' => TRUE));

        $materiascarrera = array();
        foreach ($carreras as $carrera) {
            $materiascarrera[$carrera->getId()] = count($carrera->getMaterias());
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($carreras, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($carreras);

        $carrera = new Carrera();
        $form = $this->createForm(new CarreraType(), $carrera);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $carrera->setActivo(TRUE);

            foreach ($carrera->getMaterias() as $materia) {
                $materia->setActivo(TRUE);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($carrera);
            $em->flush();

            return $this->redirect($this->generateUrl('abms_carreras'));
        }

        return $this->render('AoshidowebBundle:Carreras:new.html.twig', array(
                    'form' => $form->createView(),
                    'materiasxcarrera' => $materiascarrera,
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
        ));
    }

    public function editAction(Request $request, $idCarrera) {
        $em = $this->getDoctrine()->getManager();

        $carrera = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Carrera')
                ->find($idCarrera);

        $materias = $carrera->getMaterias();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($materias, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($materias);

        $materiasOriginales = new ArrayCollection();

        // Create an ArrayCollection of the current Materias objects in the database
        foreach ($carrera->getMaterias() as $materia_original) {
            $materiasOriginales->add($materia_original);
            
            print_r($materia_original->getCarreras()[0]->getDescripcion());
            //dump($materia_original);
            
            //Aca si no "Traigo" las carreras de la materia quedan
            // Lazy inicializadas, entonces dps cuando abajo las trato
            // de volver a agregar, quedan con la lista de carreras vacias
            // si yo aca hago por ejemplo el print_R se inicializa la lsita de
            // carreras de la materia, pero no se si qeuda abajo 25/04/2015
            //die();
        }

        $form = $this->createForm(new CarreraType(), $carrera);

        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($materiasOriginales as $materia_original) {
                if (false === $carrera->getMaterias()->contains($materia_original)) {
                    $carrera->removeMateria($materia_original);
                }

                $materia_original->addCarrera($carrera);

                $em->persist($materia_original);
            }
            //dump($materia_original);
            //dump($carrera);
            //die();
            $em->persist($carrera);
            $em->flush();

            return $this->redirect($this->generateUrl('abms_carreras'));
        }

        return $this->render('AoshidowebBundle:Carreras:edit.html.twig', array(
                    'form' => $form->createView(),
                    'materias' => $materias,
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
                    'carrera' => $carrera,
        ));
    }

    public function desvincularAction($idCarrera, $idMateria) {

        $this->get('service_disabler')->desvincularMateria($idCarrera, $idMateria);

        return $this->redirect($this->generateUrl('abms_carreras'));
    }

}
