<?php
session_start();
require_once '/app/utils/utils.php';
checkAdmin();
require_once '/app/requests/categories.php';
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

//******************************CREATION CATEGORY****************************//
if (!empty($_POST['name'])) {
    $name = strip_tags($_POST['name']);
    $enabled = isset($_POST['enabled']) ? 1 : 0;
    var_dump($enabled);

    // Vérification unique SQL
    if (getCategoryByName($name) === false) {
        // Verification INSERT INTO SQL
        if (createCategory($name, $enabled)) {
            var_dump($enabled);
            $_SESSION['messages']['success'] = "{$name} category has been created";
        } else {
            $_SESSION['messages']['danger'] = "Something went wrong";
        }
    } else {
        $_SESSION['messages']['danger'] = "Category with name {$name} already exists";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['messages']['danger'] = "Please fill all the fields";
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
    <title>Manage categories</title>
</head>
<body>
<?php require_once '/app/public/layout/_header.php' ?>
<main>
    <?php
    require '/app/public/layout/_messages.php';
    ?>
    <section class="mt-4 container ">
        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST" class="form-group">
            <div>
                <label for="name">Create category</label>
                <input type="text" placeholder="Cuisine, IT..." id="name" name="name">
            </div>
            <button type="submit" class="btn btn-secondary">Create categories</button>
            <div class="form-check">
                <label for="enabled">Enabled</label>
                <input type="checkbox" name="enabled" id="enabled">
            </div>
        </form>
    </section>
    <section>
        <!-- *****************************DISPLAY CATEGORY***************************-->
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>ENABLED</th>
                <th>UPDATE</th>
            </tr>
            </thead>
            <?php foreach (getAllCategories() as $category):?>
                <tr>
                    <td><?= $category['id'] ?></td>
                    <td><?= $category['name'] ?></td>
                    <td><?= $category['enabled'] ? 'YES' : 'NO' ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/categories/update.php?id=<?= $category['id'] ?>" class="btn btn-secondary">Update</a>
                            <form action="/admin/categories/delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete?') ">
                                <input type="hidden" value="<?= $category['id'] ?>" name="id">
                                <input type="hidden" value="<?= $_SESSION['csrf_token'] ?>" name="csrf_token">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
</body>
</html>
