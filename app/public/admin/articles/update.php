<?php
session_start();
require_once "/app/requests/articles.php";
require_once "/app/requests/categories.php";

$categories = getAllCategories();
$article = !empty($_GET['title']) ? getArticleByTitle($_GET['title']) : null;
$id_category =  preg_match('/^[0-9]+$/', $_POST['category']?? '') ? $_POST['category'] : null;

if (!$article) {
    $_SESSION['messages']['danger'] = 'Article not found';
    header('Location: /admin/articles/modify.php');
    exit(302);
}
if (!empty($_POST['title']) && !empty($_POST['content'])) {
    $newTitle = strip_tags($_POST['title']);
    $newContent = strip_tags($_POST['content']);
    if (updateArticle($article['title'], $newTitle, $newContent, $id_category)) {
        $_SESSION['messages']['success'] = "This article has been edited ";
        header("Location: /admin/articles/modify.php");
        exit(302);
    } else {
        $errorMessage = 'An error occured while editing this article';
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = 'Please fill all the fields';
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update the article | My first app PHP</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>
<body>
<?php require_once '/app/public/layout/_header.php'; ?>
<main>
    <p class="hero"></p>
    <section class="container mt-4">
        <h1 class="title text-center">Update article</h1>
        <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="container mt-4">
            <?php require_once '/app/public/layout/_messages.php'; ?>
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger">
                    <?= $errorMessage; ?>
                </div>
            <?php endif; ?>
            <label for="title">Entrez un titre</label>
            <input type="text" name="title" id="title" value="<?= strip_tags($article['title']) ?>">
            <div class="form-category">
                <label for="category">Select category</label>
                <select name="category" id="category">
                    <option value="" disabled selected>Select category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?=$category['id'] === $article['id_category'] ? 'selected' : ''; ?> >
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <label for="content">Description</label>
            <textarea name="content" id="content" cols="30"
                      rows="10"><?= strip_tags($article['description']) ?></textarea>
            <button type="submit" class="btn btn-primary">Modifier l'article</button>
        </form>


    </section>
</main>
</body>


</html>