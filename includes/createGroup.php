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

$nom = array(validateName($_POST['nom']) => 'Veuillez corriger le nom');
$description = array(validateDescription($_POST['description']) => 'Veuillez corriger la description' );


$tab = array($nom, 
    $description, 
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