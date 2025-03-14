<?php

session_start();
require_once '/app/utils/utils.php';
require_once '/app/requests/users.php';
checkAdmin();

$user = !empty($_GET['id']) && ctype_digit($_GET['id']) ? findOneUserById($_GET['id']) : null;
//var_dump(findOneUserById($_GET['id']));
//$user = preg_match('/^[0-9]+/', $_GET['id'] ?? '') ? findOneUserById($_GET['id']) : null;


if (!$user) {
    $_SESSION['messages']['danger'] = 'User not found';
    header('Location: /admin/users');
    exit(302);
}

// Verification de la soumission du formulaire et que les champs obligatoires ne sont pas vides
if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])
) {
    // Nettoyage de données
    $firstName = strip_tags($_POST['first_name']);
    $lastName = strip_tags($_POST['last_name']);
    $email = strip_tags($_POST['email']) ?? null;
    $password = $_POST['password'];

    //Vérifications des contraintes SQL
    $changeEmail = $email !== $user['email'];

    if (!$changeEmail || !findOneUserByEmail($email)) {
        // On peut modifier l'utilisateur
        if (updateUser($user['id'], $firstName, $lastName, $email, $password)){
            $_SESSION['messages']['success'] = 'Changes saved';
            header('Location: /admin/users');
            exit(302);
        }else{
            $errorMessage = 'Erreur lors de la modification';
        }

    } else {
        $errorMessage = 'Cet email existe déjà';
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un user | My first app PHP</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
<?php require_once '/app/public/Layout/_header.php'; ?>
<main>
    <?php require_once '/app/public/Layout/_messages.php'; ?>
    <section class="container mt-4">
        <h1 class="text-center">Modification d'un user</h1>
        <form action="<?= $_SERVER['REQUEST_URI']; ?>" method="POST" class="mt-4">
            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger">
                    <?= $errorMessage; ?>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label for="firstName"> Prénom</label>
                <input type="text" name="first_name" id="first_name" required placeholder="John"
                       value="<?= $user["first_name"] ?>">
            </div>
            <div class="form-group">
                <label for="lastName">Nom</label>
                <input type="text" name="last_name" id="last_name" required placeholder="Doe"
                       value="<?= $user["last_name"] ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="jonh@exemple.com"
                       value="<?= $user["email"] ?>">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" placeholder="SECRET">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>

    </section>
</main>
</body>

</html>