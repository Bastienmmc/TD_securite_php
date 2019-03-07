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
    $form[] = "<h4>Veuillez vous connecter</h4>\n";
    $form[] = "<form action='includes/login.php' method='POST'>\n";
    $form[] = "<label for='login'>Login : </label>\n";
    $form[] = "<input type='text' name='login' id='login' required>\n";
    $form[] = "<br>\n";
    $form[] = "<label for='password'>Password : </label>\n";
    $form[] = "<input type='password' name='password' id='password' required><br>\n";
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
 * Génération du formulaire création d'utilisateur
 */
function createUser() {
    $form = [];
     $form[] = "<h4>Créer un utilisateur</h4>\n";
    $form[] = "<form action='includes/createUser.php' method='POST'>\n";
    $form[] = "        <input type='hidden' >\n";
    $form[] = "        <label for='login'>Login : </label><input type='text' class='text' name='login' required><br>\n";
    $form[] = "        <label for='nom_complet'>Nom complet : </label><input type='text' class='text' name='nom_complet'required><br>\n";
    $form[] = "        <label for='age'>Age : </label><input type='text' class='text' name='age'required><br>\n";
    $form[] = "        <label for='code_postal'>Code postal : </label><input type='text' class='text' name='code_postal'required><br>\n";
    $form[] = "        <label for='telephone'>Téléphone : </label><input type='text' class='text' name='telephone'required><br>\n";
    $form[] = "        <label for='metier'>Métier : </label><input type='text' class='text' name='metier'required><br>\n";
    $form[] = "        <br>\n";
    $form[] = "        <input type='submit' value='Envoyer'>\n";
    $form[] = "    </form>\n";
    return $form;
}

/**
 * Génération du formulaire création de groupe
 */
function createGroup() {
    $form = [];
    $form[] = "<h4>Créer un groupe</h4>\n";
    $form[] = "    <form action='includes/createGroup.php' method='POST'>\n";
    $form[] = "        <input type='hidden'>\n";
    $form[] = "        <label for='nom'>Nom : </label><input type='text' class='text' name='nom' required><br>\n";
    $form[] = "        <label for='description'>Description : </label><input type='text' class='text' name='description' required><br>\n";
    $form[] = "        <br>\n";
    $form[] = "        <input type='submit' value='Envoyer'>\n";
    $form[] = "    </form>\n";
    return $form;
}

/**
 * Génération du formulaire modification de groupe
 */
function changeGroup() {
    $form = [];
    $form[] = "<h4>Changer les droits d'un utilisateur</h4>\n";
    $form[] = "    <form action='includes/changeGroup' method='POST'>\n";
    $form[] = "        <input type='hidden'>\n";
    $form[] = "        <label for='login'>Utilisateur (login) : </label><input type='text' class='text' name='login' required><br>\n";
    $form[] = "        <label for='nom'>Nom du nouveau groupe : </label><input type='text' class='text' name='nom' required><br>\n";
    $form[] = "        <br>\n";
    $form[] = "       <input type='submit' value='Envoyer'>\n";
    $form[] = "    </form>\n";
    return $form;
}

/**
 * Fonction permettant d'initialiser le formulaire à destination des utilisateurs simples
 */
function formUser() {
    $form = [];
    $form[] = "<form action='includes/changePasswordUser.php' method='POST'>\n";
    $form[] = "    <label for='oldPwd'>Ancien mot de passe : </label>\n";
    $form[] = "    <input type='password' name='oldPwd' id='oldPwd' required>\n";
    $form[] = "    <br>\n";
    $form[] = "    <label for='newPwd'>Nouveau mot de passe : </label>\n";
    $form[] = "    <input type='password' name='newPwd' id='newPwd' required>\n";
    $form[] = "    <br>\n";
    $form[] = "    <label for='newPwdCfm'>Confirmez le mot de passe : </label>\n";
    $form[] = "    <input type='password' name='newPwdCfm' id='newPwdCfm' required>\n";
    $form[] = "    <br>\n";
    $form[] = "    <br>\n";
    $form[] = "    <input type='submit'>\n";
    $form[] = "</form>\n";
    return $form;
}

function addUser() {
    $form =[];

}

/**
 * Vérification du login
 */
function validateLogin($str){   
    $motif='%^[[:alpha:]][[:alnum:]]{0,19}$%';
    if (preg_match($motif, $str)) {
        return  $str;
    } else return NULL; 
}

/**
 * Vérification du nom complet
 */
function validateName($str){   
    $motif='%^[-[:alnum:]’[:punct:][:space:]]{3,50}$%';
    if (preg_match($motif, $str)) {
        return  $str;
    } else return NULL; 
}

/**
 * Vérification de l'age
 */
function validateAge($str){
    $motif='%^[0-9]{2,3}$%';
    if (preg_match($motif, $str)) {
        return  $str;
    } else return NULL; 
}

/**
 * Vérification du code postal
 */
function validateCode($str){   
    $motif='%^[0-9]{5}$%';
    if (preg_match($motif, $str)) {
        return  $str;
    } else return NULL; 
}

/**
 * Vérification du téléphone
 */
function validatePhoneNumber($str){
    $motif='%^[0-9]{2}([- .]?[0-9]{2}){4}$%';
    if (preg_match($motif, $str)) {
        return  $str;
    } else return NULL; 
}



/**
 * Vérification du Mot de passe
 */
function validatePassword($str){   
    $motif='%^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,20}$%';
    if (preg_match($motif, $str)) {
        return  $str;
    } else return NULL; 
}


/**
 * Vérification de la description
 */
function validateDescription($str){   
    $motif='%^[-[:alnum:]’[:punct:][:space:]]{3,200}$%';
    if (preg_match($motif, $str)) {
        return  $str;
    } else return NULL; 
}