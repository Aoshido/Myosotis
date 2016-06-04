<?php
 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure that front page works');
$I->amOnPage('/');
$I->see('Estudiantes');
