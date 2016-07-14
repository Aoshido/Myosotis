<?php

namespace Aoshido\webBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\UserBundle\Entity\User;
use Doctrine\ORM\Event\PreUpdateEventArgs;

class LevelNotifier {

    protected $twig;
    protected $mailer;
    protected $tokenStorage;
    protected $session;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer, $tokenStorage, $session) {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs) {
        if ($eventArgs->getEntity() instanceof User) {
            if ($eventArgs->hasChangedField('level')) {
                $this->session->getFlashBag()->add('levelUp', 'Woohoo ! Level Up');
            }
        }
    }

}
