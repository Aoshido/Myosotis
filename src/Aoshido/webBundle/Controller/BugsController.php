<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Tema;

use Aoshido\webBundle\Entity\Bug;
use Aoshido\webBundle\Form\BugType;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BugsController extends Controller {

    public function indexAction(Request $request) {
        //Display a list of all Preguntas
        $bugs = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Bug')
                ->findBy(array('activo' => TRUE));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($bugs, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($bugs);
        
        $bug = new Bug();
        $form = $this->createForm(new BugType(), $bug);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $bug->setActivo(TRUE);
            $bug->setStatus('Reported');
            $bug->setReportedUser($this->getUser());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($bug);
            $em->flush();
            
            return $this->redirect($this->generateUrl('aoshidoweb_bugs'));
        }

        return $this->render('AoshidowebBundle:Bugs:index.html.twig', array(
                    'form' => $form->createView(),
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
        ));
    }
    

}
