<?php

namespace Aoshido\webBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\UserBundle\Entity\User;
use Doctrine\ORM\Event\OnFlushEventArgs;

class ExperienceHandler {

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

    public function onFlush(OnFlushEventArgs $args) {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityUpdates() as $keyEntity => $entity) {
            if ($entity instanceof Pregunta) {
                foreach ($uow->getEntityChangeSet($entity) as $keyField => $field) {
                    if ($keyField == 'vecesAcertada') {
                        $user = $this->tokenStorage->getToken()->getUser();
                        if ($user instanceof User) {
                            $user->addExperience(round($entity->getDificultad()) * $this->session->get('combo'));
                            $em->persist($user);
                            $classMetadata = $em->getClassMetadata('Aoshido\UserBundle\Entity\User');
                            $uow->computeChangeSet($classMetadata, $user);
                        }else{
                            $this->session->getFlashBag()->add('notice', 'De estar logueado hubieras ganado: ' . round($entity->getDificultad()) . ' puntos de experencia!');
                        }
                    }
                }
            }
        }
    }
}
