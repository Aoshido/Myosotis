<?php

namespace Aoshido\webBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddTemaByMateriaFieldSuscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addTemaForm($form, $idmateria = null) {
        $formOptions = array(
            'class' => 'AoshidowebBundle:Tema',
            'label' => 'Tema',
            'required' => true,
            'mapped' => false,
            'empty_value' => '- Seleccione Tema -',
            'property' => 'descripcion',
            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) use ($idmateria) {
                $qb = $repository->createQueryBuilder('t')
                        ->where('t.activo=true')
                        ->innerJoin('t.materia', 'm')
                        ->andWhere('m.activo=true')
                        ->andWhere('m=:idmateria')
                        ->setParameter('idmateria', $idmateria)
                        ->addOrderBy('t.descripcion', 'ASC');
                return $qb;
            }
        );

        if ($idmateria) {
            $formOptions['data'] = $idmateria;
        }

        $form->add('idtema', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        //$idcarrera = $accessor->getValue($data, 'idcarrera');

        $this->addTemaForm($form);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        
        $idmateria = array_key_exists('idmateria', $data) ? $data['idmateria'] : null;
        $this->addTemaForm($form, $idmateria);
    }

}
