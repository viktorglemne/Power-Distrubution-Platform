<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once '..\database\config.php';

$WIND = $_GET["wind"];
$user = $_GET["username"];
$pass = $_GET["password"];

$pdo;
$stmt = $pdo->query("SELECT password FROM `prosumer` WHERE username=$user;");
$row = $stmt->fetchAll();

if(openssl_decrypt($pass,'aes-128-cbc',$pass) == $row['password']) {
    $stmt = $pdo->query("SELECT * FROM `prosumer`;");
    $row = $stmt->fetchAll();

    $stmt4 = $pdo->query("SELECT * FROM `power` ORDER BY id DESC LIMIT 1;");
    $row4 = $stmt4->fetch();

    $stmtWind = $pdo->query("SELECT * FROM `kraftverk` WHERE `type`='vind';");
    $rowWind = $stmtWind->fetchAll();

    $market = $row4['power'];
    $total = 0;
    $totalCons = 0;
    $stmtAuth = $pdo->query("SELECT * FROM `prosumer` WHERE username='$user';");
    $rowAuth = $stmtAuth->fetch();
    $passAuth = $rowAuth['password'];
    $decrypted = openssl_decrypt($pass,'aes-128-cbc',$passAuth);

    echo $passAuth;

    if($passAuth == $decrypted && $passAuth != ''){
        echo "Successful auth!";
        $stmtWind = $pdo->query("INSERT INTO `wind`(`speed`) VALUES ('$WIND');");
        $rowWind = $stmt->fetch();

        foreach($rowWind as $power) {
        
            $id = $power['idkraftverk'];
            $prod = $power['production'];
            #echo "current id = ", $id," current prod = ",$prod, "<br>";
            $stmtProd = $pdo->query("UPDATE `kraftverk` SET `production`=$WIND*1000 WHERE `idkraftverk`=$id;");
            $rowProd = $stmtProd->fetch();
        }
        
        foreach ($row as $USER) {
            /**
             * Update buffer for user
             */
            $USERNAME = $USER['username'];
            $USERID = $USER["iduser"];
            $stmt = $pdo->query("SELECT SUM(production) FROM `kraftverk` WHERE user_iduser='$USERID';");
            $row = $stmt->fetch();
        
            $stmt2 = $pdo->query("SELECT * FROM `prosumer` WHERE username='$USERNAME';");
            $row2 = $stmt2->fetch();
        
            $production = array_sum($row) - $row2['consumption'];
        
            //check if coal power plant is on or off
            $stmt3 = $pdo->query("SELECT * FROM `kraftverk` WHERE type='coal';");
            $row3 = $stmt3->fetch();
            if (!$row3['enabled']) {
                $production = $production - $row['production'];
            }
        
            $total = $total + $production;
            $totalCons = $totalCons + $row2['consumption'];
        
            if($production<0) {
                //Negative production
                $ratio = $row2['ratioToBuy'];
                $takenFromMarket = $production*$ratio;
                $takenFromBuffer = $production * (1 - $ratio);
        
                $buffer = $row2['buffer']+$takenFromBuffer;
                $stmtBuffer = $pdo->query("UPDATE `prosumer` SET `buffer`='$buffer' WHERE username='$USERNAME';");
                $rowBuffer = $stmtBuffer->fetch();
        
                $market =$market + $takenFromMarket;
                
        
            } else {
        
                $prod_minus_cons = array_sum($row) - $row2['consumption'];
                $buffer = $row2['buffer'] + $prod_minus_cons * $row2['ratio'];
        
                $stmt3 = $pdo->query("UPDATE `prosumer` SET `buffer`='$buffer' WHERE username='$USERNAME';");
                $row3 = $stmt3->fetch();
        
                $market = $market + $prod_minus_cons * (1 - $row2['ratio']);
            }
        }
        $string = "1." . 1000000;
        $price = (float) $string;
        
        $stmt2 = $pdo->query("SELECT * FROM `wind` ORDER BY id DESC LIMIT 10;");
        $row2 = $stmt2->fetch();
        $wind= $row2['speed'];
        
        switch ($wind) {
            case ($wind<1):
                $price = $price*1.2;
                break;
            case ($wind<2):
                $price = $price*1.1;
                break;
            case ($wind>=2 && $wind<3):
                break;
            case ($wind>=3):
                $price = $price*0.9;
                break;
        }
        switch ($totalCons) {
            case ($totalCons<=0):
                $price = $price*0.9;
                break;
            case ($totalCons>5000 && $totalCons<10000):
                break;
            case ($totalCons>10000):
                $price = $price*1.1;
                break;
        }
        echo "market:",$market,"<br>production:",$production,"<br>price:",$price,"<br>total:",$total;
        
        if ($price < 0.5) {
            $price = 0.5;
        }
        
        $stmtMarket = $pdo->query("INSERT INTO `power`(`power`,`price`) VALUES ('$market','$price');");
        $rowMarket = $stmtMarket->fetch();
        
    } else {
        echo "Failure to authenticate";
    }
    } else {
        echo "Failure to authenticate";
    }
?>