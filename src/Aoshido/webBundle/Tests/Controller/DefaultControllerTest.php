<?php

namespace Aoshido\webBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PreguntasControllerTest extends WebTestCase {

    public function testOutOfBounds() {
        $client = static::createClient();

        $client->request('GET', '/abms/preguntas');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $client->request('GET', '/admin/users');
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $client->request('GET', '/urlerrada');
        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
        
        $client->request('GET', '/games/challenge');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testIndex() {
/*
        $client = static::createClient();

        $crawler = $client->request('GET', '/games/challenge');

        $form = $crawler->selectButton('pregunta_save')->form(array(
            'pregunta[carrera]' => '1',                 //Ing en sistemas
            'pregunta[materia]' => '3',                 //Sisop
            'pregunta[temas][]' => '2',                 //Raid
        ));
        $form['pregunta[carrera]'] = '1';
        $form['pregunta[materia]'] = '3';
        $form['pregunta[temas][]'] = '2';
        // submit the form
        $crawler = $client->submit($form);

        $client->getResponse()->getStatusCode();
        dump($client->getResponse());
        //$this->assertTrue($crawler->filter('html:contains("Preguntas")')->count() > 0);
  */      
    }

}
