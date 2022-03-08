<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production of electricity</title>
    <link rel="stylesheet" href="../ui/styles/navBar.css">
    <script src="app.js" ></script>
</head>
<nav>
    <div class="first-StyleContainer">
        <!--<img class="logopic" src='<?php echo './images/complogo.png'?>;'>   -->
         <a class="logo" href="..\index.php">Logo</a>
    </div>
    <div class="second-StyleContainer">
        <!--         <a href="#">Consumption</a>
        <a href="#">Price</a>
        <a href=".\price.php">Price</a> -->
        <?php if (isset($_SESSION['username'])) { ?>
            <a href="..\user\userpage.php">Profile</a>
            <?php }
        if (isset($_SESSION['admin'])) {
            if ($_SESSION['admin']) {
            ?>
                <a href="..\admin\admin.php">Admin</a>
        <?php }
        } ?>
    </div>

    <div class="third-StyleContainer">
        <button class="profile-dropdown-button">
            <?php
            if (isset($_SESSION['username'])) {
                echo $_SESSION['username'];
            } else {
            ?>
                Login options
            <?php } ?>
        </button>
        <div class="dropdown-links">
            <?php
            if (!isset($_SESSION['username'])) {
            ?>
                <a href="..\user\login.php">Login</a>

            <?php
            } else {
            ?>
                <a href="..\user\settings.php">Settings</a>
                <a href="..\user\logout.php">Logout</a>
            <?php } ?>
        </div>

    </div>
    <?php
    if (isset($_SESSION['username'])) {
    ?>
        <img class="navbarpic" src='<?php echo '../user/uploads/', $_SESSION['imagePath'] ?>'>;
    <?php
    } ?>
</nav>

<body>