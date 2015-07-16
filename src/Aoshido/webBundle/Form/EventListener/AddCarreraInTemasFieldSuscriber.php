<?php

namespace Aoshido\webBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddCarreraInTemasFieldSuscriber implements EventSubscriberInterface {

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

    private function addCarreraForm($form, $idcarrera = null) {
        $formOptions = array(
            'class' => 'AoshidowebBundle:Carrera',
            'label' => 'Carrera:',
            'empty_value' => '- Seleccione Carrera -',
            'mapped' => false,
            'attr' => array(
                'class' => 'country_selector',
            ),
            'required' => true,
            'property' => 'descripcion',
            'query_builder' => function ($repository) {
                         $qb = $repository->createQueryBuilder('c')
                        ->where('c.activo=true')
                        ->addOrderBy('c.Descripcion', 'ASC');
                return $qb;
            }
        );

        if ($idcarrera) {
            $formOptions['data'] = $idcarrera;
        }

        $form->add('carrera', 'entity', $formOptions);
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
            $carrera = NULL;
        } else {
            $carreras = $materia->getCarreras();
            $carrera = $carreras[0];
        }
        $this->addCarreraForm($form, $carrera);
    }

    public function preSubmit(FormEvent $event) {
        $form = $event->getForm();
 
        $this->addCarreraForm($form);
    }

}
