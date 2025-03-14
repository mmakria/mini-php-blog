<?php
require_once '/app/config/mysql.php';


/**
 * function that select categories from an ID
 * @param int $id
 * @return array
 */
function getCategoryById(int $id): array|bool
{
    global $db;
    $query = /** @lang text */
        'SELECT * FROM categories WHERE id = :id';
    $sql = $db->prepare($query);
    $sql->execute(['id' => $id]);
    return $sql->fetch();

}


/**
 * Function to get category form a name
 * @param string $name
 * @return array|bool
 */
function getCategoryByName(string $name): array|bool
{
    global $db;
    $query = /** @lang text */
        'SELECT * FROM categories WHERE name = :name';
    $sql = $db->prepare($query);
    $sql->execute(['name' => $name]);
    return $sql->fetch();
}


function createCategory(string $name, int $enabled): bool
{
    global $db;
    $query = /** @lang text */
        'INSERT INTO categories (name, enabled) VALUES (:name, :enabled)';

    try {
        $sql = $db->prepare($query);
        $sql->execute(['name' => $name, 'enabled' => $enabled]);
    } catch (PDOException $e) {
        var_dump($e->getMessage());
    }
    return true;
}

/**
 * function to get all categories
 * @return array|string
 */
function getAllCategories(): array|string
{
    global $db;
    $query = /** @lang text */
        "SELECT * FROM categories ORDER BY name";
    $sql = $db->prepare($query);
    $sql->execute();
    return $sql->fetchAll();
}


/**
 * Function that update a category
 * @param int $id
 * @param string $name
 * @param int $enabled
 * @return bool
 */
function updateCategory(int $id, string $name, int $enabled): bool
{
    global $db;
    $query = 'UPDATE categories SET name = :name, enabled = :enabled WHERE id = :id';
    try {
        $sql = $db->prepare($query);
        $sql->execute(['id' => $id, 'name' => $name, 'enabled' => $enabled]);
    } catch (PDOException $e) {
        return false;
    }
    return true;

}

;
function deleteCategory(int $id): bool
{
    global $db;
    $query = 'DELETE FROM categories WHERE id = :id';
    try {
        $sql = $db->prepare($query);
        $sql->execute(['id' => $id]);
    } catch (PDOException $e) {
        return false;
    }
    return true;
}
