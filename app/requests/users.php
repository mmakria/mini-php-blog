<?php
require_once '/app/config/mysql.php';


/**
 *Récupère tous les utilisateurs en BDD
 * @return array
 */

function findAllUsers(): array
{
    global $db;
    $query = "SELECT * FROM users";
    $sql = $db->query($query);
    return $sql->fetchAll();
}

/**
 *Récupère un utilisateur en BDD en filtrant par son email
 * @param string $email
 * @return bool|array
 */

function findOneUserByEmail(string $email): bool|array
{
    global $db;
//    $sql = $db->query("SELECT * FROM users WHERE email = $email"); // A ne surtout pas faire
    $sql = $db->prepare("SELECT * FROM users WHERE email = :email");
    $sql->execute(['email' => $email]);
    return $sql->fetch();
}

/**
 * @param string $firstName
 * @param string $lastName
 * @param string $email
 * @param string $password
 * @return bool Retourne true si l'utilisateur a été crée, sinon false
 */
function createUser(string $firstName, string $lastName, string $email, string $password): bool
{
    try {
        global $db;
        $query = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $sql = $db->prepare($query);
        $sql->execute(['first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_ARGON2I)]);
    } catch (PDOException $e) {
        return false;
    }
return true;
}









