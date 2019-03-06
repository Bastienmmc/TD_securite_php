<?php
require('autoload.php');

/**
 * Fonction permettant d'afficher le formulaire en fonction du paramètre reçu en entrée
 */
function printForm ($form) {
    foreach ($form as $ligne) {
        echo $ligne;
    }
}

/**
 * Fonction permettant d'initialiser le formulaire de connexion
 */
function formLogin() {
    $form = [];
    $form[] = "<form action='includes/login.php' method='POST'>\n";
    $form[] = "<label for='login'>Login : </label>\n";
    $form[] = "<input type='text' name='login' id='login' >\n";
    $form[] = "<br>\n";
    $form[] = "<label for='password'>Password : </label>\n";
    $form[] = "<input type='password' name='password' id='password' >\n";
    $form[] = "<br>\n";
    $form[] = "<input type='submit'  >\n";
    $form[] = "</form>\n";
    return $form;
}

/**
 * Fonction destinée à remplacer la fonction session_start()
 * Permet de configuree le cookie en http only ou en secure pour éviter les failles
 */
function secure_session_start() {    
    $session_name = 'secure_session';   // Attribue un nom de session
    $secure = false;
    // Cette variable empêche Javascript d’accéder à l’id de session
    $httponly = true;
    // Force la session à n’utiliser que les cookies
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location:error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Récupère les paramètres actuels de cookies
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"]=3600,
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
    // Donne à la session le nom configuré plus haut
    session_name($session_name);
    session_start();            // Démarre la session PHP 
    session_regenerate_id(true);    // Génère une nouvelle session et efface la précédente
}

/**
 * 
 */
function formAdmin() {
    $form = [];
    $form[] = "<p>Félicitation, vous etes administrateur, vous pouvez donc:</p>\n";
    $form[] = "<ul>\n";
    $form[] = "    <li><a href='includes/createUser.php'>Créer un utilisateur</a></li>\n";
    $form[] = "    <li><a href='includes/createGroup.php'>Créer un groupe</a></li>\n";
    $form[] = "    <li><a href='includes/changeGroup'>Changer les droits d'un utilisateur</a></li>\n";
    $form[] = "</ul>\n";
    return $form;
}

/**
 * Fonction permettant d'initialiser le formulaire à destination des utilisateurs simples
 */
function formUser() {
    $form = [];
    $form[] = "<form action='includes/changePasswordUser.php' method='POST'>\n";
    $form[] = "    <label for='oldPwd'>Ancien mot de passe : </label>\n";
    $form[] = "    <input type='password' name='oldPwd' id='oldPwd'>\n";
    $form[] = "    <br>\n";
    $form[] = "    <label for='newPwd'>Nouveau mot de passe : </label>\n";
    $form[] = "    <input type='password' name='newPwd' id='newPwd'>\n";
    $form[] = "    <br>\n";
    $form[] = "    <label for='newPwdCfm'>Confirmez le mot de passe : </label>\n";
    $form[] = "    <input type='password' name='newPwdCfm' id='newPwdCfm'>\n";
    $form[] = "    <br>\n";
    $form[] = "    <br>\n";
    $form[] = "    <input type='submit'>\n";
    $form[] = "</form>\n";
    return $form;
}

function addUser() {
    $form = new FormGenerator('includes/changePAsswordUser.php', FormGenerator::METHOD_POST);

}
