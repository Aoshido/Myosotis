<?php

class PreguntaCest {

    public function _before(FunctionalTester $I) {
        
    }

    public function _after(FunctionalTester $I) {
        
    }
    
    public function ProbarPreguntaConRespuesta(FunctionalTester $I) {
        $I->seeInRepository('AoshidowebBundle:Pregunta', array(
            'id' => 1,
        ));
        $I->assertTrue(true);
        
        /*
        $user = new \Aoshido\UserBundle\Entity\User;
        //codecept_debug($I->grabFromRepository('AoshidowebBundle:Pregunta', 'id', array('id' => 1)));
        codecept_debug($I->seeInRepository('AoshidowebBundle:Pregunta', array('id' => 1)));
        
        $pregunta = new \Aoshido\webBundle\Entity\Pregunta;
        $pregunta->setContenido("test");
        $pregunta->setActivo(TRUE);
        $pregunta->setCreatorUser();
        
        $respuestaCorrecta1 = new \Aoshido\webBundle\Entity\Respuesta;
        $respuestaCorrecta2 = new \Aoshido\webBundle\Entity\Respuesta;
        $respuestaIncorrecta1 = new \Aoshido\webBundle\Entity\Respuesta;
        
        $pregunta->addRespuesta($respuestaCorrecta1);
        $pregunta->addRespuesta($respuestaCorrecta2);
        
        $I->persistEntity($pregunta);
        //$I->flushToDatabase();
        
        codecept_debug($pregunta->getRespuestasCorrectas());
        
        $respuestasPosibles1 = new \Doctrine\Common\Collections\ArrayCollection;
        $respuestasPosibles1->add($respuestaCorrecta1);
        $respuestasPosibles1->add($respuestaCorrecta2);
        
        $respuestasPosibles2 = new \Doctrine\Common\Collections\ArrayCollection;
        $respuestasPosibles2->add($respuestaCorrecta1);
        
        $respuestasPosibles3 = new \Doctrine\Common\Collections\ArrayCollection;
        $respuestasPosibles3->add($respuestaCorrecta1);
        $respuestasPosibles3->add($respuestaIncorrecta1);
                
        codecept_debug($respuestasPosibles1);
        $I->assertTrue($pregunta->isAnsweredWith($respuestasPosibles1));
         */
    }


    /*
    public function DarAltaCarreraUnica(FunctionalTester $I) {
    }

     */

  /*
   * Los validation corren con un event listener, pero como preguntas
   * tiene "Stop propagation" el evento no le llega nunca y las validaciones
   * hay qeu hacerlas a mano....... ehhhh
   */
    
    /*
    public function LlenarMalFormulario(FunctionalTester $I) {
        $I->wantTo('Fill a bad create form');
        $I = $this->executeLogin($I);
        $I->amOnPage('/abms/preguntas');
        $I->seeInCurrentUrl('/abms/preguntas');

        $I->submitForm(
                'form#pregunta_form', [
                ]
        );
        $I->see("La descripcion no puede estar vacia");
    }
*/
    /*
     * http://stackoverflow.com/questions/20333240/codeception-keep-a-logged-in-state
     */

     /*
    public function DarAltaPregunta(FunctionalTester $I) {
        $I->wantTo('Create a new question');
        $I = $this->executeLogin($I);
        $I->amOnPage('/abms/preguntas');
        $I->seeInCurrentUrl('/abms/preguntas');

        $I->fillField('pregunta[contenido]','testCodeception');
        $I->selectOption('pregunta[carrera]','Ingenieria en sistemas de información');
        $I->wait(1);
        $I->selectOption('pregunta[materia]','Sistemas Operativos');
        $I->selectOption('pregunta[temas][]','Disco');
        $I->click('pregunta[save]');
        $I->see("Pregunta Agregada");
    }
        */

    /*
     * http://stackoverflow.com/questions/20333240/codeception-keep-a-logged-in-state
     */

    private function executeLogin(FunctionalTester $I) {
        $I->amOnPage('/');
        $I->submitForm(
                'form#login_form', [
            '_username' => 'Aoshido',
            '_password' => 'Aoshido',
                ]
        );
        $I->amOnPage('/profile');
        $I->seeInCurrentUrl('/profile');
        return ($I);
    }


}
