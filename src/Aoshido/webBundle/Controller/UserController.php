<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Tema;
use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller {

    public function indexAction(Request $request) {
        //Display a list of all Users
        $users = $this->getDoctrine()
                ->getRepository('AoshidouserBundle:User')
                ->findBy(array('enabled' => TRUE));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($users, $this->getRequest()->query->get('page', 1), 10);
        $pagination->setPageRange(6);

        $cantidad = count($users);
        
        return $this->render('AoshidowebBundle:Users:index.html.twig', array(
                    'paginas' => $pagination,
                    'cantidad' => $cantidad,
        ));
    }

    public function promoteAction($idUser) {
        $user = $this->getDoctrine()
                ->getRepository('AoshidouserBundle:User')
                ->find($idUser);
        
        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_ADMIN');
        $userManager->updateUser($user);
        
        return $this->redirectToRoute('users_index');
    }

}
