<?php
require_once('includes/connection.php');
require('includes/functions.php');

secure_session_start();

if (!isset($_SESSION['login'])) {
    if ((isset($_SESSION['msg'])) AND  ($_SESSION['msg'] !== '')) {
        echo $_SESSION['msg'];
        $_SESSION['msg']='';
    }
    $screen = formLogin();
    printForm($screen);
}

if (isset($_SESSION['login'])) {

    echo "<h3>Bonjour " . $_SESSION['login'] . "</h3>" ;

            //récupérer le groupe de l'utilisateur
            if ($_SESSION['groupe'] == 'administrateurs') {   
                echo "<p>Félicitation, vous etes administrateur, vous pouvez donc:</p>";          
                if (!empty($_SESSION['msg'])) {//vérification d'erreur précédentes
                    foreach ($_SESSION['msg'] as $val) {
                        echo $val;
                    }
                    $_SESSION['msg']='';
                } 
                //premier choix
                $screen = createUser();
                printForm($screen);
                //Deuxième choix
                $screen = createGroup();
                printForm($screen);
                //troisième choix
                $screen = changeGroup();
                printForm($screen);
                }    
            

            if ($_SESSION['groupe'] == 'utilisateurs') {
                //affichage des messages d'erreur
                if ((isset($_SESSION['msg'])) AND  ($_SESSION['msg'] !== '')) {
                    echo $_SESSION['msg'];
                    $_SESSION['msg']='';
                } else {
                    echo "<p>Vous pouvez modifier votre mot de passe : </p>";
                    echo "<p><em>1 majuscule, 1 minuscule, 1 chiffre et 1 caractère spécial minimum, 8 caractères minimum</em></p>";
                    
                }               
                //Génération du formulaire
                $screen = formUser();
                printForm($screen);
                
            }
    
    //Déconnection
    echo "<p><a href='includes/logout.php'>Se déconnecter</a></p>";
        }