<?php

namespace Aoshido\webBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $locale = $request->getLocale();
        return $this->render('AoshidowebBundle:Default:index.html.twig', array(
                    'locale' => $locale));
    }

    public function bioAction() {
        return $this->render('AoshidowebBundle:Default:bio.html.twig');
    }
    
    public function faqAction() {
        return $this->render('AoshidowebBundle:Default:faq.html.twig');
    }

}
