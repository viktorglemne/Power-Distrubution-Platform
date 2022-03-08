<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';
?>

<link rel="stylesheet" href="../ui/styles/form-style.css">
<div class="form">
    <form action="register.php" method="post" <?php if (isset($_SESSION["username"])) {
        echo 'style="display:none"';
        }?>>                                        
        <h1>Register</h1>
        <br>
        <label>
            Username:
            <br>
            <input type="text" name="USER">
        </label><br><br>
        <label>
            Password:
            <br>
            <input type="text" name="PASS">
            </label><br><br>
            <input type="submit" value="Register" class="button-reg">
    </form>
</body>