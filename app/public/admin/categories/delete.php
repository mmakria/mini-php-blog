<?php
session_start();
require_once '/app/utils/utils.php';
checkAdmin();
require_once '/app/requests/categories.php';

if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['messages']['danger'] = 'CSRF token is invalid.';
    header('Location:/admin/categories/dashboard.php');
    exit(302);
}


$id = $_POST['id'];

//verif si la categorie existe avec l'id
if (getCategoryById($id)) {

    if (!empty($_POST['id'])) {
        $id = strip_tags($_POST['id']);
        if (deleteCategory($id)) {
            $_SESSION['messages']['success'] = "Category has been deleted";
        } else {
            $_SESSION['messages']['danger'] = "Category could not be deleted";
        }
    }
} else {
    $_SESSION['messages']['danger'] = 'Category not found.';
}

header('Location: /admin/categories/dashboard.php');
exit(302);