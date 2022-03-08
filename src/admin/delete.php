
<link rel="stylesheet" href="../ui/styles/form-style.css">
<div class="form">
    <h2><strong>Delete user

            <?php
            require_once '../database/config.php';
            $req = $pdo->query("SET FOREIGN_KEY_CHECKS=0;");
            $check = $req->fetch();
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];
                echo "id is: ", $id;
                $stmt = $pdo->query("DELETE FROM `prosumer` WHERE `prosumer`.`iduser` = $id;");
                $data = $stmt->fetch();
                header("location: admin.php");
            } else {
                $id = $_GET['id'];
                $stmt = $pdo->query("SELECT * FROM `prosumer` WHERE `prosumer`.`iduser` = $id;");
                $data = $stmt->fetch();
                echo "<i>" . $data['username'] . "</i>";
            }
            ?>
            ? This action cannot be undone</strong></h2>
    <form action="delete.php" method="post">
        <input type="submit" name="delete" data-value="Delete forever" class="button-delete">
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    </form>

    <form action="admin.php" method="post">
        <input type="submit" value="Back to home" class="button-reg">
    </form>
</div>


</body>

</html>