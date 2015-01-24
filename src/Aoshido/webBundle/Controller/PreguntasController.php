<?php

namespace Aoshido\webBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PreguntasController extends Controller
{
    public function newAction()
    {
        return $this->render('AoshidowebBundle:Preguntas:index.html.twig');
    }
}
