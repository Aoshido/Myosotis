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

            $params = array();
            $content = $request->getContent();
            if (!empty($content)) {
                $params = json_decode($content, true); // 2nd param to get as array
                $comment = $params[0]["value"];
                $screenshot = $params[1]["value"];
            }

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
                    ->setFrom(array('notifications@aoshido.com' => 'Myosotis'))
                    ->setTo('aoshido@gmail.com')
                    ->setBody(
                    $this->renderView('Emails/newBug.html.twig', array(
                        'time' => $time,
                        'comment' => $comment,
                        'user' => $user->getUsername(),
                    )), 'text/html');

            if ($screenshot != "") {
                $screenshot = str_replace('data:image/png;base64,', '', $screenshot);
                $screenshot = str_replace(' ', '+', $screenshot);
                $data = base64_decode($screenshot);

                $attachment = Swift_Attachment::newInstance($data, 'screenshot.png', 'image/png');
                sleep(20);
                $message->attach($attachment);
            }

            $this->get('mailer')->send($message);
            return new JsonResponse(array('result' => 'success'));
        }
        return $this->redirectToRoute('aoshidoweb_homepage');
    }

}
