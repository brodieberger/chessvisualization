<?php
include "dbconfig.php";
$con = mysqli_connect($host, $username, $password, $dbname) or die("<br>Cannot connect to DB:$dbname on $host\n");

$opening1 = "Unknown";
$opening2 = "Unknown";

if (isset($_POST['opening1'])) {
    $opening1 = mysqli_real_escape_string($con, $_POST['opening1']);
} else {
    $opening1 = "Unknown";
}

if (isset($_POST['opening2'])) {
    $opening2 = mysqli_real_escape_string($con, $_POST['opening2']);
} else {
    $opening2 = "Unknown";
}
?>

<html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    .sidebar {
        min-height: 100vh;
    }
</style>

<body style="overflow-x: hidden">
    <nav class="navbar navbar-dark sticky-top bg-dark">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Brodie Berger Chess Stats</a>
        <a class="nav-link" href="index.php" style="color:white">Reset</a>
    </nav>

    <div class="row px-2">
        <!-- Left side of screen -->
        <div class="col-3 d-none d-md-block bg-light sidebar p-3" style="position:fixed;">
            <h1>Chess Openings Comparer</h1>
            <hr>
            <p>Welcome to my site! Please select two chess openings to begin comparing.</p>

            <form method="post" action="?">
                <div class="form-group">
                    <label for="opening1">Opening 1:</label>
                    <select name="opening1" id="opening1" class="form-control">
                        <option value="<?php echo stripcslashes($opening1) ?>"><?php echo stripcslashes($opening1) ?>
                        </option>
                        <option value="Sicilian Defense">Sicilian Defense</option>
                        <option value="French Defense">French Defense</option>
                        <option value="Queen's Pawn">Queen's Pawn</option>
                        <option value="Italian Game">Italian Game</option>
                        <option value="King's Pawn">King's Pawn</option>
                        <option value="Ruy Lopez">Ruy Lopez</option>
                        <option value="English Defense">English Defense</option>
                        <option value="Scandinavian Defense">Scandinavian Defense</option>
                        <option value="Philidor Defense">Philidor Defense</option>
                        <option value="Queen's Gambit Declined">Queen's Gambit Declined</option>
                        <option value="Caro-Kann Defense">Caro-Kann Defense</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="opening2">Opening 2:</label>
                    <select name="opening2" id="opening2" class="form-control">
                        <option value="<?php echo stripcslashes($opening2) ?>"><?php echo stripcslashes($opening2) ?>
                        </option>
                        <option value="Sicilian Defense">Sicilian Defense</option>
                        <option value="French Defense">French Defense</option>
                        <option value="Queen's Pawn">Queen's Pawn</option>
                        <option value="Italian Game">Italian Game</option>
                        <option value="King's Pawn">King's Pawn</option>
                        <option value="Ruy Lopez">Ruy Lopez</option>
                        <option value="English Defense">English Defense</option>
                        <option value="Scandinavian Defense">Scandinavian Defense</option>
                        <option value="Philidor Defense">Philidor Defense</option>
                        <option value="Queen's Gambit Declined">Queen's Gambit Declined</option>
                        <option value="Caro-Kann Defense">Caro-Kann Defense</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Compare</button>
            </form>

            <p>Currently comparing: <br> <?php echo stripcslashes("$opening1 Vs. $opening2"); ?> <br>
            </p>
            <hr>
            &nbsp;&nbsp;&nbsp;&nbsp;<a
                href="https://docs.google.com/document/d/e/2PACX-1vQHU7KUKDAwcB6TuvF4Xp9Zr4hgkjUeNK-2jGJSlHW3aSOmW2tMpDNkut3P0WW_DcimcTcvs9tYSOkR/pub"><img
                    src="chessbook.png" style="width:150px" /></a>
            <a href="https://www.kaggle.com/datasets/datasnaek/chess"><img src="lichess.png" style="width:150px" /></a>
            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
                    href="https://docs.google.com/document/d/e/2PACX-1vQHU7KUKDAwcB6TuvF4Xp9Zr4hgkjUeNK-2jGJSlHW3aSOmW2tMpDNkut3P0WW_DcimcTcvs9tYSOkR/pub"
                    style="color:black">User
                    Manual</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
                    href="https://www.kaggle.com/datasets/datasnaek/chess" style="color:black">Data
                    Source</a></p>
        </div>

        <!-- Right side of screen -->
        <main role="main" class="col-9 offset-3 bg-white">

            <!--Top Half Header Row-->
            <div class="row">
                <div class="col pt-2">
                    <h2 style="text-align:center">Win Percentages</h2>
                </div>
            </div>

            <!-- Top Half Content Row-->
            <div class="row" style="">

                <!--Top half left side-->
                <div class="col-2">
                    <br>
                    <h5 style="text-align:center">Select Pie Chart</h5><br>
                    <button type="button" class="btn btn-primary btn-sm" onclick="drawWinChart1(); drawWinChart2()"
                        style="width: 100%; text-align:center">Side Win Rate</button>
                    <br><br>
                    <button type="button" class="btn btn-primary btn-sm"
                        onclick="drawVictoryChart1(); drawVictoryChart2()"
                        style="width: 100%; text-align:center">Victory Type</button>
                </div>

                <!-- Top half left chart -->
                <div class="col-5">

                    <!--Chart 1 -->
                    <div id="myChart1" style="width:60%; max-width:600px; height:25vh; margin-left: 25%"></div>
                    <script>
                        google.charts.load('current', {
                            'packages': ['corechart']
                        });

                        google.charts.setOnLoadCallback(drawWinChart1);

                        function drawWinChart1() {
                            const data = google.visualization.arrayToDataTable([
                                ['Result', 'Count'],
                                <?php
                                $query = "SELECT white_wins, black_wins, draws FROM chess_stats WHERE opening_name_short = '$opening1';";
                                $result = mysqli_query($con, $query);

                                if (!$result) {
                                    die(mysqli_error($con));
                                }

                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo "['White Wins', " . $row['white_wins'] . "],";
                                    echo "['Black Wins', " . $row['black_wins'] . "],";
                                    echo "['Draws', " . $row['draws'] . "]";
                                }
                                ?>
                            ]);

                            const options = {
                                title: '<?php echo $opening1; ?> Win Percentages',
                                chartArea: {
                                    left: 5,
                                    top: 20,
                                    width: '100%',
                                    height: '100%',
                                }
                            };
                            const chart = new google.visualization.PieChart(document.getElementById('myChart1'));
                            chart.draw(data, options);
                        }
                        function drawVictoryChart1() {
                            const data = google.visualization.arrayToDataTable([
                                ['Result', 'Count'],
                                <?php
                                $query = "select mates, resignations, timeouts, draws from chess_stats where opening_name_short = '$opening1';";
                                $result = mysqli_query($con, $query);

                                if (!$result) {
                                    die(mysqli_error($con));
                                }

                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo "['Resignations', " . $row['resignations'] . "],";
                                    echo "['Checkmates', " . $row['mates'] . "],";
                                    echo "['Timeouts', " . $row['timeouts'] . "],";
                                    echo "['Draws', " . $row['draws'] . "]";
                                }
                                ?>
                            ]);

                            const options = {
                                title: '<?php echo $opening1; ?> Victory Types',
                                chartArea: { left: 5, top: 20, width: '100%', height: '100%' }
                            };
                            const chart = new google.visualization.PieChart(document.getElementById('myChart1'));
                            chart.draw(data, options);
                        }
                    </script>
                </div>


                <!-- Top half right chart  -->
                <div class="col-5">

                    <!-- Chart 2 -->
                    <div id="myChart2" style="width:60%; max-width:600px; height:100%; margin-left: 30px"></div>
                    <script>
                        google.charts.load('current', {
                            'packages': ['corechart']
                        });
                        google.charts.setOnLoadCallback(drawWinChart2);

                        function drawWinChart2() {
                            const data = google.visualization.arrayToDataTable([
                                ['Result', 'Count'],
                                <?php
                                $query = "SELECT white_wins, black_wins, draws FROM chess_stats WHERE opening_name_short = '$opening2';";
                                $result = mysqli_query($con, $query);

                                if (!$result) {
                                    die(mysqli_error($con));
                                }

                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo "['White Wins', " . $row['white_wins'] . "],";
                                    echo "['Black Wins', " . $row['black_wins'] . "],";
                                    echo "['Draws', " . $row['draws'] . "]";
                                }
                                ?>
                            ]);

                            const options = {
                                title: '<?php echo $opening2; ?> Win Percentages',
                                chartArea: {
                                    left: 5,
                                    top: 20,
                                    width: '100%',
                                    height: '100%',
                                }
                            };
                            const chart = new google.visualization.PieChart(document.getElementById('myChart2'));
                            chart.draw(data, options);
                        }
                        function drawVictoryChart2() {
                            const data = google.visualization.arrayToDataTable([
                                ['Result', 'Count'],
                                <?php
                                $query = "select mates, resignations, timeouts, draws from chess_stats where opening_name_short = '$opening2';";
                                $result = mysqli_query($con, $query);

                                if (!$result) {
                                    die(mysqli_error($con));
                                }

                                if ($row = mysqli_fetch_assoc($result)) {
                                    echo "['Resignations', " . $row['resignations'] . "],";
                                    echo "['Checkmates', " . $row['mates'] . "],";
                                    echo "['Timeouts', " . $row['timeouts'] . "],";
                                    echo "['Draws', " . $row['draws'] . "]";

                                }
                                ?>
                            ]);

                            const options = {
                                title: '<?php echo $opening2; ?> Victory Types',
                                chartArea: { left: 5, top: 20, width: '100%', height: '100%' }
                            };
                            const chart = new google.visualization.PieChart(document.getElementById('myChart2'));
                            chart.draw(data, options);
                        }
                    </script>
                </div>

            </div>
            <hr>
            <!-- Bottom Half -->
            <!--Bottom Half Header Row-->
            <div class="row">
                <div class="col">
                    <h2 style="text-align:center">Usage Statistics</h2>
                </div>
            </div>

            <!-- Bottom Half Content Row -->
            <div class="row" style="background-color">
                <!--Bottom half left side-->
                <div class="col-2" align="center">
                    <br><br><br>
                    <h5 style="text-align:center">Select Bar Graph</h5>
                    <button type="button" class="btn btn-primary btn-sm" onclick="drawUsageChart1(); drawUsageChart2()"
                        style="width: 100%; text-align:center">Usage by Skill Level</button>
                    <br><br>

                    <h6>Win Rate by Skill Level</h6>
                    <div align="center">
                        <button type="button" class="btn btn-primary btn-sm"
                            onclick="drawWhiteWinRateChart1(); drawWhiteWinRateChart2()"
                            style="width: 30%; text-align:center">White
                        </button>
                        <button type="button" class="btn btn-primary btn-sm"
                            onclick="drawBlackWinRateChart1(); drawBlackWinRateChart2()"
                            style="width: 30%; text-align:center">Black
                        </button>
                    </div>
                </div>

                <!-- Bottom half left chart-->
                <div class="col-5">

                    <!-- Chart 3 -->
                    <div id="myChart3" style="width: 500px; height: 400px">
                    </div>
                    <script language="JavaScript">
                        function drawUsageChart1() {
                            var data = google.visualization.arrayToDataTable([
                                ['Elo Range', 'Usage Percentage'],
                                <?php

                                for ($low = 1100; $low < 2000; $low += 100) {
                                    $high = $low + 100;

                                    // Fetch total matches in this Elo range
                                    $query_matchCount = "select count(id) as total_matches from chess_matches where white_rating >= $low and white_rating < $high;";
                                    $result_matchcount = mysqli_query($con, $query_matchCount);
                                    if ($row = mysqli_fetch_assoc($result_matchcount))
                                        $countofmatches = $row['total_matches']; // Get the count from the 'total_matches' field
                                
                                    // Fetch number of times an opening was used in this elo range
                                    $query_matchCountByOpening = "select count(id) as opening_matches from chess_matches where white_rating >= $low and white_rating < $high and opening_name_short = '$opening1';";
                                    $result_matchCountByOpening = mysqli_query($con, $query_matchCountByOpening);
                                    if ($row = mysqli_fetch_assoc($result_matchCountByOpening))
                                        $countofmatchesbyopening = $row['opening_matches']; // Get the count from the 'opening_matches' field
                                
                                    $percentage = round(($countofmatchesbyopening / $countofmatches) * 100, 2);

                                    // Define the Elo range
                                    $range = "$low - $high";

                                    // This goes into the chart
                                    echo "['$range', $percentage],";
                                }
                                ?>
                            ]);

                            var options = {
                                title: '<?php echo $opening1; ?> Usage by Elo Range',
                                chartArea: {
                                    width: '80%',
                                    height: '60%',
                                    top: 40
                                },
                                hAxis: {
                                    title: 'Elo Range',
                                    slantedText: true,
                                    slantedTextAngle: 45,
                                },
                                vAxis: {
                                    title: 'Percentage Usage (%)',
                                    //minValue: 0,
                                    //maxValue: 20
                                },
                                bar: {
                                    groupWidth: '90%'
                                },
                                legend: 'none',
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('myChart3'));
                            chart.draw(data, options);
                        }

                        function drawWhiteWinRateChart1() {
                            var data = google.visualization.arrayToDataTable([
                                ['Elo Range', 'Usage Percentage'],
                                <?php

                                for ($low = 1100; $low < 2000; $low += 100) {
                                    $high = $low + 100;

                                    $query_winsByOpening = "select count(id) as white_wins from chess_matches where white_rating >= $low and white_rating < $high and winner='white' and opening_name_short = '$opening1';";
                                    $result_winsByOpening = mysqli_query($con, $query_winsByOpening);
                                    if ($row = mysqli_fetch_assoc($result_winsByOpening))
                                        $wins_per_elo = $row['white_wins'];

                                    $query_matchCountByOpening = "select count(id) as opening_matches from chess_matches where white_rating >= $low and white_rating < $high and opening_name_short = '$opening1';";
                                    $result_matchCountByOpening = mysqli_query($con, $query_matchCountByOpening);
                                    if ($row = mysqli_fetch_assoc($result_matchCountByOpening))
                                        $countofmatchesbyopening = $row['opening_matches']; // Get the count from the 'opening_matches' field
                                
                                    $percentage = round(($wins_per_elo / $countofmatchesbyopening) * 100, 2);

                                    // Define the Elo range
                                    $range = "$low - $high";

                                    // This goes into the chart
                                    echo "['$range', $percentage],";
                                }
                                ?>
                            ]);
                            var options = {
                                title: '<?php echo $opening1; ?> Win Rate (White)',
                                chartArea: {
                                    width: '80%',
                                    height: '60%',
                                    top: 40
                                },
                                hAxis: {
                                    title: 'Elo Range',
                                    slantedText: true,
                                    slantedTextAngle: 45,
                                },
                                vAxis: {
                                    title: 'White Win Rate (%)',
                                    minValue: 0,
                                    maxValue: 100,
                                    ticks: [0, 25, 50, 75, 100],
                                },
                                bar: {
                                    groupWidth: '90%'
                                },
                                legend: 'none',

                            };
                            var chart = new google.visualization.ColumnChart(document.getElementById('myChart3'));
                            chart.draw(data, options);
                        }
                        function drawBlackWinRateChart1() {
                            var data = google.visualization.arrayToDataTable([
                                ['Elo Range', 'Usage Percentage'],
                                <?php

                                for ($low = 1100; $low < 2000; $low += 100) {
                                    $high = $low + 100;

                                    $query_winsByOpening = "select count(id) as white_wins from chess_matches where white_rating >= $low and white_rating < $high and winner='black' and opening_name_short = '$opening1';";
                                    $result_winsByOpening = mysqli_query($con, $query_winsByOpening);
                                    if ($row = mysqli_fetch_assoc($result_winsByOpening))
                                        $wins_per_elo = $row['white_wins'];

                                    $query_matchCountByOpening = "select count(id) as opening_matches from chess_matches where white_rating >= $low and white_rating < $high and opening_name_short = '$opening1';";
                                    $result_matchCountByOpening = mysqli_query($con, $query_matchCountByOpening);
                                    if ($row = mysqli_fetch_assoc($result_matchCountByOpening))
                                        $countofmatchesbyopening = $row['opening_matches']; // Get the count from the 'opening_matches' field
                                
                                    $percentage = round(($wins_per_elo / $countofmatchesbyopening) * 100, 2);

                                    // Define the Elo range
                                    $range = "$low - $high";

                                    // This goes into the chart
                                    echo "['$range', $percentage],";
                                }
                                ?>
                            ]);
                            var options = {
                                title: '<?php echo $opening1; ?> Win Rate (White)',
                                chartArea: {
                                    width: '80%',
                                    height: '60%',
                                    top: 40
                                },
                                hAxis: {
                                    title: 'Elo Range',
                                    slantedText: true,
                                    slantedTextAngle: 45,
                                },
                                vAxis: {
                                    title: 'White Win Rate (%)',
                                    minValue: 0,
                                    maxValue: 100,
                                    ticks: [0, 25, 50, 75, 100],
                                },
                                bar: {
                                    groupWidth: '90%'
                                },
                                legend: 'none',

                            };
                            var chart = new google.visualization.ColumnChart(document.getElementById('myChart3'));
                            chart.draw(data, options);
                        }
                        google.charts.setOnLoadCallback(drawUsageChart1);
                    </script>
                </div>

                <div class="col-5">

                    <!-- Chart 4 -->
                    <div id="myChart4" style="width: 500px; height: 400px; margin-left: -10%">
                    </div>
                    <script language="JavaScript">
                        function drawUsageChart2() {
                            var data = google.visualization.arrayToDataTable([
                                ['Elo Range', 'Usage Percentage'],
                                <?php

                                for ($low = 1100; $low < 2000; $low += 100) {
                                    $high = $low + 100;

                                    // Fetch total matches in this Elo range
                                    $query_matchCount = "select count(id) as total_matches from chess_matches where white_rating >= $low and white_rating < $high;";
                                    $result_matchcount = mysqli_query($con, $query_matchCount);
                                    if ($row = mysqli_fetch_assoc($result_matchcount))
                                        $countofmatches = $row['total_matches']; // Get the count from the 'total_matches' field
                                
                                    // Fetch number of times an opening was used in this elo range
                                    $query_matchCountByOpening = "select count(id) as opening_matches from chess_matches where white_rating >= $low and white_rating < $high and opening_name_short = '$opening2';";
                                    $result_matchCountByOpening = mysqli_query($con, $query_matchCountByOpening);
                                    if ($row = mysqli_fetch_assoc($result_matchCountByOpening))
                                        $countofmatchesbyopening = $row['opening_matches']; // Get the count from the 'opening_matches' field
                                
                                    $percentage = round(($countofmatchesbyopening / $countofmatches) * 100, 2);

                                    // Define the Elo range
                                    $range = "$low - $high";

                                    // This goes into the chart
                                    echo "['$range', $percentage],";
                                }
                                ?>
                            ]);

                            var options = {
                                title: '<?php echo $opening2; ?> Usage by Elo Range',
                                chartArea: {
                                    width: '80%',
                                    height: '60%',
                                    top: 40
                                },
                                hAxis: {
                                    title: 'Elo Range',
                                    slantedText: true,
                                    slantedTextAngle: 45,
                                },
                                vAxis: {
                                    title: 'Percentage Usage (%)',
                                    //minValue: 0,
                                    //maxValue: 20
                                },
                                bar: {
                                    groupWidth: '90%'
                                },
                                legend: 'none',
                            };

                            var chart = new google.visualization.ColumnChart(document.getElementById('myChart4'));
                            chart.draw(data, options);
                        }
                        function drawWhiteWinRateChart2() {
                            var data = google.visualization.arrayToDataTable([
                                ['Elo Range', 'Usage Percentage'],
                                <?php

                                for ($low = 1100; $low < 2000; $low += 100) {
                                    $high = $low + 100;

                                    $query_winsByOpening = "select count(id) as white_wins from chess_matches where white_rating >= $low and white_rating < $high and winner='white' and opening_name_short = '$opening2';";
                                    $result_winsByOpening = mysqli_query($con, $query_winsByOpening);
                                    if ($row = mysqli_fetch_assoc($result_winsByOpening))
                                        $wins_per_elo = $row['white_wins'];

                                    $query_matchCountByOpening = "select count(id) as opening_matches from chess_matches where white_rating >= $low and white_rating < $high and opening_name_short = '$opening2';";
                                    $result_matchCountByOpening = mysqli_query($con, $query_matchCountByOpening);
                                    if ($row = mysqli_fetch_assoc($result_matchCountByOpening))
                                        $countofmatchesbyopening = $row['opening_matches']; // Get the count from the 'opening_matches' field
                                
                                    $percentage = round(($wins_per_elo / $countofmatchesbyopening) * 100, 2);

                                    // Define the Elo range
                                    $range = "$low - $high";

                                    // This goes into the chart
                                    echo "['$range', $percentage],";
                                }
                                ?>
                            ]);
                            var options = {
                                title: '<?php echo $opening2; ?> Win Rate (White)',
                                chartArea: {
                                    width: '80%',
                                    height: '60%',
                                    top: 40
                                },
                                hAxis: {
                                    title: 'Elo Range',
                                    slantedText: true,
                                    slantedTextAngle: 45,
                                },
                                vAxis: {
                                    title: 'White Win Rate (%)',
                                    minValue: 0,
                                    maxValue: 100,
                                    ticks: [0, 25, 50, 75, 100],
                                },
                                bar: {
                                    groupWidth: '90%'
                                },
                                legend: 'none',

                            };
                            var chart = new google.visualization.ColumnChart(document.getElementById('myChart4'));
                            chart.draw(data, options);
                        }
                        function drawBlackWinRateChart2() {
                            var data = google.visualization.arrayToDataTable([
                                ['Elo Range', 'Usage Percentage'],
                                <?php

                                for ($low = 1100; $low < 2000; $low += 100) {
                                    $high = $low + 100;

                                    $query_winsByOpening = "select count(id) as white_wins from chess_matches where white_rating >= $low and white_rating < $high and winner='black' and opening_name_short = '$opening2';";
                                    $result_winsByOpening = mysqli_query($con, $query_winsByOpening);
                                    if ($row = mysqli_fetch_assoc($result_winsByOpening))
                                        $wins_per_elo = $row['white_wins'];

                                    $query_matchCountByOpening = "select count(id) as opening_matches from chess_matches where white_rating >= $low and white_rating < $high and opening_name_short = '$opening2';";
                                    $result_matchCountByOpening = mysqli_query($con, $query_matchCountByOpening);
                                    if ($row = mysqli_fetch_assoc($result_matchCountByOpening))
                                        $countofmatchesbyopening = $row['opening_matches']; // Get the count from the 'opening_matches' field
                                
                                    $percentage = round(($wins_per_elo / $countofmatchesbyopening) * 100, 2);

                                    // Define the Elo range
                                    $range = "$low - $high";

                                    // This goes into the chart
                                    echo "['$range', $percentage],";
                                }
                                ?>
                            ]);
                            var options = {
                                title: '<?php echo $opening2; ?> Win Rate (White)',
                                chartArea: {
                                    width: '80%',
                                    height: '60%',
                                    top: 40
                                },
                                hAxis: {
                                    title: 'Elo Range',
                                    slantedText: true,
                                    slantedTextAngle: 45,
                                },
                                vAxis: {
                                    title: 'White Win Rate (%)',
                                    minValue: 0,
                                    maxValue: 100,
                                    ticks: [0, 25, 50, 75, 100],
                                },
                                bar: {
                                    groupWidth: '90%'
                                },
                                legend: 'none',

                            };
                            var chart = new google.visualization.ColumnChart(document.getElementById('myChart4'));
                            chart.draw(data, options);
                        }
                        google.charts.setOnLoadCallback(drawUsageChart2);
                    </script>
                </div>
            </div>

            <!-- Google Charts Table Row -->
            <div class="row" style="background-color">
                <div id="googletable" style="width: 100%; height: auto;"></div>

                <script type="text/javascript">
                    google.charts.load('current', { packages: ['table'] });
                    google.charts.setOnLoadCallback(drawTable);

                    function drawTable() {

                        var data = new google.visualization.DataTable();

                        data.addColumn('string', 'Opening Name');
                        data.addColumn('string', 'Winner');
                        data.addColumn('string', 'Victory Status');
                        data.addColumn('number', 'White Rating');
                        data.addColumn('number', 'Black Rating');
                        data.addColumn('number', 'Moves in Opening');

                        <?php
                        try {
                            $query_everything = "SELECT * FROM chess_matches WHERE opening_name_short = '$opening1' OR opening_name_short = '$opening2'";
                            $result_everything = mysqli_query($con, $query_everything);

                            if (!$result_everything) {
                                throw new Exception("Query failed: " . mysqli_error($con));
                            }

                            while ($row = mysqli_fetch_assoc($result_everything)) {
                                echo "data.addRow(['" . addslashes($row['opening_name_short']) . "', '" . $row['winner'] . "', '" . $row['victory_status'] . "', " . (int) $row['white_rating'] . ", " . (int) $row['black_rating'] . ", " . (int) $row['opening_ply'] . "]);";
                            }
                        } catch (Exception $e) {
                            echo "console.error('Error: " . $e->getMessage() . "');";
                        }
                        ?>

                        const options = {
                            showRowNumber: true,
                            width: '100%',
                            height: '100%',
                            page: "enable",
                            pageSize: 25,
                        };

                        const table = new google.visualization.Table(document.getElementById('googletable'));
                        table.draw(data, options);
                    }
                </script>

            </div>
        </main>
    </div>

    <?php
    //mysqli_free_result($result_matches);
    mysqli_close($con);
    ?>
</body>

</html>