<?php

namespace Aoshido\webBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Aoshido\webBundle\Entity\Pregunta;
use Doctrine\ORM\Event\OnFlushEventArgs;

class ExperienceHandler {

    protected $twig;
    protected $mailer;
    protected $tokenStorage;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer, $tokenStorage) {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->tokenStorage = $tokenStorage;
    }

    public function onFlush(OnFlushEventArgs $args) {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        
        //die();
        
        foreach ($uow->getScheduledEntityUpdates() as $keyEntity => $entity) {
            if ($entity instanceof Pregunta) {
                foreach ($uow->getEntityChangeSet($entity) as $keyField => $field) {
                    if ($keyField == 'vecesAcertada') {
                        $user = $this->tokenStorage->getToken()->getUser();

                        $user->addExperience(round($entity->getDificultad()));
                        $em->persist($user);
                        $classMetadata = $em->getClassMetadata('Aoshido\UserBundle\Entity\User');
                        $uow->computeChangeSet($classMetadata, $user);
                    }
                }
            }
        }
    }

}
