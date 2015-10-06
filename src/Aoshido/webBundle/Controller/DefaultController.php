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
        $message = \Swift_Message::newInstance()
                ->setSubject('Hola, soy tama del Futuro!')
                ->setFrom('notifications@aoshido.com.ar')
                ->setTo('aoshido@gmail.com')
                ->setBody(
                $this->renderView(
                        'Emails/welcome.html.twig', array('name' => 'Aca va el placeholder')
                ), 'text/html'
                )
        ;
        $this->get('mailer')->send($message);
        return $this->render('AoshidowebBundle:Default:bio.html.twig');
    }

}
