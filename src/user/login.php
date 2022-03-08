<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';
?>

<link rel="stylesheet" href="../ui/styles/form-style.css">
<div class="form">
    <form action="userpage.php" method="post" <?php if (isset($_SESSION['username'])) {
        echo 'style="display:none"';
    }?>>
        <h1>Sign In</h1>
        <br>
        <label>
            Username:
            <br>
            <input type="text" name="ANAMN" required>
        </label><br><br>
        <label>
            Password:
            <br>
            <input type="password" name="PASS" required>
        </label><br><br>
        <input type="submit" value="Log in" class="button-reg">
        <hr>
        <br>
    <button class="button-create" ><a  href="register_form.php">Create new Account</a></button>
    </form>
    
</body>

<!--    <php         
        echo $USER;
        if (!isset($USER)) {
            //if ($_SESSION["username"] == "") {
                $USER = $_POST["ANAMN"];
                $PASS = $_POST["PASS"];
                $stmt = $pdo->query("SELECT * FROM `prosumer` WHERE username='$USER' AND password = '$PASS';");
                $row = $stmt->fetch();
                if ($stmt->rowCount() < 1) {
                    $_SESSION['username'] = NULL;
                    throw new Exception('User not found');
                } else {
                    echo "You have successfully logged in as ", $row['username'];
                    $_SESSION["username"] = $USER; 
                    if ($row['admin'] == true) {
                        echo " and you are an admin!";
                        $_SESSION["admin"] = "true";
                    }
                }   
                header("location: userpage.php");
           //}
        }
       

    ?> -->
    <!-- if logged in, dont display this, needs sessions first
    
    <form action="login.php" method="post" class=posproducts
    <php if ($_SESSION["loggedIN"] == "true") {
        echo 'style="display:none"';
    } ?>> -->