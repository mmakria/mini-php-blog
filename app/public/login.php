<?php
session_start(); // toujours en haut

require_once '/app/requests/users.php';
//var_dump(findAllUsers());
//var_dump(password_hash("123456", PASSWORD_ARGON2I));

// Vérifier si le formulaire a été soumis et que les données ne sont pas vides
if (!empty($_POST['email']) && !empty($_POST['password'])) {

    // Récupère les informations envoyées par le formulaire
    // Nettoyer les données
    $email = strip_tags($_POST['email']);
    $password = $_POST['password'];
    //récupérer l'utilisateur en BDD
    $user = findOneUserByEmail($email);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
            'roles' => json_decode($user['roles'] ?? ''),
        ];
        header('Location: /');
        exit(302);
    } else {
        $errorMessage = "Wrong email or password"; //pour éviter les bruts forces ne pas donner d'infos sur la nature de l'erreur
    }
};

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/styles/main.css">
    <title>Se connecter | My first app PHP</title>
</head>
<body>
<?php
require_once '/app/public/layout/_header.php';
?>
<main>
    <section class="container mt-4">
        <h1 class="title text-center">Se connecter</h1>
        <form action="/login.php" method="post" class="card mt-4 mx-auto w-50">

            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger">
                    <?= $errorMessage; ?>
                </div>
            <?php endif; ?>


            <div class="form-group">
                <label for="email">email</label>
                <input type="email" name="email" id="email" required placeholder="momo@exmaple.com">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required placeholder="SECRET">
            </div>
            <button type="submit" class="btn btn-primary">
                Se connecter
            </button>
        </form>
    </section>
</main>


</body>
</html>