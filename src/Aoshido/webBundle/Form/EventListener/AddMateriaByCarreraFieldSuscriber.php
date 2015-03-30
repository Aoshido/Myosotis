<?php

namespace Aoshido\webBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddMateriaByCarreraFieldSuscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addMateriaForm($form, $idcarrera = null) {
        $formOptions = array(
            'class' => 'AoshidowebBundle:Materia',
            'label' => 'Materia',
            'required' => true,
            'mapped' => false,
            'empty_value' => '- Seleccione Materia -',
            'property' => 'descripcion',
            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository) use ($idcarrera) {
                $qb = $repository->createQueryBuilder('m')
                        ->where('m.activo=true')
                        ->innerJoin('m.carreras', 'c')
                        ->andWhere('c.activo=true')
                        ->andWhere('c=:idcarrera')
                        ->setParameter('idcarrera', $idcarrera)
                        ->addOrderBy('m.descripcion', 'ASC');
                return $qb;
            }
        );

        if ($idcarrera) {
            $formOptions['data'] = $idcarrera;
        }

        $form->add('idmateria', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        //$idcarrera = $accessor->getValue($data, 'idcarrera');

        $this->addMateriaForm($form);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $idcarrera = array_key_exists('idcarrera', $data) ? $data['idcarrera'] : null;
        $this->addMateriaForm($form, $idcarrera);
    }

}
