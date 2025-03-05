<?php

try {
    $dsn = 'mysql:host=dataBase;dbname=blog_php;charset=utf8mb4'; // database car image docker sinon adresse IP
    $db = new PDO($dsn,
        'root',
        null,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
//    var_dump($db->query('SELECT * FROM users')->fetchAll());
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());

}



