<?php 
// tellS PHP which computer to use when connecting to a database
$host = 'localhost';
// tells which user that being used
$user = 'root';
// password for the database
$pass = '';
// tells which database to use
$db = 'data';
// character set, and in this case we are using utf8mb4
$chrs = 'utf8mb4';
// Adds additional options needed to access the database
$attr = "mysql:host=$host;dbname=$db;charset=$chrs";
$opts =
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
// <--- connect to database ---> 
// made for cheking errros
try {
    // creates a nwe object by calling a new instance of the PDO method.
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

$pdo->exec("CREATE TABLE IF NOT EXISTS user(
    username TEXT NOT NULL,
    password TEXT NOT NULL,
    admin BOOLEAN NOT NULL,
    consumption INT NOT NULL
    )");