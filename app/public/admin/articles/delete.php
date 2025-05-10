<?php
session_start();
require_once "/app/utils/utils.php";
require_once "/app/requests/articles.php";

checkAdmin();

if (!empty($_POST["title"]) && !empty($_SESSION['csrf_token'])) {
    $title = $_POST["title"];

    // Check Token
    if ($_POST["csrf_token"] === $_SESSION["csrf_token"]) {
        if (deleteArticle($title)) {
            $_SESSION['messages']['success'] = 'Article deleted';
        } else {
            $_SESSION['messages']['danger'] = 'Article not deleted';
        }
    } else {
        $_SESSION['messages']['danger'] = "Token CSRF not valid!";
    }
} else {
    $_SESSION['messages']['danger'] = 'Article does not exist';
}

header('Location: /admin/articles/modify.php');
exit(302);
