<?php
require_once('connection.php');
require('functions.php');

secure_session_start();

//En cas de session non ouverte, redirection vers la vue
if (!isset($_SESSION['login'])) {
        header('location:../view.php');
        exit;
    } 

