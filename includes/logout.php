<?php
require_once('functions.php');
secure_session_start();

// Suppression des variables de session et de la session
$_SESSION = array();


session_destroy();

// Suppression des cookies de connexion automatique
setcookie('login', '');

$url = "../view.php";

header("Location:$url");
exit;
