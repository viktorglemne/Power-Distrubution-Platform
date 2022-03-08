<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!$_SESSION['admin']) {
    header("location: ../index.php");
}

require_once '../ui/navBar.php';
require_once '../database/config.php';

$USER = $_SESSION['username'];

$stmt2 = $pdo->query("UPDATE `prosumer` SET `login_timestamp`=CURRENT_TIMESTAMP WHERE username='$USER';");
$row2 = $stmt2->fetch();


$USER = $_SESSION['username'];
$stmtBlock = $pdo->query("SELECT * FROM `prosumer` WHERE username='$USER';");
$rowBlock = $stmtBlock->fetch();

$now = new DateTime();
$now->format('H:i:s');    // MySQL datetime format
$TIMER = $now->getTimestamp();

//echo $TIMER;

if ($TIMER < $rowBlock['blocked']) {
    echo "You are blocked! There is ", $rowBlock['blocked'] - $TIMER, " seconds until it is lifted.";
} else {
    
?>

<link rel="stylesheet" href="../ui/styles/tables.css">
<link rel="stylesheet" href="../ui/styles/form-style.css">
<div class="content">
    <table class="table-style">
        <h2>List of Users</h2>
        <?php
        $stmt = $pdo->query("SELECT * FROM `prosumer`;");
        while ($row = $stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $row['username']; ?></td>
                <td><a href="viewUser.php?id=<?php echo $row['iduser']; ?>">System</a></td>
                <td><a href="edit.php?id=<?php echo $row['iduser']; ?>">Edit</a></td>
                <td><a href="delete.php?id=<?php echo $row['iduser']; ?>">Delete</a></td>
                <td>
                    <form action="block.php" method="post">
                        <div>
                            <input class="input-table" id="example" type="text" name="block" placeholder="10-100 sec">
                            <input class="button-table" type="submit" value="Block">
                            <input type="hidden" name="user" value="<?php echo $row['username'];?>">
                        </div>
                    </form>
                </td>
                <td style="text-align:center;">


                    <?php


                    if ($row['loggedIn']) {
                        $datearr = explode(" ", $row['login_timestamp']);
                        // echo $datearr[1];
                        $min = explode(":", $datearr[1]);

                        $currHour = date("H");
                        $currMin = date("i");

                        if ($datearr[0] == date("Y-m-d")) {
                            if ($currHour != $min[0]) {
                                if (($currMin - 5) < 0) {
                                    if (($currMin - ($min[1]) - 60) > 5) {
                    ?>
                                        <img src="../ui/images/offline.png" alt="" width="25" height="25" class="center">
                                    <?php
                                    } else {
                                    ?>
                                        <img src="../ui/images/online2.png" alt="" width="25" height="25" class="center">
                                    <?php
                                    }
                                } else {
                                    if (($currMin - 5) < $min[1]) {
                                    ?>
                                        <img src="../ui/images/online2.png" alt="" width="25" height="25" class="center">
                                    <?php
                                    } else {
                                    ?>
                                        <img src="../ui/images/offline.png" alt="" width="25" height="25" class="center">
                                    <?php
                                    }
                                }
                            } else {
                                if (($currMin - 5) < $min[1]) {
                                    ?>
                                    <img src="../ui/images/online2.png" alt="" width="25" height="25" class="center">
                                <?php
                                } else {
                                ?>
                                    <img src="../ui/images/offline.png" alt="" width="25" height="25" class="center">
                            <?php
                                }
                            }
                        } else {
                            ?>
                            <img src="../ui/images/offline.png" alt="" width="25" height="25" class="center">
                        <?php
                        }
                    } else {
                        ?>
                        <img src="../ui/images/offline.png" alt="" width="25" height="25" class="center">
                    <?php
                    }
                    ?>
                    <!--
                if online:
                    show online symbol
                else:
                    offline symbol
                -->
                </td>

            </tr>
        <?php
        }
        ?>

    </table>

    <?php
    if (!$_SESSION["admin"]) {
        header("location: ..\index.php");
        exit;
    }
}
    ?>
    <br>


    <!-- <table class="table-style">
        <tr>
            <thead>
                <th scope="col">Current wind</th>
                <th scope="col">Current production</th>
                <th scope="col">Current consumption</th>
                <th scope="col">Net production</th>
                <th scope="col">Buffer</th>
                <th scope="col">Current electricity price on the market</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.3</td>
                <td>1000</td>
                <td>xxx</td>
                <td>xxx</td>
                <td>xxx</td>
                <td>xxx</td>
            </tr>
        </tbody>
    </table> -->

</div>

<script>
    function inputChange(session) {
        if (session) {
            location.reload();
        }
    }
</script>

</body>

</html>