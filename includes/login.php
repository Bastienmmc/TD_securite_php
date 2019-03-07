<?php
require_once('connection.php');
require('functions.php');

secure_session_start();

if (isset($_SESSION['login'])) {
        header('location:../view.php');
    } 

if (($_POST['login']!= '') AND ($_POST['password']!=''))  {
    //$name = isset($_POST['name']) ? validatorUsername($_POST['name']) : NULL;
        $login = isset($_POST['login']) ? validateLogin($_POST['login']) : null;   
        $pass = htmlspecialchars($_POST['password']);

        //  Récupération de l'utilisateur et de son pass hashé
        $req = $bdd->prepare('SELECT login,mot_de_passe FROM utilisateurs WHERE login = :login');
        $req->execute(array(
            'login' => $login));
        $resultat = $req->fetch();

        // Comparaison du pass envoyé via le formulaire avec la base
        $isPasswordCorrect = password_verify($pass, $resultat['mot_de_passe']);        
        //$_POST = array();
        $req->closeCursor();

    if (!$resultat){
        //$_POST = array();
        $_SESSION['msg'] = '<p style="color:red;">Login ou mot de passe incorrect</p>';
        header('location:../view.php');
    }
    else if (!$isPasswordCorrect) {
        //$_POST = array();
        $_SESSION['msg'] = '<p style="color:red;">Login ou mot de passe incorrect</p>';
        header('location:../view.php');
    }
    else if ($isPasswordCorrect) {
        //on peut démarrer une nouvelle session
            session_destroy();
            secure_session_start();
            $_SESSION['login'] = $login;
            // Récupération du groupe pour définir les autorisations
            $req = $bdd->prepare('SELECT groupes.nom, utilisateurs.login
                                FROM groupes INNER JOIN utilisateurs
                                ON utilisateurs.id_groupes = groupes.id WHERE utilisateurs.login =:login');
            $req->execute(array(
                    'login' => $login
                        ));
            $resultat = $req->fetch();
            $req->closeCursor();                                
            $_SESSION['groupe'] = $resultat['nom'];
            header('location:../view.php');

        }    
    } 
    else {
        //$_POST = array();     
        $_SESSION['msg'] = '<p style="color:red;">Login ou mot de passe incorrect</p>';
        header('location:../view.php');  
}