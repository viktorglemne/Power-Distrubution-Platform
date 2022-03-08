<?php
include_once '..\database\config.php';
$stmt3 = $pdo->query("SELECT * FROM `wind` ORDER BY id DESC LIMIT 10;");
$row3 = $stmt3->fetchAll();
$stmt4 = $pdo->query("SELECT SUM(consumption) FROM `prosumer`;");
$row4 = $stmt4->fetch();
$stmtprice = $pdo->query("SELECT * FROM `power` ORDER BY id DESC LIMIT 1;");
$price = $stmtprice->fetch();
$speedAvg = 0;

//echo "index 0 speed: ", $row3[0]['speed'],"<br>";

for($i=0;$i<10;$i++) {
    //echo $speedAvg,"<br>";
    $speedAvg = $speedAvg + $row3[$i]['speed'];
}

/* echo $row3['speed'],"<br>", $row4['SUM(consumption)']; */

$myArr = array($speedAvg / 10, $row4['SUM(consumption)'], $price['price']);

$myJSON = json_encode($myArr);


echo $myJSON;

?>