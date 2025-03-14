<?php
session_start();
require_once "/app/requests/users.php";
require_once "/app/utils/utils.php";

if (empty($_SESSION['user'])) {
    $_SESSION['messages']['danger'] = "You need to be logged in to see this page!";
    header('Location: /login.php');
    exit(302);
}

$user = findOneUserById($_SESSION['user']['id']);
var_dump($user);

if (!$user) {
    $_SESSION['messages']['danger'] = 'User not found';
    header('Location: /login.php');
    exit(302);
}

if (!empty($_POST['first-name']) && !empty($_POST['last-name']) && !empty($_POST['email'])) {
    var_dump($_POST);
    $firstName = strip_tags($_POST['first-name']);
    $lastName = strip_tags($_POST['last-name']);
    $email = strip_tags($_POST['email']);
    $password = $_POST['password'];

    if (updateUser($user['id'], $firstName, $lastName, $email, $password)) {
        $_SESSION['messages']['success'] = 'Changes saved';
        var_dump($password);
    } else {
        $_SESSION['messages']['danger'] = 'Changes not saved';
    }


} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['messages']['danger'] = 'Please fill all the required fields';
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="assets/styles/main.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My profile</title>
</head>
<body>
<?php require_once "/app/public/layout/_header.php"; ?>

<main>
    <?php
    require_once "/app/public/layout/_messages.php";
    ?>
    <section class="container mt-4">
        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
            <label for="first-name">First name</label>
            <input type="text" value="<?= $user['first_name'] ?>" placeholder="Enter your first name" id="first-name"
                   name="first-name">

            <label for="last-name">Last name</label>
            <input type="text" value="<?= $user['last_name'] ?>" placeholder="Enter your last name" id="last-name"
                   name="last-name">

            <label for="email">Email</label>
            <input type="email" value="<?= $user['email'] ?>" placeholder="Enter a email" id="email" name="email">

            <label for="password">Password</label>
            <input type="password" placeholder="Change your password" id="password" name="password">

            <button type="submit" class="btn btn-primary">Update your profile</button>
        </form>
    </section>

</main>

</body>
</html>
