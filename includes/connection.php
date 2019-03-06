<?php
/**
 * Connect to mySQL database
 * dbname : TP_securite_info
 * user : root
 * password : *jVzTD[-4Qs2
 */
try {
$bdd = new PDO('mysql:host=localhost;dbname=tp_securite_info;charset=utf8', 'root','*jVzTD[-4Qs2');
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}