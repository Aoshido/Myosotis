<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

$I->wantTo('Create a Materia');
$I->amOnPage('/abms/materias');
$I->see('Materias');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);

$I->fillField('materia[descripcion]', 'MateriaSelenium');
$I->fillField('materia[aniocarrera]', '2');
$I->selectOption('materia[carreras][]', '1');
$I->click('materia[save]');

$I->see('Materia Agregada !');