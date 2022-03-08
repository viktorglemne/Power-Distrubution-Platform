<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';

/**
 * Updates user credentials
 */
$pdo;
$USER = $_POST["USER"];
$PASS = $_POST["PASSWORD"];

$stmt = $pdo->query("UPDATE `prosumer` SET `password`='$PASS' WHERE username='$USER';");
$row = $stmt->fetch();
