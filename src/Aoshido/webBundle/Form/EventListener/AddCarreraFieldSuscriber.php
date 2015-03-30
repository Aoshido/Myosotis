<?php

namespace Aoshido\webBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddCarreraFieldSuscriber implements EventSubscriberInterface {

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

        $temas = $accessor->getValue($data, $this->propertyPathToTema);
        //Elijo el primer tema de todos los que puede tener ya que todos 
        //pertenecen a la misma materia
        $tema = $temas[0];
        $materia = ($tema) ? $tema->getMateria() : null;

        //Una materia puede pertenecer a varias carreras, elijo una al azar
        if ($materia == null) {
            $carrera = NULL;
        } else {
            $carreras = $materia->getCarreras();
            $carrera = $carreras[0];
        }
        $this->addCarreraForm($form, $carrera);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $carrera = array_key_exists('carrera', $data) ? $data['carrera'] : null;
        $this->addMateriaForm($form, $carrera);
    }

}
