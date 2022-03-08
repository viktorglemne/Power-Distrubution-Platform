<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';
$pdo;
$USER = $_SESSION["username"];
$stmt = $pdo->query("SELECT * FROM `prosumer` WHERE username='$USER';");
$row = $stmt->fetch();
$stmt2 = $pdo->query("SELECT * FROM `wind` ORDER BY id DESC LIMIT 1;");
$row2 = $stmt2->fetch();
$speed = $row2['speed'];
?>

<link rel="stylesheet" href="../ui/styles/form-style.css">

<div class="form">
    <h1>Settings</h1>
    <div class="container">
        <img src="<?php echo "uploads/", $_SESSION['imagePath']?>">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <br>
            <label for="fileToUpload" id="button-upload" class="button-reg">
                Upload Image
            </label>
            <input type="file" name="fileToUpload" id="fileToUpload" onchange="this.form.submit()">
            <br><br><br>
        </form>
    </div>
    <form action="../database/updateDB.php" method="post">
        <!-- Speed <input type="text" placeholder='<?php echo $speed ?>' name="SPEED">
        <br><br> -->
        Set consumption <input type="text" placeholder='<?php echo $row['consumption'] ?>' name="ELEC">
        <br><br>
        Set ratio sent to buffer<input type="text" placeholder='<?php echo $row['ratio'] ?>' name="RATIO">
        <input type="hidden" name='USER' value='<?php echo $_SESSION["username"]; ?>'>
        <br><br>
        <input onclick="getElementById('msg').innerHTML='Saved!'" class="button-reg" type="submit" value="Save settings" name="submit">
        <h1 id="msg"></h1>
    </form>
</div>

<?php
if (isset($_SESSION['admin'])) {
    if ($_SESSION['admin']) {
    ?>
    <div class="form">
    
    <?php 
    $stmtCoal = $pdo->query("SELECT * FROM `kraftverk` WHERE type='coal';");
    $rowCoal = $stmtCoal->fetch();

    echo "Power plant status";
    if ($rowCoal['enabled'] != 0) {
        ?>
            <img src="../ui/images/online2.png" alt="" width="25" height="25" class="center"> <br>
            <input class="button-reg" type="submit" onClick="document.location.href='../powerplant/coalOff.php'" value="Turn off" name="submit">
        <?php
    } else {
        ?>
            <img src="../ui/images/offline.png" alt="" width="25" height="25" class="center"> <br>
            <input class="button-reg" type="submit" onClick="document.location.href='../powerplant/coalOff.php'" value="Turn on" name="submit">
        <?php
    }
    ?>
    <br>
    <form action="../powerplant/updateCoal.php" method="post">
    
    

        Set coal plant production <input <?php if (!$_SESSION['coalSaved']) {
                                                echo "autofocus";
                                            } ?> type="text" placeholder='
    <?php
    echo $rowCoal['production'];
    ?>' name="POWER" onfocus="this.value = this.value;inputChange(<?php echo $_SESSION['coalSaved'] ?>);">
        <?php
        if (!$_SESSION['coalSaved']) {
        ?>
            <br><br>
            <input class="button-reg" type="submit" value="Save setting" name="submit">
            <input type="hidden" value="1" name="TURN">
        <?php
        } else {
        ?>
            Saved! power plant is running
        <?php
            $_SESSION['coalSaved'] = false;
        }
        ?>
    </form>
</div>

<?php
    }
}
?>

</body>

</html>