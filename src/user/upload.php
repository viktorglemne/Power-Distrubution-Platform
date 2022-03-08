<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once '../database/config.php';
$target_dir = "uploads/";
$tmp_name = $_FILES["fileToUpload"]["tmp_name"];
// basename() may prevent filesystem traversal attacks;
// further validation/sanitation of the filename may be appropriate
$name = basename($_FILES["fileToUpload"]["name"]);
move_uploaded_file($tmp_name, "$target_dir/$name");
$username = $_SESSION['username'];


$pdo;

$stmt4 = $pdo->query("UPDATE `prosumer` SET `imagePath`='$name' WHERE `username`='$username';");
$row4 = $stmt4->fetch();

$_SESSION['imagePath'] = $name;

header("location: userpage.php");