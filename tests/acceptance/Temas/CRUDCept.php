<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

//Create
$I->wantTo('Create a tema');
$I->amOnPage('/abms/temas');
$I->see('Agregar Temas');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);
$I->fillField('tema[descripcion]', 'TemaSelenium');
$I->selectOption('tema[carrera]', '1');
$I->selectOption('tema[materia]', '1');
$I->click('tema[save]');
$I->see('Tema Agregado !');

//Edit
$I->wantTo('Delete a Tema');
$I->amOnPage('/abms/temas');
$I->see('Agregar Temas');
$I->click(['xpath' => '//button[@data-original-title=\'Editar\']']);
$I->see('Editar Tema');
$I->fillField('tema[descripcion]', 'TemaSeleniumEditado');
$I->selectOption('tema[carrera]', '1');
$I->selectOption('tema[materia]', '1');
$I->click('tema[save]');
$I->see('Tema Editado !');
$I->see('TemaSeleniumEditado');

//Delete
$I->wantTo('Delete a Tema');
$I->amOnPage('/abms/temas');
$I->see('Agregar Temas');
$I->click(['xpath' => '//button[@data-original-title=\'Eliminar\']']);
$I->see('¿Seguro que desea borrar el Tema?');
$I->click(['xpath' => '//button[@class=\'btn btn-small btn-success confirm-dialog-btn-confirm\']']);
$I->see('Tema Eliminado !');