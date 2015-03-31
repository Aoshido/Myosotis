<?php

namespace Aoshido\webBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddMateriaInTemasFieldSuscriber implements EventSubscriberInterface {

    private $propertyPathToTema;

    public function __construct($propertyPathToTema) {
        $this->propertyPathToTema = $propertyPathToTema;
    }

    public static function getSubscribedEvents() {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addMateriaForm($form, $idcarrera, $materia = null) {
        $formOptions = array(
            'class'         => 'AoshidowebBundle:Materia',
            'empty_value'   => '- Seleccione Materia -',
            'label'         => 'Materia:',
            'mapped'        => false,
            'attr'          => array(
                'class' => 'materia_selector',
            ),
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

        if ($materia) {
            $formOptions['data'] = $materia;
        }

        $form->add('materia', 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $accessor = PropertyAccess::getPropertyAccessor();

        $materia = $accessor->getValue($data, $this->propertyPathToTema);

        //Una materia puede pertenecer a varias carreras, elijo la primera
        if ($materia == null) {
            $idcarrera = NULL;
        } else {
            $carreras = $materia->getCarreras();
            $idcarrera = $carreras[0]->getId();
        }
        
        $this->addMateriaForm($form, $idcarrera, $materia);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $carreras = array_key_exists('carrera', $data) ? $data['carrera'] : null;
        $idcarrera = $carreras[0];
        
        $materia = $form->get('materia');

        $this->addMateriaForm($form, $idcarrera,$materia);
    }

}
