<head>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }

    require_once 'ui/navBarIndex.php';
    include_once 'database/config.php';
    $_SESSION['coalSaved'] = false;


    $pdo;
    $stmt = $pdo->prepare("SELECT * FROM `power` ORDER BY id DESC LIMIT 10;");
    $stmt->execute();
    $arrayPower = array();
    $arrayPrice = array();
    $i = 0;
    foreach ($stmt as $row) {
        $arrayPower[$i] = $row['power'];
        $arrayPrice[$i] = $row['price'];
        $i = $i + 1;
    }

    $stmt2 = $pdo->prepare("SELECT * FROM `wind` ORDER BY id DESC LIMIT 10;");
    $stmt2->execute();
    $arrayWind = array();
    $j = 0;
    foreach ($stmt2 as $row2) {
        $arrayWind[$j] = $row2['speed'];
        $j = $j + 1;
    }


    ?><br>
    <link rel="stylesheet" href="ui/styles/dashboard-style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {
            'packages': ['corechart']
        });

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(powerChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.

        /////////////////////////////////
        ///////// POWER CHART////////////
        ////////////////////////////////
        function powerChart() {

            var passedArray = <?php echo json_encode($arrayPower); ?>;
            /* document.write("test");

            for (var i = 0; i < passedArray.length; i++) {
                document.write(passedArray[i]);
            } */

            var data = google.visualization.arrayToDataTable([
                ['Diameter', 'Power'],
                ['10 hrs ago', passedArray[9]],
                [9, passedArray[8]],
                [8, passedArray[7]],
                [7, passedArray[6], ],
                [6, passedArray[5]],
                [5, passedArray[4]],
                [4, passedArray[3]],
                [3, passedArray[2]],
                [2, passedArray[1]],
                ['present', passedArray[0]]
            ]);

            // Set chart options
            var options = {
                legend: 'none',
                colors: ['#F29F05'],
                backgroundColor: {
                    fill: 'transparent'
                },
                chartArea: {
                    width: '90%',
                }
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.ColumnChart(document.getElementById('power_chart_div'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        /////////////////////////////////
        ///////// PRICE CHART////////////
        ////////////////////////////////
        google.charts.setOnLoadCallback(priceLines);

        function priceLines() {

            var priceArray = <?php echo json_encode($arrayPrice); ?>;

            var data = google.visualization.arrayToDataTable([
                ['Hour', 'price'],
                ['10 hrs ago', priceArray[9]],
                [9, priceArray[8]],
                [8, priceArray[7]],
                [7, priceArray[6]],
                [6, priceArray[5]],
                [5, priceArray[4]],
                [4, priceArray[3]],
                [3, priceArray[2]],
                [2, priceArray[1]],
                ['present', priceArray[0]]
            ]);

            var options = {
                legend: 'none',
                colors: ['#2619A8'],
                backgroundColor: {
                    fill: 'transparent'
                },
                chartArea: {
                    width: '80%',
                }
            };
            var chart = new google.visualization.AreaChart(document.getElementById('price_curve_chart'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        ////////////////////////////////
        ///////// WIND CHART////////////
        ////////////////////////////////
        google.charts.setOnLoadCallback(windLines);

        function windLines() {

            var windArray = <?php echo json_encode($arrayWind); ?>;

            var data = google.visualization.arrayToDataTable([
                ['Hour', 'wind'],
                ['10 hrs ago', windArray[9]],
                [9, windArray[8]],
                [8, windArray[7]],
                [7, windArray[6]],
                [6, windArray[5]],
                [5, windArray[4]],
                [4, windArray[3]],
                [3, windArray[2]],
                [2, windArray[1]],
                ['present', windArray[0]]
            ]);

            var options = {
                legend: 'none',
                colors: ['#4AD988'],
                backgroundColor: {
                    fill: 'transparent'
                },
                chartArea: {
                    width: '80%',
                }
            };
            var chart = new google.visualization.AreaChart(document.getElementById('wind_curve_chart'));
            chart.draw(data, options);
        }
    </script>
</head>



<?php

$stmt = $pdo->query("SELECT * FROM `power` ORDER BY id DESC LIMIT 1;");
$row = $stmt->fetch();
/* $stmt2 = $pdo->query("SELECT SUM(consumption) FROM `prosumer`;");
$row2 = $stmt2->fetch(); */
$stmt3 = $pdo->query("SELECT * FROM `wind` ORDER BY id DESC LIMIT 1");
$row3 = $stmt3->fetch();
$stmt4 = $pdo->query("SELECT SUM(consumption) FROM `prosumer`;");
$row4 = $stmt4->fetch();
//👌
if (isset($_SESSION['username'])) {
    echo "<h1 class='header'>Hello and Welcome ", ucfirst($_SESSION['username']), "</h1>";
} else if (isset($_SESSION['logout'])) {
    echo "<h1>You have been logged out</h1>";
    unset($_SESSION['logout']);
} else {
    echo "<h1 class='header'>Welcome!</h1>";
    echo "<h2 class='header'>Power on market: ", $row['power'], " kWh" , "<br>last updated: ", $row3['datum'], "</h2>";
}
?>
<div class="parent-container">
    <div class="item">
        <h1>Power: <?php echo $row['power']?> kWh</h1>
        <div id="power_chart_div"></div>
        <p>Electricy Power last 10 hours</p>
    </div>
    <div class="break"></div> <!-- break -->
    <div class="item">
        <h1>Price: $<?php echo $row['price']?></h1>
        <div id="price_curve_chart"></div>
        <p>Price last 10 hours</p>
    </div>
    <div class="item">
        <h1>Wind: <?php echo $row3['speed']?> m/s</h1>
        <div id="wind_curve_chart"></div>
        <p>Wind speed last 10 hours</p>
    </div>
</div>
</body>

</html>