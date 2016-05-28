<?php

class CarreraCest {

    public function _before(FunctionalTester $I) {
        
    }

    public function _after(FunctionalTester $I) {
        
    }

    public function DarAltaCarreraUnica(FunctionalTester $I) {
        $I->wantTo('Create 2 Carreras with the same name');
        $I = $this->executeLogin($I);
        $I->amOnPage('/abms/carreras');
        $I->seeInCurrentUrl('/abms/carreras');

        $I->submitForm(
                'form#carrera_form', [
            'carrera[descripcion]' => 'testUnico',
                ]
        );
        $I->see("Carrera Creada");
        
        $I->submitForm(
                'form#carrera_form', [
            'carrera[descripcion]' => 'testUnico',
                ]
        );
        $I->see("Ya existe una carrera con ese nombre");
    }

    public function LlenarMalFormulario(FunctionalTester $I) {
        $I->wantTo('Fill a bad create form');
        $I = $this->executeLogin($I);
        $I->amOnPage('/abms/carreras');
        $I->seeInCurrentUrl('/abms/carreras');

        $I->submitForm(
                'form#carrera_form', [
            'carrera[descripcion]' => '',
                ]
        );
        $I->see("La descripcion no puede estar vacia");

        $I->submitForm(
                'form#carrera_form', [
                ]
        );
        $I->see("La descripcion no puede estar vacia");
    }

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
