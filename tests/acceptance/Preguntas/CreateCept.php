<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

$I->wantTo('Create a pregunta');
$I->amOnPage('/abms/preguntas');
$I->see('Preguntas');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);

//http://stackoverflow.com/questions/29168107/how-to-fill-a-rich-text-editor-field-for-a-codeception-acceptance-test
$I->fillCkEditorById('pregunta_contenido', "PreguntaSELES");
$I->selectOption('pregunta[carrera]', '1');
$I->selectOption('pregunta[materia]', '1');
$I->selectOption('pregunta[temas][]', '1');
$I->click('pregunta[save]');
$I->see('Pregunta Agregada !');