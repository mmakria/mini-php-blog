<?php

function checkAdmin () : void
{
    if (empty($_SESSION['user']) || !in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
        // On définit un message d'erreur
        $_SESSION['messages']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('location: /login.php');
        exit(302);
    }
}