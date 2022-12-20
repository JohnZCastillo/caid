<?php

use db\UserDb;
use db\QuizResult;
use model\user\Role;

session_start();
error_reporting(0);

if (!isset($_SESSION["isLogin"])) {
    $_SESSION["loginError"] = "You're not login!. Login First";
    header('Location: ./login');
    exit();
}

//redirect to login page if not login
if (!$_SESSION["isLogin"]) {
    header('Location: ./login');
    exit();
}

// redirect if not admin
if ($_SESSION['userRole'] !== Role::$STUDENT) {
    header('Location: ./redirect');
}

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

if (isset($data['data'])) {

    try {
        //return profile name

        $ids = QuizResult::getQuizIds();

        $datas = [['', 'test', 'Average']];

        foreach ($ids as $id) {
            $stats = QuizResult::getResult($id);

            if ($stats !== NULL) {

                $score = (int) $stats['score'];
                $perfect = (int)$stats['perfect'];

                $percent = 0;

                if ($score > 0) {
                    $percent = ($score / $perfect) * 100;
                }
                $temp = ['', $percent, $percent];

                array_push($datas, $temp);
            }
        }

        // array_push($datas, ['', 50, 50]);
        // array_push($datas, ['', 60, 60]);
        // array_push($datas, ['', 80, 80]);
        // array_push($datas, ['', 80, 80]);
        // array_push($datas, ['', 80, 80]);

        // $datas = [
        //     ['Fruit', 'Jane', 'John', 'Average'],
        //     ['Apples', 3, 2, 2.5],
        //     ['Oranges', 2, 3, 2.5],
        //     ['Pears', 1, 5, 3],
        //     ['Bananas', 3, 9, 6],
        //     ['Plums', 4, 2, 3]
        // ];

        echo json_encode(['message' => $datas]);
        die();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Accounts</title>
    <link rel="stylesheet" href="./resources/css/admin.css">
    <link rel="stylesheet" href="./resources/css/topics.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart']
        });
    </script>
</head>

<body>

    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>
    <div class="modules">
        <a href="./student" class="button">Back</a><br><br>
    </div>
    <div class="box">
        <div class="form">
            <div id="container" style="width: 550px; height: 400px; margin: 0 auto">
            </div>
            <script language="JavaScript">
                async function drawChart() {
                    try {
                        let result = await fetch("./rewards", {
                            method: "POST",
                            headers: {
                                'Content-Type': "application/json"
                            },
                            body: JSON.stringify({
                                data: "rewards",
                            })
                        });

                        const status = result.ok;
                        result = await result.json();

                        if (!status) throw new Error(result.message);

                        var data = google.visualization.arrayToDataTable(result.message);
                        console.log(result.message);
                    } catch (error) {
                        console.log(error);
                        alert(error.message);
                    }

                    // Set chart options
                    var options = {
                        title: 'Stats',
                        vAxis: {
                            title: 'Percent',
                            viewWindow: { // <-- set view window
                                min: 0,
                                max: 100
                            }
                        },
                        hAxis: {
                            title: 'Score',
                        },
                        seriesType: 'bars',
                        series: {
                            1: {
                                type: 'line'
                            }
                        }
                    };

                    // Instantiate and draw the chart.
                    var chart = new google.visualization.ComboChart(document.getElementById('container'));
                    chart.draw(data, options);
                }
                google.charts.setOnLoadCallback(drawChart);
            </script>
        </div>
    </div>
</body>

</html>