<?php
session_start();
require_once '/app/requests/articles.php';
$articles = getAllArticles();
$article = getArticleById($_GET['id']);

// Math for having random unique articles
$randPostOne = rand(0, count($articles) - 1);
$randPostTwo = rand(0, count($articles) - 1);
while ($randPostTwo === $randPostOne) {
    $randPostTwo = rand(0, count($articles) - 1);
}
$randPostThree = rand(0, count($articles) - 1);
while ($randPostThree === $randPostTwo || $randPostThree === $randPostOne) {
    $randPostThree = rand(1, count($articles) - 1);
}
$randPast = [$randPostOne, $randPostTwo, $randPostThree];


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
<?php require_once '/app/public/layout/_header.php' ?>
<main>
    <h1></h1>
    <article class="post-container">
        <h2>&nbsp;<?= $article['title'] ?></h2><br>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;<?= $article['description'] ?></p><br>
        <div class="meta-article">
            <p class="meta-date-post">Blog added the <?= $article['created_at'] ?></p>
            <p class="meta-date-post">By Makria Mohamed</p>
        </div>
    </article>

    <h2>Discover other posts</h2>
    <section class="blog-container">

        <?php foreach ($randPast as $index): ?>
            <article class="card-article">
                <div class="card-image"></div>
                <div class="post-content">
                    <h3 class="card-category">Categories</h3>
                    <h2 class="card-title"><?= $articles[$index]['title'] ?></h2>
                </div>
                <div></div>
                <div class="post-meta">
                    <a class="cta-card" href="/articles/posts.php?id=<?= $articles[$index]['id'] ?>">En savoir
                        plus</a>
                    <p class="post-meta-date"><?= $articles[$index]['created_at'] ?></p>
                    <?php if ($articles[$index]['enabled'] === 1): ?>
                        <p class="post-enabled post-meta-enabled"> Enable</p>
                    <?php elseif ($articles[$index]['enabled'] === 0): ?>
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
