<?php session_start();


// Utilisation de la session
// Vérifier si l'utilisateur n'est pas pas Admin on redirige


if (empty($_SESSION['user']) || !in_array('ROLE_ADMIN', $_SESSION['user']['roles'])) {
    // On définit un message d'erreur
    $_SESSION['messages']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
    header('location: /login.php');
    exit(302);
}
?>
<?php require_once '/app/requests/users.php';

$users = findAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration des users | My first app PHP</title>
    <link rel="stylesheet" href="/assets/styles/main.css">
</head>

<body>
<?php require_once '/app/public/Layout/_header.php'; ?>
<main>
    <?php require_once '/app/public/Layout/_messages.php'; ?>
    <section class="container mt-4">
        <h1 class="text-center">Administration des users</h1>
        <table class="card">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user) : ?>
                <tr>

                    <td><?= $user["id"] ?></td>
                    <td><?= $user["first_name"] . " " . $user["last_name"] ?></td>
                    <td><?= $user["email"] ?></td>
                    <td><?= $user["roles"] ?></td>
                    <td class="table-btn">
                        <a href="/admin/users/update.php?id=<?= $user["id"] ?>" class="btn  btn-secondary"> Modifier</a>

                        <form action="/admin/users/delete.php" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce user ?')">
                            <input type="hidden" name="id" value="<?= $user["id"] ?>">
                            <button type="submit" class=" btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
</body>

</html>