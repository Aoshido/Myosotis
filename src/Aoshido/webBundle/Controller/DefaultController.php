<?php

namespace Aoshido\webBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AoshidowebBundle:Default:index.html.twig');
    }
    
    public function bioAction()
    {
        return $this->render('AoshidowebBundle:Default:bio.html.twig');
    }
}
