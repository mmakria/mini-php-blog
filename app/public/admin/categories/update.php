<?php
session_start();
require_once "/app/utils/utils.php";
checkAdmin();

if (empty($_GET['id'])) {
    header("Location: /admin/categories/dashboard.php");
    $_SESSION['messages']['danger'] = "Category not found";
    exit(302);
}

require_once "/app/requests/categories.php";
$id = $_GET['id'];
$category = getCategoryById($id);
if (!empty(trim($_POST['name']))) {
    $name = strip_tags($_POST['name']);
    $enabled = !empty($_POST['enabled']) ? 1 : 0;
    if (updateCategory($id, $name, $enabled)) {
        $_SESSION['messages']['success'] = "Category updated successfully";
        header("Location: /admin/categories/dashboard.php");
        exit(302);
    } else {
        $_SESSION['messages']['danger'] = "Category not updated";
    }
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    <title>Update categories</title>
</head>

<body>
<?php require_once '/app/public/layout/_header.php'; ?>

<main>
    <?php
    require_once "/app/public/layout/_messages.php";
    ?>
    <section class="container mt-4">
        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Enter a name" value="<?= $category['name'] ?>">
            <div class="form-check">
                <label for="enabled">Enabled</label>
                <input type="checkbox" name="enabled" id="enabled" <?= $category['enabled'] == 1 ? 'checked' : '' ?>>
            </div>
            <button type="submit" class="btn btn-secondary">Update category</button>
        </form>
    </section>
</main>


</body>
</html>
