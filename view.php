<?php
require_once('includes/connection.php');
require('includes/functions.php');

secure_session_start();

if (!isset($_SESSION['login'])) {
    $screen = formLogin();
    printForm($screen);
}

if (isset($_SESSION['login'])) {

    echo "<h3>Bonjour " . $_SESSION['login'] . "</h3>" ;
    $_SESSION['groupe'] = 'administrateurs';

            //récupérer le groupe de l'utilisateur
            if ($_SESSION['groupe'] == 'administrateurs') {                
                $screen = formAdmin();
                printForm($screen);
                }

            if ($_SESSION['groupe'] == 'utilisateurs') {
                //affichage des messages d'erreur
                if ((isset($_SESSION['msg'])) AND  ($_SESSION['msg'] !== '')) {
                    echo $_SESSION['msg'];
                    $_SESSION['msg']='';
                } else {
                    echo "<p>Vous pouvez modifier votre mot de passe : </p>";
                    
                }               
                //Génération du formulaire
                $screen = formUser();
                printForm($screen);
                
            }
    
    //Déconnection
    echo "<p><a href='includes/logout.php'>Se déconnecter</a></p>";
        }