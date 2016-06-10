<?php

namespace Aoshido\adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller {

    public function indexAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidowebBundle:Carrera')
                ->createQueryBuilder('c')
                ->where('c.activo = TRUE');

        $carreras = $filterBuilder->getQuery()->getResult();
        $total = 0;
        foreach ($carreras as $carrera) {
            $preguntas = 0;
            foreach ($carrera->getMaterias() as $materia) {
                foreach ($materia->getTemas() as $tema) {
                    $preguntas += ($tema->getPreguntasActivas()->count());
                }
            }
            $total += $preguntas;
            $preguntasPorCarrera[] = array($carrera->getDescripcion(), $preguntas);
        }

        return $this->render('AoshidoadminBundle:Dashboard:index.html.twig', array(
                    'preguntasPorCarrera' => $preguntasPorCarrera,
                    'preguntasTotales' => $total
        ));
    }

    public function getMaxMemoryAction() {
        $i = 0;
        while ($i < 100) {
            //$memoryArray[] = array(date_format(new \DateTime('now'),'H:i:s'),(memory_get_usage() / 1024));
            $memoryArray[] = (memory_get_usage() / 1024);
            //$memoryArray[] = rand(0, 100);
            $i++;
        }
        // create a JSON-response with a 200 status code
        $response = new Response(json_encode($memoryArray), Response::HTTP_OK);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function lastQuestionsAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidowebBundle:Pregunta')
                ->createQueryBuilder('p')
                //->where('p.activo = TRUE')
                ->orderBy('p.creada', 'DESC');

        $preguntas = $filterBuilder->getQuery()->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        return $this->render('AoshidoadminBundle:Dashboard:_lastQuestionsBlock.html.twig', array(
                    'paginas' => $pagination,
        ));
    }

    public function UsersAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidoUserBundle:User')
                ->createQueryBuilder('u')
                //->where('p.activo = TRUE')
                ->orderBy('u.id', 'DESC');

        $preguntas = $filterBuilder->getQuery()->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        return $this->render('AoshidoadminBundle:Dashboard:Users.html.twig', array(
                    'paginas' => $pagination,
        ));
    }

    public function BugsAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidowebBundle:Bug')
                ->createQueryBuilder('b')
                //->where('p.activo = TRUE')
                ->orderBy('b.id', 'DESC');

        $preguntas = $filterBuilder->getQuery()->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        return $this->render('AoshidoadminBundle:Dashboard:Bugs.html.twig', array(
                    'paginas' => $pagination,
        ));
    }

    public function questionDistributionAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidowebBundle:Materia')
                ->createQueryBuilder('m')
                ->where('m.activo = TRUE');

        $materias = $filterBuilder->getQuery()->getResult();

        return $this->render('AoshidoadminBundle:Dashboard:_questionDistributionBlock.html.twig', array(
                    'materias' => $materias,
        ));
    }

}
