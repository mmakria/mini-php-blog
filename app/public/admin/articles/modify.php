<?php
session_start();
require_once '/app/requests/articles.php';
$articles = getArticlesWithCategory();
$_SESSION['csrf_token'] = bin2hex(random_bytes(72));
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <title>Update Blog</title>
</head>
<?php
require_once '/app/public/layout/_header.php';
?>

<body>
<main>
    <h1>Liste des articles</h1>
    <?php require_once '/app/public/layout/_messages.php' ?>
    <!--    message no article left-->
    <?php if (empty($articles)) : ?>
        <div class="message-info">There is no article present</div>
    <?php else: ?>
    <!--    blog container-->
    <section class="blog-container">
        <?php foreach ($articles as $article): ?>
            <article class="card-article">
                <div class="card-image"></div>
                <div class="post-content">
                    <h3 class="card-category"><?=$article['category_name'] ? $article['category_name'] : "No category added"; ?></h3>
                    <h2 class="card-title"><?= $article['title'] ?></h2>
                </div>
                <div class="post-meta">
                    <p class="post-meta-date"><?=   $article['created_at'] ?></p>
                    <?php if ($article['enabled'] === 1): ?>
                        <p class="post-enabled post-meta-enabled"> Enable</p>
                    <?php elseif ($article['enabled'] === 0): ?>
                        <p class="post-enabled post-meta-disabled"> Disable</p>
                    <?php endif; ?>
                </div>
                <div class="btn-group">
                    <a href="/admin/articles/update.php?title=<?= $article['title'] ?>"
                       class=" btn-secondary btn-article">Update</a>
                    <form action="/admin/articles/delete.php" method="post"
                          onsubmit=" return confirm('Are you sure you want to delete this article ?')">
                        <input type="hidden" name="title" value="<?= $article["title"] ?>">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <button type="submit" class=" btn-danger btn-article">Delete</button>
                    </form>
                </div>
            </article>
        <?php endforeach; ?>
        <?php endif; ?>

    </section>

</main>

<?php require_once '/app/public/layout/_footer.php'?>

</body>
</html>