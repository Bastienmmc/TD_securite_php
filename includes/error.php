<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = 'Oups! Une erreur s’est produite.';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Erreur lors de la connexion sécurisée</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <h1>Erreur d'authentification</h1>
        <p class="error"><?php echo $error; ?></p>
        <p><a href="../view.php">Retour à la page de connexion</a></p>
    </body>
</html>