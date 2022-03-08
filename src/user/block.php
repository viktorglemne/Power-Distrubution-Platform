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
$BLOCK = $_POST["block"];
$USER = $_POST["user"];

echo $USER, ' has been blocked';
//$TIMER = date("H-i-s") + $BLOCK;


$string = 'PT'.$BLOCK.'S';
$now = new DateTime();
$now->add(new DateInterval($string));
$now->format('H:i:s');    // MySQL datetime format
$TIMER = $now->getTimestamp();

if ($BLOCK < 10 || $BLOCK > 100) {
    echo "Valid block time is 10 - 100 seconds. Try again";
    
} else {
    $stmt = $pdo->query("UPDATE `prosumer` SET `blocked`='$TIMER' WHERE `username`='$USER';");
    $row = $stmt->fetch();
    //header("location: admin.php");
}

?>
    <a href="admin.php">
        <button>Return</button>
    </a>

