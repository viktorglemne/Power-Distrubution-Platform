<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';

/**
 * Updates user credentials
 */
$POWER = $_POST["POWER"];

$stmt = $pdo->query("UPDATE `kraftverk` SET `production`='$POWER' WHERE type='coal';");
$row = $stmt->fetch();

$stmt = $pdo->query("UPDATE `kraftverk` SET `enabled`='1' WHERE type='coal';");
$row = $stmt->fetch();  

$_SESSION['coalSaved'] = true;
header("location: ..\user\settings.php");    