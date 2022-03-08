<?php

include_once 'config.php';
$pdo;
$stmt = $pdo->query("SELECT SUM(consumption) FROM `prosumer`;");
$row = $stmt->fetch();

$stmt2 = $pdo->query("SELECT SUM(speed) FROM `wind`;");
$row2 = $stmt2->fetch();

$price = array_sum($row) - 1.5*array_sum($row2);

$stmt = $pdo->query("INSERT INTO `power`(`price`) VALUES ('$price');");
$row = $stmt->fetch();


//echo $price;
/* echo array_sum($row);
echo "<br>";
echo array_sum($row2); */
//$price = $stmt; 







