<?php
session_start();
require_once '/app/utils/utils.php';
require_once '/app/requests/articles.php';
require_once '/app/requests/categories.php';

$categories = getAllCategories();
checkAdmin();

if (!empty($_POST['title']) && !empty($_POST['content'])) {

    //Clean the data
    $title = strip_tags($_POST['title']);
    $content = htmlspecialchars($_POST['content']);
    $enabled = isset($_POST['enabled']) ? 1 : 0;
    $id_category =  preg_match('/^[0-9]+$/', $_POST['category']?? '') ? $_POST['category'] : null;

//Check SQL constraints
    if (!getArticleByTitle($title)) {

        if (createArticle($title, $content, $enabled, $id_category)) {
            $_SESSION['messages']['success'] = 'You just created a new article';
            header('Location: /admin/articles/modify.php');
            exit(302);
        } else {
            $errorMessage = "This article already exists";

        }
    } else {
        $errorMessage = 'Article already exists!';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = "Please fill out the form correctly";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <title>Document</title>
</head>
<body>
<main>
    <?php require_once '/app/public/layout/_header.php' ?>
    <form action="/admin/articles/create.php" method="POST" class="container mt-4">
        <?php require_once '/app/public/layout/_messages.php'; ?>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger">
                <?= $errorMessage; ?>
            </div>
        <?php endif; ?>
        <label for="title">Entrez un titre</label>
        <input type="text" name="title" id="title" placeholder="Entrez un titre">

        <div class="form-category">
            <label for="category">Select category</label>
            <select name="category" id="category">
                <option value="" disabled selected>Select category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>">
                        <?= $category['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <label for="content">Description</label>
        <textarea name="content" id="content" cols="30" rows="10" placeholder="Article de blog"></textarea>

        <div class="form-check">
            <input type="checkbox" name="enabled" id="enabled">
            <label for="enabled">Enabled</label>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer l'article</button>
    </form>
</main>

</body>
</html>
