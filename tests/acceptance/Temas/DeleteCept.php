<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

$I->wantTo('Delete a Tema');
$I->amOnPage('/abms/temas');
$I->see('Temas');

$I->click(['xpath' => '//button[@data-original-title=\'Eliminar\']']);
$I->see('¿Seguro que desea borrar el Tema?');
$I->click(['xpath' => '//button[@class=\'btn btn-small btn-success confirm-dialog-btn-confirm\']']);
$I->see('Tema Eliminado !');