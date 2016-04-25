<?php

namespace Aoshido\adminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller {

    public function indexAction() {
        return $this->render('AoshidoadminBundle:Dashboard:index.html.twig');
    }

}
