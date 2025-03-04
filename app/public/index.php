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
    <form action="/contact.php" method="post">
        <label for="name"> Votre nom</label>
        <input type="text" id="name" name="name">
        <label for="email"> Votre email</label>
        <input type="email" name="email" id="email">
        <label for="message">Votre message</label>
        <textarea name="message" id="message" cols="30" rows="10"></textarea>
        <button type="submit">Envoyer</button>
    </form>
</main>


</body>
</html>