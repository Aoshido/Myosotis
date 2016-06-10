<?php

class MateriaCest {

    public function _before(FunctionalTester $I) {
        
    }

    public function _after(FunctionalTester $I) {
        
    }
/*
    public function DarAltaMateriaUnica(FunctionalTester $I) {
        $I->wantTo('Create 2 Materias with the same name');
        $I = $this->executeLogin($I);
        $I->amOnPage('/abms/materias');
        $I->seeInCurrentUrl('/abms/materias');

        $I->submitForm(
                'form#materia_form', [
            'materia[descripcion]' => 'testUnico',
            'materia[aniocarrera]' => '1',
            'materia[careraras][]' => '[1]',
                ]
        );
        $I->see("Materia Creada");

        $I->submitForm(
                'form#materia_form', [
            'materia[descripcion]' => 'testUnico',
            'materia[aniocarrera]' => '1',
            'materia[careraras][]' => '[1]',
                ]
        );
        $I->see("Ya existe una materia con ese nombre");
    }

    public function LlenarMalFormulario(FunctionalTester $I) {
        $I->wantTo('Fill a bad creation form');
        $I = $this->executeLogin($I);
        $I->amOnPage('/abms/materias');
        $I->seeInCurrentUrl('/abms/materias');

        $I->submitForm(
                'form#materia_form', [
            'materia[descripcion]' => '',
                ]
        );
        $I->see("La descripcion no puede estar vacia");

        $I->submitForm(
                'form#materia_form', [
            'materia[descripcion]' => '',
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
