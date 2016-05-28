<?php
 
$I = new AcceptanceTester($scenario);
$I->wantTo('ensure that front page works');
$I->amOnPage('/');
$I->see('Estudiantes');
