<?php

namespace Aoshido\webBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $locale = $request->getLocale();

        //$this->get('session')->getFlashBag()->set('success', 'Dale que vaa');
        $this->get('session')->getFlashBag()->add('success', 'Dale que vaa');
        $this->get('session')->getFlashBag()->add('error', 'Warning, ojo e' );
        $this->get('session')->getFlashBag()->add('danger', 'Danger, algo se cago');
        $this->get('session')->getFlashBag()->add('info', 'EEste de info es horrible');
        
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
