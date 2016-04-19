<?php

namespace Aoshido\webBundle\Controller;

use Aoshido\webBundle\Entity\Tema;
use Aoshido\webBundle\Entity\Pregunta;
use Aoshido\webBundle\Form\PreguntaType;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller {

    public function indexAction(Request $request) {
                

        return $this->render('AoshidowebBundle:Admin:index.html.twig', array(
        ));
    }
    
}
