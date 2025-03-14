<?php
session_start();
require_once "/app/requests/users.php";


// Vérification si le formulaire est soumis et que les champs obligatoires ne sont pas vides
if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    $firstName = strip_tags($_POST['first_name']);
    $lastName = strip_tags($_POST['last_name']);
    $email = strip_tags($_POST['email']);
    $password = $_POST['password'];

    // Vérification des contraintes SQL
    $userExist = findOneUserByEmail($email);
    if (!$userExist) {
        if (createUser($firstName, $lastName, $email, $password)) {
            $_SESSION['messages']['success'] = "Votre Compte a été créé";
            header('location: /login.php');
            exit(302);
        } else {
            $errorMessage = "Une erreur est survenue lors de la création de l'utilisateur";
            var_dump($errorMessage);
        }
    } else {
        $errorMessage = "This email is already registered";
        var_dump($errorMessage);
    }
}
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | My first app PHP</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>
<body>
<?php require_once '/app/public/layout/_header.php'; ?>
<main>
    <?php require_once '/app/public/layout/_messages.php';?>
    <p class="hero"></p>
    <section class="container mt-4">
        <h1 class="title text-center">Sign in</h1>
        <form action="/register.php" method="POST" class="mt-4">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger">
                    <?= $errorMessage; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="firstName">Firstname</label>
                <input type="text" name="first_name" id="first_name" required placeholder="John">
            </div>
            
            <div class="form-group">
                <label for="lastName">Lastname</label>
                <input type="text" name="last_name" id="last_name" required placeholder="Doe">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="jonh@exemple.com">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required placeholder="SECRET">
            </div>
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </section>
</main>
</body>


</html>