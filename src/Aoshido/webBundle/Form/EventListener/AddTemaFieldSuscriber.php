<?php

namespace Aoshido\webBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddTemaFieldSuscriber implements EventSubscriberInterface {

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

    private function addTemaForm($form, $idmateria = null,$tema_seleccionado = null) {
        $formOptions = array(
            'class'         => 'AoshidowebBundle:Tema',
            'empty_value'   => '- Seleccione Tema -',
            'label'         => 'Temas:',
            'mapped'        => true,
            'multiple'      => true,
            'attr'          => array(
                'class' => 'tema_selector',
            ),
            'data' => $tema_seleccionado,
            'property' => 'descripcion',
            'query_builder' => function (EntityRepository $repository) use ($idmateria) {
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
        $form->add($this->propertyPathToTema, 'entity', $formOptions);
    }

    public function preSetData(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();
        if (null === $data) {
            return;
        }

        $accessor    = PropertyAccess::createPropertyAccessor();

        $temas        = $accessor->getValue($data, $this->propertyPathToTema);
        
        //Elijo el primer tema de todos los que puede tener ya que todos 
        //pertenecen a la misma materia
        $tema = $temas[0];
        $materia_id = ($tema) ? $tema->getMateria()->getId() : null;
        
        
        $this->addTemaForm($form, $materia_id,$temas);
    }

    public function preSubmit(FormEvent $event) {
        $data = $event->getData();
        $form = $event->getForm();

        $idmateria = array_key_exists('materia', $data) ? $data['materia'] : null;
        
        $tema = $form->get('temas');
        //print_r ($idmateria);
        //print_r($tema->getViewData());
        //die();
        //$accessor    = PropertyAccess::createPropertyAccessor();
        //$tema        = $accessor->getValue($data, $this->propertyPathToTema);
        //$tema = $temas[0];
        
        $this->addTemaForm($form, $idmateria,$tema);
    }

}
