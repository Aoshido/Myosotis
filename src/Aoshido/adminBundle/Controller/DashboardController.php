<?php

namespace Aoshido\adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller {

    public function indexAction() {
        return $this->render('AoshidoadminBundle:Dashboard:index.html.twig');
    }

    public function lastQuestionsAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidowebBundle:Pregunta')
                ->createQueryBuilder('p')
                //->where('p.activo = TRUE')
                ->orderBy('p.creada','DESC');

        $preguntas = $filterBuilder->getQuery()->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        return $this->render('AoshidoadminBundle:Dashboard:_lastQuestionsBlock.html.twig', array(
                    'paginas' => $pagination,
        ));
    }
    
    public function lastUsersAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidoUserBundle:User')
                ->createQueryBuilder('u')
                //->where('p.activo = TRUE')
                ->orderBy('u.id','DESC');

        $preguntas = $filterBuilder->getQuery()->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        return $this->render('AoshidoadminBundle:Dashboard:_lastUsersBlock.html.twig', array(
                    'paginas' => $pagination,
        ));
    }
    
    public function lastBugsAction() {
        $filterBuilder = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AoshidowebBundle:Bug')
                ->createQueryBuilder('b')
                //->where('p.activo = TRUE')
                ->orderBy('b.id','DESC');

        $preguntas = $filterBuilder->getQuery()->getResult();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($preguntas, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        return $this->render('AoshidoadminBundle:Dashboard:_lastBugsBlock.html.twig', array(
                    'paginas' => $pagination,
        ));
    }

}
