<?php

if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {
    $name = strip_tags($_POST['name']);
    $email = strip_tags($_POST['email']);
    $message = strip_tags($_POST['message']);
}else{
    header("location: /");
    exit(302);
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
    <title>Contact | My first app</title>
</head>
<body>
<?php require_once '/app/public/layout/_header.php'; ?>
<main>

    <h1>Your message:</h1>
    <p><?= $name; ?></p>
    <p><?= $email; ?></p>
    <p><?= $message; ?></p>



</main>

</body>
</html>
