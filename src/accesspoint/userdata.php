<?php

if (!isset($_SESSION)) {
    session_start();
}
include_once '..\database\config.php';

$user = $_GET["user"];
$pass = $_GET["pass"];
if(!str_ends_with($pass,'=')) {
    $pass.'==';
}



$stmtAuth = $pdo->query("SELECT * FROM `prosumer` WHERE username='$user';");
$rowAuth = $stmtAuth->fetch();
$passAuth = $rowAuth['password'];
$decrypted = openssl_decrypt($pass,'aes-128-cbc',$passAuth);
//echo openssl_encrypt('12','aes-128-cbc','12');

if($passAuth == $decrypted && $passAuth != ''){
    $myArr = array($rowAuth['username'],$rowAuth['consumption'],$rowAuth['ratio'],$rowAuth['buffer'],$rowAuth['ratioToBuy'],$rowAuth['login_timestamp']);
    $myJSON = json_encode($myArr);
    echo $myJSON;
}


?>  