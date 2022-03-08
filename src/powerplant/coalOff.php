<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';

/**
 * Updates user credentials
 */
$stmt = $pdo->query("SELECT * from `kraftverk` WHERE type='coal';");
$row = $stmt->fetch();
$onOff = $row['enabled'];
if ($onOff <= 0) {
    $stmt = $pdo->query("UPDATE `kraftverk` SET `enabled`='1' WHERE type='coal';");
    $row = $stmt->fetch();
} else {
    $stmt = $pdo->query("UPDATE `kraftverk` SET `enabled`='0' WHERE type='coal';");
    $row = $stmt->fetch();
}

// $stmt = $pdo->query("UPDATE `kraftverk` SET `enabled`='$onOff' WHERE type='coal';");
// $row = $stmt->fetch();

//$_SESSION['coalSaved'] = true;
header("location: ../user/settings.php");
