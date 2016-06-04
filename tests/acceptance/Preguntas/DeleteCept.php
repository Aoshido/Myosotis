<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

$I->wantTo('Delete a Pregunta');
$I->amOnPage('/abms/preguntas');
$I->see('Preguntas');

$I->click(['xpath' => '//div[@style=\'height:150px;overflow:hidden; text-overflow:ellipsis;\']']);
$I->wait(1);
$I->see('Respuestas posibles:');
$I->click(['xpath' => '//button[@data-original-title=\'Eliminar\']']);
$I->see('¿Seguro que desea borrar la Pregunta?');
$I->click(['xpath' => '//button[@class=\'btn btn-small btn-success confirm-dialog-btn-confirm\']']);
$I->see('Pregunta Eliminada !');