<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';

$pdo;
$RATIO = $_POST["ratio"];
$USER = $_POST["USER"];
#echo "ratio is: ", $RATIO, " user is: ", $USER;

$stmt = $pdo->query("UPDATE `prosumer` SET `ratio`='$RATIO' WHERE username='$USER';");
$row = $stmt->fetch();
header("location: userpage.php"); 

?>
    
</body>
</html>