<?php
session_start();
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
<?php
require_once '/app/public/layout/_header.php';
?>
<main>
    <?php require_once '/app/public/layout/_messages.php'; ?>
    <form action="/contact.php" method="post" class="container mt-4">
        <label for="name"> Your name</label>
        <input type="text" id="name" name="name">
        <label for="email"> Your email</label>
        <input type="email" name="email" id="email">
        <label for="message">Your message</label>
        <textarea name="message" id="message" cols="30" rows="10"></textarea>
        <button class="btn btn-primary" type="submit">Send message</button>
    </form>
</main>

<?php require_once '/app/public/layout/_footer.php'?>

</body>
</html>