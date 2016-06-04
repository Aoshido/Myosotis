<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->wantTo('Login');
$I->amOnPage('/');
$I->fillField('_username', 'Aoshido');
$I->fillField('_password', 'Aoshido');
$I->click('_submit');
$I->see('Aoshido');

$I->wantTo('Create a question');
$I->amOnPage('/abms/preguntas');
$I->see('Preguntas');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);
$I->fillCkEditorById('pregunta_contenido', "PreguntaSELES");
$I->selectOption('pregunta[carrera]', '1');
$I->selectOption('pregunta[materia]', '1');
$I->selectOption('pregunta[temas][]', '1');
$I->click('pregunta[save]');
$I->see('Pregunta Agregada !');