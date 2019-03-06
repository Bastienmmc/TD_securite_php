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
        $_POST = array();


        

    if (!$resultat)
    {
        $_POST = array();
        header('location:error.php?err=Login ou mot de passe incorrect');
    }
    else if (!$isPasswordCorrect) {
        $_POST = array();
        header('location:error.php?err=Login ou mot de passe incorrect');
    }
    else if ($isPasswordCorrect) {
        //on peut démarrer une nouvelle session
            session_destroy();
            secure_session_start();
            $_SESSION['login'] = $login;
            // Récupération du groupe pour définir les autorisations
            
            $req = $bdd->query('SELECT utilisateurs.login,
                                groupes.nom
                                FROM utilisateurs, groupes
                                WHERE utilisateurs.id_groupes = groupes.id');
                                $resultat = $req->fetch();
            $_SESSION['groupe'] = $resultat['nom'];
            header('location:../view.php');
        }
    
    } else {
            $_POST = array();     
            header('location:error.php?err=Login ou mot de passe incorrect');  
}