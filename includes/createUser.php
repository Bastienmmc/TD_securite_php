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
//Récupération des données du formulaire

$login = array(validateLogin($_POST['login']) => 'Veuillez corriger le login') ;
$nomComplet = array(validateName($_POST['nom_complet']) => 'Veuillez corriger le nom');
$age = array(validateAge($_POST['age']) => "Veuillez corriger l'âge");
$codePostal = array(validateCode($_POST['code_postal']) => 'Veuillez corriger le code postal');
$telephone = array(validatePhoneNumber($_POST['telephone']) => 'Veuillez corriger le numéro de téléphone');
$metier = array(validateDescription($_POST['metier']) => 'Veuillez corriger le métier' );


$tab = array($login, 
    $nomComplet,
    $age,
    $codePostal, 
    $telephone,
    $metier, 
);

$flag = 0;
$msg = [];
foreach($tab as $sousTab) {
   foreach ($sousTab as $key => $val) {
       if (empty($key)) {
           $msg[] = '<p style="color:red;">' . $val . '</p>';
            $flag += 1 ;
       }
   }
}

if ($flag != 0) {
    $_SESSION['msg'] = $msg;
    header('location:../view.php');
    exit;
}