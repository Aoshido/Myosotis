<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

//Create
$I->wantTo('Create a Carrera');
$I->amOnPage('/abms/carreras');
$I->see('Agregar Carrera:');
$I->fillField('carrera[descripcion]', 'CarreraSelenium');
$I->click('carrera[save]');
$I->see('CarreraSelenium');
$I->see('Carrera creada !');

//Edit
$I->wantTo('Delete a Carrera');
$I->amOnPage('/abms/carreras');
$I->click(['xpath' => '//button[@data-original-title=\'Editar\']']);
$I->see('Editar Carrera');
$I->fillField('carrera[descripcion]', 'CarreraSeleniumEditada');
$I->click('carrera[save]');
$I->see('CarreraSeleniumEditada');
$I->see('Carrera Editada !');

//Delete
$I->wantTo('Delete a Carrera');
$I->amOnPage('/abms/carreras');
$I->see('Carrera');
$I->click(['xpath' => '//button[@data-original-title=\'Eliminar\']']);
$I->see('¿Seguro que desea borrar la carrera?');
$I->click(['xpath' => '//button[@class=\'btn btn-small btn-success confirm-dialog-btn-confirm\']']);
$I->see('Carrera Eliminada !');