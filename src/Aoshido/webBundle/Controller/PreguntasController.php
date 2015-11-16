<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Aoshido\webBundle\Filter\PreguntasFilterType;

class PreguntasController extends Controller {

    public function newAction(Request $request) {
        $search_form = $this->get('form.factory')->create(new PreguntasFilterType());

        if ($request->query->has($search_form->getName())) {
            // manually bind values from the request
            $search_form->submit($request->query->get($search_form->getName()));

            // initialize a query builder
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->createQueryBuilder('p')
                    ->Where('p.activo = TRUE');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($search_form, $filterBuilder);

            $preguntas = $filterBuilder->getQuery()->getResult();
        } else {
            $preguntas = $this->getDoctrine()
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->findBy(array('activo' => TRUE));
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

        $pregunta = new Pregunta();
        $form = $this->createForm(new PreguntaType(), $pregunta);
        
        $form->add('save', 'submit', array(
            'label' => 'Agregar Pregunta',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $pregunta->setActivo(TRUE);
            $pregunta->setCreatorUser($this->getUser());
            $pregunta->setVecesVista(0);
            $pregunta->setVecesAcertada(0);

            $em->persist($pregunta);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Pregunta agregada !');
            return $this->redirect($this->generateUrl('abms_preguntas'));
        }

        return $this->render('AoshidowebBundle:Preguntas:new.html.twig', array(
                    'form' => $form->createView(),
                    'searchForm' => $search_form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function editAction(Request $request, $idPregunta) {
        $search_form = $this->get('form.factory')->create(new PreguntasFilterType());

        if ($request->query->has($search_form->getName())) {
            // manually bind values from the request
            $search_form->submit($request->query->get($search_form->getName()));

            // initialize a query builder
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->createQueryBuilder('p')
                    ->Where('p.activo = TRUE');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($search_form, $filterBuilder);

            $preguntas = $filterBuilder->getQuery()->getResult();
        } else {
            $preguntas = $this->getDoctrine()
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->findBy(array('activo' => TRUE));
        }

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

        $pregunta = $this->getDoctrine()
                ->getRepository('AoshidowebBundle:Pregunta')
                ->find($idPregunta);

        $form = $this->createForm(new PreguntaType(), $pregunta, array('method' => 'PATCH'));
        
        $form->add('save', 'submit', array(
            'label' => 'Guardar Cambios',
            'attr' => array(
                'class' => 'btn btn-success'
            ),
        ));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $temas = $form->get('temas')->getData();
            
            foreach ($pregunta->getTemas() as $tema) {
                $pregunta->removeTema($tema);
                $em->persist($tema);
            }

            foreach ($temas as $tema) {
                $pregunta->addTema($tema);
                $em->persist($tema);
            }
            $pregunta->setActivo(TRUE);

            $this->get('session')->getFlashBag()->add('success', 'Pregunta editada !');
            return $this->redirect($this->generateUrl('abms_preguntas'));
        }

        return $this->render('AoshidowebBundle:Preguntas:new.html.twig', array(
                    'form' => $form->createView(),
                    'searchForm' => $search_form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function disableAction($idPregunta) {

        $this->get('service_disabler')->disablePregunta($idPregunta);

        return $this->redirect($this->generateUrl('abms_preguntas'));
    }

    public function MateriasByCarreraAction(Request $request) {
        $idcarrera = $request->request->get('idcarrera');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("AoshidowebBundle:Materia")->createQueryBuilder('m')
                ->where('m.activo=true')
                ->innerJoin('m.carreras', 'c')
                ->andWhere('c.activo=true')
                ->andWhere('c=:idcarrera')
                ->setParameter('idcarrera', $idcarrera)
                ->addOrderBy('m.descripcion', 'ASC');

        $materias = $qb->getQuery()->getArrayResult();

        return new JsonResponse($materias);
    }

    public function TemasByMateriaAction(Request $request) {
        $idmateria = $request->request->get('idmateria');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("AoshidowebBundle:Tema")->createQueryBuilder('t')
                ->where('t.activo=true')
                ->innerJoin('t.materia', 'm')
                ->andWhere('m.activo=true')
                ->andWhere('m=:idmateria')
                ->setParameter('idmateria', $idmateria)
                ->addOrderBy('m.descripcion', 'ASC');

        $temas = $qb->getQuery()->getArrayResult();

        return new JsonResponse($temas);
    }

}
