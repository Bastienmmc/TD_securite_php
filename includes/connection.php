<?php
/**
 * Connect to mySQL database
 * dbname : TP_securite_info
 * user : userTP
 * password : C@Nn3#ioN
 */
try {
$bdd = new PDO('mysql:host=localhost;dbname=tp_securite_info;charset=utf8', 'userTP','C@Nn3#ioN');
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}