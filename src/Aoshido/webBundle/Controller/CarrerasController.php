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
                ->createQueryBuilder('c')
                ->where('c.activo = TRUE')
                ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($carreras, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

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
            
            $this->get('session')->getFlashBag()->add('success', 'Carrera creada !');
            return $this->redirect($this->generateUrl('abms_carreras'));
        }

        return $this->render('AoshidowebBundle:Carreras:new.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
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

        $materiasOriginales = new ArrayCollection();

        // Create an ArrayCollection of the current Materias objects in the database
        foreach ($carrera->getMaterias() as $materia_original) {
            $materiasOriginales->add($materia_original);
        }
        
        //Utilizo PATCH porque POST pone en null los campos no explicitamente inicializados
        //En este caso Carrera->getMaterias->getCarreras
        $form = $this->createForm(new CarreraType(), $carrera , array('method' => 'PATCH'));
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            //Reviso si todavia tiene la materia original, o hay que removerla
            foreach ($materiasOriginales as $materia_original) {
                if (false === $carrera->getMaterias()->contains($materia_original)) {
                    $carrera->removeMateria($materia_original);
                }
                $em->persist($materia_original);
            }
            
            $em->persist($carrera);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Carrera editada !');
            return $this->redirect($this->generateUrl('abms_carreras'));
        }

        return $this->render('AoshidowebBundle:Carreras:edit.html.twig', array(
                    'form' => $form->createView(),
                    'materias' => $materias,
                    'paginas' => $pagination,
                    'carrera' => $carrera,
        ));
    }

    public function disableAction($idCarrera) {
        $em = $this->getDoctrine()->getManager();

        $carrera = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Carrera')
                ->find($idCarrera);
        
        $carrera->setActivo(FALSE);
        $em->persist($carrera);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('success', 'Carrera eliminada !');
        return $this->redirect($this->generateUrl('abms_carreras'));
    }

}
