<?php

use db\QuizResult;

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="./resources/css/topics.css">
</head>

<body onload='load()'>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            height: 100vh;
            font-family: "Poppins";
            place-items: center;
        }

        .container {
            position: absolute;
            height: 80%;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 9fr;
            width: 90%;
            margin: auto;
        }

        .lbl {
            display: grid;
            text-align: right;
            font-weight: bold;
        }

        .lbl:first-child {
            margin-top: 10px;
        }

        .main {
            background-color: #555;
            margin-inline: 0.5em;
            border-radius: 0.5em;
            display: flex;
            align-items: end;
            overflow-x: auto;
            padding-top: 10px;
            padding-inline: 1em;
            gap: 2em;

        }

        .bar {
            border-radius: 0.5em 0.5em 0 0;
            width: 5em;
            background-color: aqua;
            display: grid;
            justify-content: center;

            background: rgb(94, 159, 249);
            box-shadow: 0 0 10px 0 rgb(23 192 235 / 50%);
        }

        .bar:hover {
            background: #45f3ff;
            box-shadow: 0 0 10px 0 rgb(236 241 239 / 50%);
            cursor: pointer;
        }

        .bar div {
            text-align: center;
            font-weight: bold;
            width: 5em;
            overflow-wrap: break-word;
        }

        .bar-name {
            align-self: end;
        }
    </style>

    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>
    <div class="modules">
        <a href="./student" class="button">Back</a><br><br>
    </div>
    <div class="box">
        <div class="form">
            <div class="chart">
                <div class='container'>
                    <div class='lbl'>
                        <label>100%</label>
                        <label>50%</label>
                    </div>

                    <div class='main'>
                        <?php
                        $ids = QuizResult::getQuizIds();
                        foreach ($ids as $id) {
                            $stats = QuizResult::getResult($id);

                            if ($stats !== NULL) {

                                $score = (int) $stats['score'];
                                $perfect = (int)$stats['perfect'];

                                $percent = 0;

                                if ($score > 0) {
                                    $percent = ($score / $perfect) * 100;
                                }

                                echo "<div class='bar'>
                                                <div class='bar-value'>$percent</div>
                                                <div class='bar-name'></div>
                                          </div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function load() {

            let bar = document.querySelectorAll(".bar");
            let percentage = document.querySelectorAll(".bar-value");
            let grid = document.styleSheets[0].cssRules[4];

            for (var i = 0; i < bar.length; i++) {
                bar[i].style.height = percentage[i].textContent + "%";
                percentage[i].innerHTML += "%";
            }

        }
    </script>

</body>

</html>