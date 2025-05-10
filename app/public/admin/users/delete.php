<?php
session_start();
require_once "/app/utils/utils.php";
checkAdmin();

// Récupérer le user grace à l'ID dans $_POST
require_once "/app/requests/users.php";

$user = !empty($_POST['id']) && ctype_digit($_POST['id'] ) ? findOneUserById($_POST['id']) : null;

if (!$user) {
    $_SESSION['messages']['danger'] = 'User not found';
    header("Location: /admin/users");
    exit(302);
}

if (deleteUser($user['id'])) {
    $_SESSION['messages']['success'] = 'User deleted successfully';
}else{
    $_SESSION['messages']['danger'] = 'User not found';
}

header("Location: /admin/users");
exit(302);