<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

//Create
$I->wantTo('create a question');
$I->amOnPage('/abms/preguntas');
$I->see('Agregar Preguntas');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);
$I->fillCkEditorById('pregunta_contenido', "PreguntaSELES");
$I->selectOption('pregunta[carrera]', '1');
$I->selectOption('pregunta[materia]', '1');
$I->selectOption('pregunta[temas][]', '1');
$I->click('pregunta[save]');
$I->see('Pregunta Agregada !');

//Edit
$I->wantTo('edit a pregunta');
$I->amOnPage('/abms/preguntas');
$I->see('Agregar Preguntas');
$I->click(['xpath' => '//div[@style=\'height:150px;overflow:hidden; text-overflow:ellipsis;\']']);
$I->wait(1);
$I->see('Respuestas posibles:');
$I->click(['xpath' => '//button[@title=\'Editar\']']);
$I->see('Editar Pregunta');
$I->fillCkEditorById('pregunta_contenido', "PreguntaSELESEditada");
$I->selectOption('pregunta[carrera]', '1');
$I->selectOption('pregunta[materia]', '1');
$I->selectOption('pregunta[temas][]', '1');
$I->click('pregunta[save]');
$I->see('Pregunta Editada !');

//Delete
$I->wantTo('delete a question');
$I->amOnPage('/abms/preguntas');
$I->see('Agregar Preguntas');
$I->click(['xpath' => '//div[@style=\'height:150px;overflow:hidden; text-overflow:ellipsis;\']']);
$I->wait(1);
$I->see('Respuestas posibles:');
$I->click(['xpath' => '//button[@data-original-title=\'Eliminar\']']);
$I->see('¿Seguro que desea borrar la Pregunta?');
$I->click(['xpath' => '//button[@class=\'btn btn-small btn-success confirm-dialog-btn-confirm\']']);
$I->see('Pregunta Eliminada !');