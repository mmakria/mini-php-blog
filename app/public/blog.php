<?php
session_start();
require_once '/app/requests/articles.php';
$articles = getArticlesWithCategory();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/styles/main.css">

    <title>Blog</title>
</head>
<?php
require_once '/app/public/layout/_header.php';
?>
<body>
<main>
    <h1>List articles</h1>
    <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="post">
        <label for="filter">Filter by </label>
        <input type="submit" name="filter" value="filter" class="filter">
    </form>

    <section class="blog-container">
        <?php foreach ($articles as $article): ?>

            <article class="card-article">
                <div class="card-image"></div>
                <div class="post-content">
                    <h3 class="card-category">Categories <?=$article['category_name'] ?></h3>
                    <h2 class="card-title"><?= $article['title'] ?></h2>

                </div>
                <div></div>
                <div class="post-meta">
                    <a class="cta-card" href="/articles/posts.php?id=<?= $article['id'] ?>">En savoir plus</a>
                    <p class="post-meta-date"><?= $article['created_at'] ?></p>
                    <?php if ($article['enabled'] === 1): ?>
                        <p class="post-enabled post-meta-enabled"> Enable</p>
                    <?php elseif ($article['enabled'] === 0): ?>
                        <p class="post-enabled post-meta-disabled"> Disable</p>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    </section>
</main>
<?php require_once '/app/public/layout/_footer.php'?>
</body>
</html>

