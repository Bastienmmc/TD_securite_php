<?php
require_once('connection.php');
require('functions.php');

secure_session_start();

//En cas de session non ouverte, redirection vers la vue
if (!isset($_SESSION['login'])) {
        header('location:../view.php');
        exit;
    } 

//passage au htmlspecialchars que tous les éléments recus
foreach ($_POST as $key => $val) {
    $val = htmlspecialchars($val);
}
//validation de l'écriture du nom d'utilisateur

$utilisateur = validateName($_POST['login']);
if ($utilisateur == '') {
     $_SESSION['msg'] = 'Veuillez corriger le login';
    header('location:../view.php');
    exit;
}

$groupe = $_POST['nom'];

//Vérifier si l'utilisateur existe


// Vérifier si utilisateur n'est pas déjà dans ce groupe


// Vérifier si le groupe existe ou est bien orthographié


// une fois toute les vérification faites, effectuer la modification