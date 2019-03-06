<?php
require_once('connection.php');
require('functions.php');

secure_session_start();

//En cas de session non ouverte, redirection vers la vue
if (!isset($_SESSION['login'])) {
        header('location:../view.php');
        exit;
    } 

//Vérification que la session est bien ouverte et que les droits sont en utilisateurs
if (isset($_SESSION['login']) AND ($_SESSION['groupe']==='utilisateurs')) {
    session_regenerate_id();
    $newPwd = htmlspecialchars($_POST['newPwd']);
    $newPwdCfm = htmlspecialchars($_POST['newPwdCfm']);
    $pass = htmlspecialchars($_POST['oldPwd']);

    // Vérification de la cohérence entre les 2 nouveaux mots de passe 
    if ( $newPwd !== $newPwdCfm){
        $_SESSION['msg'] = '<p style="color:red;">Les deux mots de passe doivent être identiques</p>';
        header('location:../view.php');
    } 

    else if ( $newPwd == $pass) {
        //Si le nouveau mot de passe est identique à l'ancien
        $_SESSION['msg'] = '<p style="color:red;">Le nouveau mot de passe doit être différent de l\'ancien</p>';
        header('location:../view.php');     
    } 

    else if ( $newPwd === $newPwdCfm) {
         //Vérification de l'ancien mot de passe
        $login = $_SESSION['login'];        
        
        //  Récupération de l'utilisateur et de son pass hashé
        $req = $bdd->prepare('SELECT login,mot_de_passe FROM utilisateurs WHERE login = :login');
        $req->execute(array(
            'login' => $login));
        $resultat = $req->fetch();

        // Comparaison du pass envoyé via le formulaire avec la base
        $isPasswordCorrect = password_verify($pass, $resultat['mot_de_passe']);        
        
        if (!$isPasswordCorrect) {
            //En cas d'erreur, redirection
            $_SESSION['msg'] = '<p style="color:red;">Veuillez vérifier votre mot de passe</p>';
            header('location:../view.php');
        }        
        else if ($isPasswordCorrect) {
            //Modification du mot de passe
            $req = $bdd->prepare('UPDATE utilisateurs SET mot_de_passe = :nouveauMdp WHERE login = :login');

            try {
                $req->execute(array(
                'nouveauMdp' => password_hash($newPwd,PASSWORD_DEFAULT),
                'login' => $login));
            }
            catch (Exception $e) {
                $_SESSION['msg'] = '<p style="color:red;">Une erreur est survenue : ' . $e->getMessage() . '</p>';
                header('location:../view.php');
            } 

            //Confirmation de la modification
            $_SESSION['msg'] = '<p style="color:red;">Modification effectuée, vous avez modifié votre mot de passe ' . $_SESSION['login'] . '</p>';
            //redirection
            header('location:../view.php');

        }
    }
   

    //Array ( [oldPwd] => anc [newPwd] => nouv [newPwdCfm] => nouve )
    
    
    
}