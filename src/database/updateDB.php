<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';

$pdo;
$ELEC = $_POST["ELEC"];
$SPEED = $_POST["SPEED"];
$RATIO = $_POST["RATIO"];
$USER = $_POST["USER"];

echo $ELEC;
echo $SPEED;
echo $RATIO;

if(!empty($ELEC)) {
    $stmt = $pdo->query("UPDATE `prosumer` SET `consumption`='$ELEC' WHERE username='$USER';");
    $row = $stmt->fetch();
    $_SESSION['settings'] = true;
}

if (!empty($RATIO)) {
    $stmt = $pdo->query("UPDATE `prosumer` SET `ratio`='$RATIO' WHERE username='$USER';");
    $row = $stmt->fetch();
    $_SESSION['settings'] = true;
}

if (!empty($SPEED)) {
    $stmt = $pdo->query("INSERT INTO `wind`(`speed`) VALUES ('$SPEED');");
    $row = $stmt->fetch();
    $_SESSION['settings'] = true;
}

header("location: ../user/settings.php");

//echo $row;

?>
    
</body>
</html>