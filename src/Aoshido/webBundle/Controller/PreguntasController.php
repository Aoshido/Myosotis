<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Aoshido\webBundle\Filter\PreguntasFilterType;
use Doctrine\Common\Collections\ArrayCollection;

class PreguntasController extends Controller {

    public function newAction(Request $request) {
        $pregunta = new Pregunta();

        $quicksearch_form = $this->get('form.factory')->create(new PreguntasFilterType());
        $fullsearch_form = $this->createForm(new PreguntaType(), $pregunta, array(
            'method' => 'GET',
        ));

        $preguntas = $this->getPreguntasFiltered($request, $quicksearch_form, $fullsearch_form,$pregunta);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);

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
                    'searchForm' => $quicksearch_form->createView(),
                    'fullSearchForm' => $fullsearch_form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function editAction(Request $request, $idPregunta) {
        $pregunta_model = new Pregunta();

        $quicksearch_form = $this->get('form.factory')->create(new PreguntasFilterType());
        $fullsearch_form = $this->createForm(new PreguntaType(), $pregunta_model, array(
            'method' => 'GET',
        ));

        $preguntas = $this->getPreguntasFiltered($request, $quicksearch_form, $fullsearch_form,$pregunta_model);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 5);
        $pagination->setPageRange(6);
        
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
                    'searchForm' => $quicksearch_form->createView(),
                    'fullSearchForm' => $fullsearch_form->createView(),
                    'paginas' => $pagination,
        ));
    }

    public function disableAction($idPregunta) {

        $this->get('service_disabler')->disablePregunta($idPregunta);
        $this->get('session')->getFlashBag()->add('success', 'Pregunta eliminada !');
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

    public function getPreguntasFiltered(Request $request, $quicksearch_form, $fullsearch_form,$pregunta) {

        if ($request->query->has($quicksearch_form->getName())) {
            // manually bind values from the request
            $quicksearch_form->submit($request->query->get($quicksearch_form->getName()));

            // initialize a query builder
            $filterBuilder = $this->get('doctrine.orm.entity_manager')
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->createQueryBuilder('p')
                    ->where('p.activo = TRUE');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($quicksearch_form, $filterBuilder);

            $preguntas = $filterBuilder->getQuery()->getResult();
        } else if ($request->query->has($fullsearch_form->getName())) {
            $preguntas = new ArrayCollection();
            
            $fullsearch_form->handleRequest($request);

            if ($fullsearch_form->isValid()) {
                foreach ($pregunta->getTemas() as $tema) {
                    $preguntas_temp = $tema->getPreguntas();
                    if (count($preguntas_temp) > 0) {
                        foreach ($preguntas_temp as $pregunta_temp) {
                            if ($pregunta_temp != $pregunta && !$preguntas->contains($pregunta_temp) && $pregunta_temp->getActivo()) {
                                $preguntas->add($pregunta_temp);
                            }
                        }
                    }
                }
                if (count($preguntas) == 0) {
                    $this->get('session')->getFlashBag()->add('error', 'Oops! Parece que no hay preguntas de esos temas');
                    /*return $this->redirectToRoute('games_cards');*/
                }
            }
        } else {
            $preguntas = $this->getDoctrine()
                    ->getRepository('AoshidowebBundle:Pregunta')
                    ->findBy(array('activo' => TRUE));
            
            //dump($preguntas);
        }
        return $preguntas;
    }

}
