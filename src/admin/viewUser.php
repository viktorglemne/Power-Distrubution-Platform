<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once '../ui/navBar.php';
require_once '../database/config.php';



if ($_SESSION['admin']) {

    $USER = $_GET["id"];

    $stmt = $pdo->query("SELECT * FROM `prosumer` WHERE iduser='$USER';");
    $row = $stmt->fetch();

    $USERID = $row["iduser"];
    $stmt2 = $pdo->query("SELECT SUM(production) FROM `kraftverk` WHERE user_iduser='$USERID';");
    $row2 = $stmt2->fetch();
    $stmt3 = $pdo->query("SELECT * FROM `wind` ORDER BY id DESC LIMIT 1;");
    $row3 = $stmt3->fetch();
?>

    <link rel="stylesheet" href="../ui/styles/tables.css">
    <div class="content">
        <h2><?php echo $row['username'] ?></h2>
        <table class="table-style">
            <thead>
                <tr>
                    <th scope="col">Current wind</th>
                    <th scope="col">Current production</th>
                    <th scope="col">Current consumption</th>
                    <th scope="col">Net production</th>
                    <th scope="col">Ratio to buffer</th>
                    <th scope="col">Buffer</th>
                    <th scope="col">Ratio to buy</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $row3['speed'] ?></td>
                    <td><?php echo array_sum($row2) ?></td>
                    <td><?php echo $row['consumption'] ?></td>
                    <td><?php echo array_sum($row2) - $row['consumption'] ?></td>
                    <td><?php echo $row['ratio'] ?></td>
                    <td><?php echo $row['buffer'] ?></td>
                    <td><?php echo $row['ratioToBuy'] ?></td>
                </tr>
            </tbody>
        </table>
        <br>
    <?php

} else {
    echo "Access denied";
}
    ?>

    <a href="admin.php">
        <button>Return</button>
    </a>