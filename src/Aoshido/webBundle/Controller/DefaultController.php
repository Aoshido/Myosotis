<?php

namespace Aoshido\webBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $session = $request->getSession();
        // store an attribute for reuse during a later user request
        $session->set('foo', 'bar');
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

    public function cacheClearAction($env) {
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input1 = new ArrayInput(array(
            'command' => 'assetic:dump',
            '--env' => 'dev'
        ));
        $output1 = new BufferedOutput();

        $application->run($input1, $output1);
        $content1 = $output1->fetch();
        $this->get('session')->getFlashBag()->add('success', 'Assetic dump: ' . $content1);

        $input2 = new ArrayInput(array(
            'command' => 'assets:install',
            '--env' => $env
        ));
        $output2 = new BufferedOutput();

        $application->run($input2, $output2);
        $content2 = $output2->fetch();
        $this->get('session')->getFlashBag()->add('success', 'Assets Install: ' . $content2);

        $input3 = new ArrayInput(array(
            'command' => 'cache:clear',
            '--env' => $env
        ));
        $output3 = new BufferedOutput();

        $application->run($input3, $output3);
        $content3 = $output3->fetch();
        $this->get('session')->getFlashBag()->add('success', 'Cache Clear: ' . $content3);

        $content[] = $content1;
        $content[] = $content2;
        $content[] = $content3;

        //return $this->redirect($this->generateUrl('aoshidoweb_homepage'));
        return new Response(implode("", $content));
    }

    public function trhowFive() {
        $response = new Response();
        $response->setStatusCode(500);
        return $response;
    }

}
