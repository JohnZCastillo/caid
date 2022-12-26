<?php

require_once 'autoload.php';

use db\QuizResult;
use views\components\Modules;


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
            } else {
                array_push($datas, ['', 0, 0]);
            }
        }

        if (count($datas) <= 1) {
            $datas = [['', 'test', 'Average'], ['', 0, 0]];
        }

        echo json_encode(['message' => $datas]);
        die();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
    </script>
    <script type="text/javascript">
        google.charts.load('current', {
            packages: ['corechart']
        });
    </script>
    <title>Test Layout</title>
</head>

<body>

    <style>
        .content-right {
            padding: 6px;
            background-color: white;
        }

        .filler {
            height: 100%;
        }
    </style>
    <section class="main-wrapper bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./student" class="nav__link btn">Back</a>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="filler">
                    <div id="container" style="width: 100%; height: 100%; margin: 0 auto">
                    </div>
                    <script language="JavaScript">
                        async function drawChart() {
                            try {
                                let result = await fetch("./my-stats", {
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
                </section>
            </div>
        </section>
    </section>
</body>

</html>