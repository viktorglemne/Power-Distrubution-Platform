<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once '../ui/navBar.php';
require_once '../database/config.php';

try {
    if (!isset($_SESSION['username'])) {
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
            $stmt2 = $pdo->query("UPDATE `prosumer` SET `loggedIn`=1 WHERE username='$USER';");
            $row2 = $stmt2->fetch();
            $stmt2 = $pdo->query("UPDATE `prosumer` SET `login_timestamp`=CURRENT_TIMESTAMP WHERE username='$USER';");
            $row2 = $stmt2->fetch();
            if ($row['admin'] == true) {
                echo " and you are an admin!";
                $_SESSION["admin"] = "true";
            }
        }
        $_SESSION['settings'] = false;
        $_SESSION['imagePath'] = $row['imagePath'];
        header("location: userpage.php");
    }
    if (isset($_SESSION['username'])) {


        $USER = $_SESSION['username'];
        $stmt = $pdo->query("SELECT * FROM `prosumer` WHERE username='$USER';");
        $row = $stmt->fetch();

        $now = new DateTime();
        $now->format('H:i:s');    // MySQL datetime format
        $TIMER = $now->getTimestamp();

        //echo $TIMER;

        if ($TIMER < $row['blocked']) {
            echo "You are blocked! There is ", $row['blocked'] - $TIMER, " seconds until it is lifted.";
        } else {
            $USERID = $row["iduser"];
            $stmt2 = $pdo->query("SELECT SUM(production) FROM `kraftverk` WHERE user_iduser='$USERID';");
            $row2 = $stmt2->fetch();
            $stmt3 = $pdo->query("SELECT * FROM `wind` ORDER BY id DESC LIMIT 1;");
            $row3 = $stmt3->fetch();
            $stmt4 = $pdo->query("SELECT SUM(production) FROM `kraftverk`;");
            $row4 = $stmt4->fetch();
            $stmtCons = $pdo->query("SELECT SUM(consumption) FROM `prosumer`;");
            $rowCons = $stmtCons->fetch();

            $stmt5 = $pdo->prepare("SELECT * FROM `wind` ORDER BY id DESC LIMIT 10;");
            $stmt5->execute();
            $arrayWind = array();
            $j = 0;
            foreach ($stmt5 as $row5) {
                $arrayWind[$j] = $row5['speed'];
                $j = $j + 1;
            }

            $stmt6 = $pdo->prepare("SELECT * FROM `power` ORDER BY id DESC LIMIT 10;");
            $stmt6->execute();
            $arrayPower = array();
            $arrayPrice = array();
            $i = 0;
            foreach ($stmt6 as $row6) {
                $arrayPower[$i] = $row6['power'];
                $arrayPrice[$i] = $row6['price'];
                $i = $i + 1;
            }
?>


            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawVisualization);

                function drawVisualization() {
                    // var passedArray = ?php echo json_encode($arrayPower); ?>;

                    // Some raw data (not necessarily accurate)
                    var data = google.visualization.arrayToDataTable([
                        ['Time', 'Production', 'Consumption'],
                        ['Current', 2000, 5000],
                        ['1 Hour ago', 5500, 5000],
                        ['2 Hours ago', 2200, 4000],
                        ['3 Hours ago', 300, 6000],
                        ['4 Hours ago', 800, 5500]
                    ]);

                    var options = {
                        vAxis: {
                            title: ''
                        },
                        hAxis: {
                            title: 'Month'
                        },
                        seriesType: 'bars',
                        series: {
                            5: {
                                type: 'line'
                            }
                        },
                        backgroundColor: {
                            fill: 'transparent'
                        },
                        chartArea: {
                            width: '60%',
                        }
                    };

                    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">
                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    // var passedArray = ?php echo json_encode($arrayPower); ?>;

                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['Your production', <?php echo array_sum($row2) ?>],
                        ['Total production', <?php echo array_sum($row4) ?>]
                    ]);
                    var data2 = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        ['Your consumption', <?php echo $row['consumption'] ?>],
                        ['Total consumption', <?php echo array_sum($rowCons) ?>]
                    ]);

                    var options = {
                        backgroundColor: {
                            fill: 'transparent'
                        },
                        chartArea: {
                            width: '90%',
                        }
                    };

                    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
                    var chart2 = new google.visualization.PieChart(document.getElementById('piechart2'));

                    chart.draw(data, options);
                    chart2.draw(data2, options);
                }
            </script>


            <link rel="stylesheet" href="../ui/styles/dashboard-style.css">
            <link rel="stylesheet" href="../ui/styles/tables.css">
            <div class="content">
                <table class="table-style">
                    <thead>
                        <tr>
                            <th scope="col">Current wind</th>
                            <th scope="col">Current production</th>
                            <th scope="col">Current consumption</th>
                            <th scope="col">Net production</th>
                            <th scope="col">Ratio to buffer</th>
                            <th scope="col">Your Buffer</th>
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
            


            /* $stmt = $pdo->query("SELECT SUM(speed) FROM `wind` WHERE 1;");
        $row = $stmt->fetch(); */
        
        
        if (isset($_REQUEST['submit'])) {
            $ratio = $_POST['ratio'];
            echo "ratio is :", $ratio;
            $user = $_SESSION['username'];
            echo "user is: ", $user;
            $stmt = $pdo->exec("UPDATE 'prosumer' SET 'ratio'='$ratio' WHERE username='$user'");
            $row = $stmt->fetch();
        }
        ?>
    
    <div class="parent-container">
        <div class="item">
            <h1>Price</h1>
            <div id="hart_div"></div>
            <h2><?php $stmtPower = $pdo->query("SELECT * FROM `power` ORDER BY id DESC LIMIT 1;");
                $rowPower = $stmtPower->fetch();
                echo $rowPower['price'],"$/kWh";
            ?></h2>
            
        </div>
        <div class="item">

            <h1>Average wind speed </h1>
            <h2><?php $stmt = $pdo->query("SELECT SUM(speed) FROM `wind` WHERE 1 ORDER BY id DESC LIMIT 24;");
            $row = $stmt->fetch();

            $stmt2 = $pdo->query("SELECT COUNT(speed) FROM `wind` WHERE 1 ORDER BY id DESC LIMIT 24;");
            $row2 = $stmt2->fetch();
            echo  Round(array_sum($row) / $row2['COUNT(speed)'],2), "m/s </h2>";?></h2>
        </div>
        <div class="break"></div>
        <div class="item">
            <h1>History</h1>
            <div id="chart_div"></div>
        </div>
        <div class="item">
            <h1>Production and consumption</h1>
            <div class="child">
                <div class="child-item">
                    <div id="piechart"></div>
                </div>
                <div class="child-item">
                    <div id="piechart2"></div>
                </div>
            </div>
            <p style="color: white;">style-text</p>
        </div>
    </div>

        <?php


        }
    }
} catch (\Throwable $e) {
    echo $e->getMessage();
}
    ?>

    
    </html>