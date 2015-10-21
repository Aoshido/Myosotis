<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Bug;
use Aoshido\webBundle\Form\BugType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swift_Attachment;

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

            if ($this->getUser() != null) {
                $user = $this->getUser();
            } else {
                $user = $this->getDoctrine()
                        ->getRepository('AoshidoUserBundle:User')
                        ->find(1);
            }

            $bug = new Bug();
            $bug->setActivo(TRUE);
            $bug->setContenido($comment);
            $bug->setStatus('Reported');
            $bug->setReportedUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($bug);
            $em->flush();

            $message = \Swift_Message::newInstance()
                    ->setSubject('NEW BUG')
                    ->setFrom('notifications@aoshido.com.ar')
                    ->setTo('aoshido@gmail.com')
                    ->setBody(
                    $this->renderView('Emails/newBug.html.twig', array(
                        'time' => $time,
                        'comment' => $comment,
                        'user' => $user->getUsername(),
                    )), 'text/html');

            if ($request->get('screenshot') != NULL) {


                $screen = $request->get('screenshot');
                
                $screen = str_replace('data:image/png;base64,', '', $screen);
                $screen = str_replace(' ', '+', $screen);
                $data = base64_decode($screen);

                $attachment = Swift_Attachment::newInstance($data, 'screenshot.png', 'image/png');
                $message->attach($attachment);
            }

            $this->get('mailer')->send($message);
            return new JsonResponse(array('result' => 'success'));
        }
        return $this->redirectToRoute('aoshidoweb_homepage');
    }

}
