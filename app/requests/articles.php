<?php

require_once '/app/config/mysql.php';




function getAllArticles() : array
{
    global $db;
    $query = /** @lang text */
        'SELECT * FROM articles';
    $sql = $db->query($query);
    return $sql->fetchAll();
}


function getArticleByTitle(string $title): array|bool
{

    global $db;
    $query = /** @lang text */
        "SELECT * FROM articles WHERE title = :title";
    $sql = $db->prepare($query);
    $sql->execute(['title' => $title]);

    return $sql->fetch();
}


/** Function to get article with ID
 * @param int $id
 * @return array|bool
 */
function getArticleById(int $id): array|bool
{
    global $db;
    $query = /** @lang text */
        'SELECT * FROM articles WHERE id = :id';
    $sql = $db->prepare($query);
    $sql->execute(['id' => $id]);
    return $sql->fetch();
}


function createArticle(string $title, string $content, int $enabled, ?int $id_category): bool|array
{
    global $db;
    try {
        $query = /** @lang text */
            "INSERT INTO articles (title, description, enabled, id_category) VALUES (:title, :content, :enabled, :id_category)";
        $sql = $db->prepare($query);
        $sql->execute(['title' => $title,
            'content' => $content,
            'enabled' => $enabled,
            'id_category' => $id_category]);
    } catch (PDOException $e) {
        return false;
    }
    return true;
}

function updateArticle(string $oldTitle, string $title, string $content, int $id_category): bool|array
{
    global $db;
    $query = /** @lang text */
        "UPDATE articles SET title = :title, description = :content, id_category = :id_category  WHERE title = :oldTitle";
    try {
        $sql = $db->prepare($query);
        $sql->execute(['title' => $title,
            'content' => $content,
            'oldTitle' => $oldTitle,
            'id_category' => $id_category]);

    } catch (PDOException $e) {
    var_dump($e->getMessage());
        return false;
    }
return true;
}

function deleteArticle(string $title): bool|array{
    global $db;

    $query = /** @lang text */
        "DELETE FROM articles WHERE title = :title";
    try {
        $sql= $db->prepare($query);
        $sql->execute(['title' => $title]);

    }catch (PDOException $e){
        return false;
    }
    return true;

}

function getArticlesWithCategory(): array{
    global $db;
    $query = /** @lang text */
        "SELECT
            a.*,
            c.name
        AS category_name
        FROM articles a
        LEFT JOIN categories c ON a.id_category = c.id
        ORDER BY a.created_at DESC";
    $sql = $db->query($query);
    return $sql->fetchAll();

}