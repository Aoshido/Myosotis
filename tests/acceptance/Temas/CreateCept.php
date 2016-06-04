<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

$I->wantTo('Create a tema');
$I->amOnPage('/abms/temas');
$I->see('Temas');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);

$I->fillField('tema[descripcion]', 'TemaSelenium');
$I->selectOption('tema[carrera]', '1');
$I->selectOption('tema[materia]', '1');
$I->click('tema[save]');

$I->see('Tema Agregado !');