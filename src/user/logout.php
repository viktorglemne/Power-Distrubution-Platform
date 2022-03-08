<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';
$USER = $_SESSION['username'];
$stmt = $pdo->query("UPDATE `prosumer` SET `loggedIn`='0' WHERE `username`='$USER';");
$row = $stmt->fetch();


unset($_SESSION['username']);
unset($_SESSION['admin']);
$_SESSION['logout'] = "true";

header("location: ..\index.php");