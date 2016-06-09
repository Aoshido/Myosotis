<?php
use \Codeception\Util\Locator;
/*
$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

//Firefox tiene validaciones HTML5

//Submiteo el form con ""
$I->wantTo('Create an empty career');
$I->amOnPage('/abms/carreras');
$I->see('Agregar Carrera:');
$I->fillField('carrera[descripcion]', '');
$I->click('carrera[save]');
//$I->see('La descripcion no puede estar vacia');
$I->wait(1);
$I->see('Please fill out this field');

//Submiteo el form sin llenar el campo
$I->amOnPage('/abms/carreras');
$I->click('carrera[save]');
//$I->see('La descripcion no puede estar vacia');
$I->wait(1);
$I->see('Please fill out this field');

//Agrego Materias sin descripcion 
$I->amOnPage('/abms/carreras');
$I->fillField('carrera[descripcion]', 'CarreraSelenium');
$I->click('addMateriaButton');
$I->fillField('carrera[materias][0][aniocarrera]', '4');
$I->click('carrera[save]');
//$I->see('La descripcion no puede estar vacia');
$I->wait(1);
$I->see('Please fill out this field');
 * 
 */