<?php

require_once 'autoload.php';

use db\UserDb;
use db\QuizResult;
use views\components\Security;

Security::adminOnlyStrict();

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

if (isset($data['data'])) {

    try {

        $ids = QuizResult::getQuizIds();
        $users = UserDb::getStudents();

        $allData = [];

        foreach ($users as $user) {

            $name = $user->getFullName();

            $datas = [[$name, 'Score', 'Average']];
            $userId = $user->getId();

            $score = 0;
            $perfect = 0;

            foreach ($ids as $id) {

                $stats = QuizResult::getResultByStudent($id, $userId);

                if ($stats !== NULL) {

                    $score = (int) $stats['score'];
                    $perfect = (int)$stats['perfect'];

                    $percent = 0;

                    if ($score > 0) {
                        $percent = ($score / $perfect) * 100;
                    }

                    $quizName = QuizResult::getQuizName($id);

                    $temp = [$quizName, $percent, $percent];

                    array_push($datas, $temp);
                } else {
                    array_push($datas, ['', 0, 0]);
                }
            }

            array_push($allData, $datas);
        }

        echo json_encode(['message' => $allData]);
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
        }

        .filler {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            overflow-y: auto;
            padding-block: 10px;
        }

        .container {
            flex-shrink: 0;
            width: 90%;
            height: 90%;
            background-color: white;
        }
    </style>
    <section class="main-wrapper bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./admin" class="nav__link btn">Back</a>
                </nav>
            </div>
            <div class="content-right rainbow bg bg-dashboard">
                <section class="filler ">
                    <!-- Google Charts here -->
                </section>
            </div>
        </section>
    </section>
    <script language="JavaScript">
        const filler = document.querySelector('.filler');
        let data = [];

        // Set chart options
        const options = {
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

        const addData = (id, data) => {
            let div = document.createElement('div');
            div.setAttribute('id', id);
            div.setAttribute('class', "container");
            filler.appendChild(div);
            options.title = (data[0])[0];
            let chart = new google.visualization.ComboChart(div);
            let value = google.visualization.arrayToDataTable(data);
            chart.draw(value, options);

        }

        const test = async () => {
            try {
                let result = await fetch("./admin-stats", {
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

                data = result.message;

                data.forEach((stats, index) => {
                    if (stats.length === 1) {
                        stats = [
                            stats[0],
                            ['', 0, 0]
                        ]
                    }
                    console.log(stats);
                    addData(index, stats);
                })

            } catch (error) {
                console.log(error);
                alert(error.message);
            }
        };

        // google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(test);
    </script>
</body>

</html>