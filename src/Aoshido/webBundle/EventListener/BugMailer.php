<?php

namespace Aoshido\webBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Aoshido\webBundle\Entity\Bug;

class BugMailer {

    protected $twig;
    protected $mailer;
    protected $tokenStorage;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer) {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function postUpdate(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Bug) {

            if ($entity->getStatus() != "Reported") {
                  $message = \Swift_Message::newInstance()
                  ->setSubject('Tu reporte de bug fue contestado!')
                  ->setFrom(array('notifications@aoshido.com.ar' => 'Myosotis'))
                  ->setTo($entity->getReportedUser()->getEmail())
                  ->setBody(
                  $this->twig->render('AoshidowebBundle:Emails:bugAnswer.html.twig', array(
                  'time' => date('Y-m-d H:i:s'),
                  'content' => $entity->getContenido(),
                  'user' => $entity->getReportedUser()->getUsername(),
                  'answer' => $entity->getRespuesta()
                  )), 'text/html');

                  $this->mailer->send($message);
            }
        }
    }

}
