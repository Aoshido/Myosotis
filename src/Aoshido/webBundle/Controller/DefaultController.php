<?php

namespace Aoshido\webBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    public function cacheClearAction() {
        $result = [];
        exec('rm -r ../app/cache/*', $result);

        foreach ($result as $resultado) {
            $this->get('session')->getFlashBag()->add('success', 'Cache Cleared: ' . $resultado);
        }

        return $this->redirect('//');
    }

    public function trhowFive() {
        $response = new Response();
        $response->setStatusCode(500);
        return $response;
    }

}
