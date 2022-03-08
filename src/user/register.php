
<html>
<body>

<form action="index.php" method="post">
<input type="submit" value="Back to home">
</form>

<?php
include_once 'config.php';
$pdo;
$USER = $_POST["USER"];
$PASS = $_POST["PASS"];

$stmt = $pdo->query("SELECT * FROM prosumer WHERE username = '$USER';");

if ($stmt->rowCount() > 0) {
    echo "User already exists";
}
else{
    $sql = "INSERT INTO `prosumer` (`iduser`, `username`, `password`, `admin`, `consumption`, `ratio`, `buffer`, `ratioToBuy`, `imagePath`) VALUES (NULL, '$USER','$PASS', NULL, NULL, NULL, NULL, NULL, NULL);";
    $result = $pdo->query($sql);
    echo "Registration complete";
}
?>

</body>
</html>
