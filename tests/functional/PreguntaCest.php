<?php

class PreguntaCest {

    public function _before(FunctionalTester $I) {
        
    }

    public function _after(FunctionalTester $I) {
        
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
