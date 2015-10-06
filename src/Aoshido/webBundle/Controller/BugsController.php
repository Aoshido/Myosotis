<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Tema;
use Aoshido\webBundle\Entity\Bug;
use Aoshido\webBundle\Form\BugType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


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

    public function bugsplatAction(Request $request) {

        if ($request->getMethod() == 'POST') {
            $time = date('Y-m-d H:i:s');
            $comment = $request->get('comment');
            $screen = $request->get('screenshot');
            
            
            $message = \Swift_Message::newInstance()
                    ->setSubject('NEW BUG')
                    ->setFrom('notifications@aoshido.com.ar')
                    ->setTo('aoshido@gmail.com')
                    ->setBody(
                    $this->renderView('Emails/newBug.html.twig', array(
                        'time' => $time,
                        'comment' => $comment,
                        'screen' => $screen,
                    )), 'text/html'
                    )
            ;
            $this->get('mailer')->send($message);
            
            return new JsonResponse(array('result' => 'success'));
        }
        return $this->render('AoshidowebBundle:Bugs:bugsplat.html.twig');
    }

}
