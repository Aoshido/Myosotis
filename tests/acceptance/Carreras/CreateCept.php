<?php
use \Codeception\Util\Locator;

$I = new AcceptanceTester($scenario);
$I->login('Aoshido', 'Aoshido');

$I->wantTo('Create a Carrera');
$I->amOnPage('/abms/carreras');
$I->see('Carrera');

$I->fillField('carrera[descripcion]', 'CarreraSelenium');
$I->click('carrera[save]');

$I->see('Carrera creada !');