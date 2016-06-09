<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

//Create
$I->wantTo('create a subject');
$I->amOnPage('/abms/materias');
$I->see('Agregar Materias');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);
$I->fillField('materia[descripcion]', 'MateriaSelenium');
$I->fillField('materia[aniocarrera]', '2');
$I->selectOption('materia[carreras][]', '1');
$I->click('materia[save]');
$I->see('Materia Agregada !');

//Edit
$I->wantTo('edit a subject');
$I->amOnPage('/abms/materias');
$I->click(['xpath' => '//button[@data-original-title=\'Editar\']']);
$I->see('Editar materias');
$I->fillField('materia[descripcion]', 'MateriaSeleniumEditada');
$I->fillField('materia[aniocarrera]', '4');
$I->selectOption('materia[carreras][]', '2');
$I->click('materia[save]');
$I->see('Materia editada !');

//Delete
$I->wantTo('delete a subject');
$I->amOnPage('/abms/materias');
$I->see('Agregar Materias');
$I->click(['xpath' => '//button[@data-original-title=\'Eliminar\']']);
$I->see('¿Seguro que desea borrar la Materia?');
$I->click(['xpath' => '//button[@class=\'btn btn-small btn-success confirm-dialog-btn-confirm\']']);
$I->see('Materia Eliminada !');