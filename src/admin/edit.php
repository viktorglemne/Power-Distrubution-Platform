<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';

$id = $_GET['id'];

$stmt = $pdo->query("SELECT * FROM `prosumer` WHERE iduser='$id';");
$data = $stmt->fetch();


if (isset($_POST['update'])) {
    $username = $_POST['username'];
    if ($_SESSION["username"] == $data['username']) {
        $_SESSION["username"] = $username;
    }

   
    try {
        $pass = $_POST['password'];
        if ($pass != '') {
            $stmt = $pdo->query("UPDATE `prosumer` SET `username`='$username',`password`='$pass' WHERE iduser=$id;");
        } else {
            $stmt = $pdo->query("UPDATE `prosumer` SET `username`='$username' WHERE iduser=$id;");
        }
        
       
        header("location: admin.php");
    } catch (\Throwable $th) {
        $stmt = $pdo->query("UPDATE `prosumer` SET `username`='$username' WHERE iduser=$id;");
    }
}
?>
<link rel="stylesheet" href="../ui/styles/form-style.css">
<div class="form">
    <h2>Update Data for <?php echo $data['username'] ?></h2>
    <form method="POST">
        <input type="text" name="username" placeholder="New Username" Required>
        <br><br>
        <input type="text" name="password" placeholder="New password (optional)">
        <br><br>
        <input class="button-reg" type="submit" name="update" value="Update">
    </form>
</div>


</body>

</html>