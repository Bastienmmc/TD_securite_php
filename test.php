<?php
echo password_hash('12345', PASSWORD_DEFAULT);

require('autoload.php');

$form = new FormGenerator('view.php', FormGenerator::METHOD_POST);

$form->addLabel('login', 'Login : ');
$form->addInput('text', 'login', array('id' => 'login'));
$form->addNewLine();

$form->addLabel('password', 'Password : ');
$form->addInput('password', 'password', array('id' => 'password'));
$form->addNewLine();

$form->addInput('submit', '');

$form->displayForm('Login', true);