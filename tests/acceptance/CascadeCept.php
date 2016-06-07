<?php

use \Codeception\Util\Locator;

 
$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

// Creo una carrera con una materia
$I->wantTo('create a question for a new career with a new assignment with a new theme');
$I->amOnPage('/abms/carreras');
$I->see('Carrera');
$I->amGoingTo('Create a career with an assigment');
$I->fillField('carrera[descripcion]', 'CarreraSelenium');
$I->click('addMateriaButton');
$I->fillField('carrera[materias][0][descripcion]', 'MateriaSelenium');
$I->fillField('carrera[materias][0][aniocarrera]', '4');
$I->click('carrera[save]');
$I->see('Carrera creada !');

//Reviso que se haya creado la materia
$I->amGoingTo('Check that the assigment is created correctly');
$I->amOnPage('/abms/materias');
$I->see('MateriaSelenium');

//Creo un tema para esa materia
$I->amGoingTo('create a theme for the assigment');
$I->amOnPage('/abms/temas');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);
$I->fillField('tema[descripcion]', 'TemaSelenium');
$I->selectOption('tema[carrera]',array('text' => 'CarreraSelenium'));
$I->selectOption('tema[materia]',array('text' => 'MateriaSelenium'));
$I->click('tema[save]');

//Creo una pregunta para esa materia
$I->amGoingTo('create a question for the theme');
$I->amOnPage('/abms/preguntas');
$I->see('Preguntas');
$I->click(['xpath' => '//h3[@class=\'panel-title \']']);
$I->fillCkEditorById('pregunta_contenido', "PreguntaSelenium");
$I->selectOption('pregunta[carrera]',array('text' => 'CarreraSelenium'));
$I->selectOption('pregunta[materia]',array('text' => 'MateriaSelenium'));
$I->selectOption('pregunta[temas][]',array('text' => 'TemaSelenium'));
$I->click('pregunta[save]');
$I->see('Pregunta Agregada !');

//Borro la carrera y se deberia haber borrado todo al infierno
$I->amGoingTo('Delete the carreer');
$I->amOnPage('/abms/carreras');
$I->see('Carrera');
$I->click(Locator::elementAt('//button[@class=\'btn btn-danger\']', -1));
$I->see('¿Seguro que desea borrar la carrera?');
$I->click(['xpath' => '//button[@class=\'btn btn-small btn-success confirm-dialog-btn-confirm\']']);
$I->see('Carrera Eliminada !');
$I->amOnPage('/abms/materias');
$I->dontSee('MateriaSelenium');
$I->amOnPage('/abms/temas');
$I->dontSee('TemaSelenium');
$I->amOnPage('/abms/preguntas');
$I->dontSee('PreguntaSelenium');