<?php

require_once 'autoload.php';

use db\QuizResult;
use views\components\Modules;
use views\components\Security;

Security::studentOnlyStrict();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>My Score</title>
</head>

<body onload="load()">

    <style>
        .container {
            padding: 10px;
            height: 100%;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 9fr;
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
            padding: 10px;
            background-color: #555;
            margin-inline: 0.5em;
            border-radius: 0.5em;
            display: flex;
            gap: 2em;
            align-items: end;
            overflow: auto;
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

        .filler {
            height: 100%;
            width: 100%;
        }

        .content-right {
            padding: 6px;
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
            <div class="content-right rainbow bg-dashboard">
                <section class="filler">
                    <div class='container'>
                        <div class='lbl'>
                            <label>50</label>
                            <label>25</label>
                        </div>

                        <div class='main'>
                            <?php
                            $ids = QuizResult::getQuizIds();
                            $hasReward = false;

                            foreach ($ids as $id) {
                                $stats = QuizResult::getResult($id);
                                $quizName = QuizResult::getQuizName($id);

                                if ($stats !== NULL) {

                                    $hasReward = true;
                                    $score = (int) $stats['score'];

                                    echo "<div class='bar'>
                                                <div class='bar-value'>$score</div>
                                                <div class='bar-name'>$quizName</div>
                                          </div>";
                                }
                            }

                            echo $hasReward ? "" : "<div style='color:white;'>NO QUIZ TAKEN<div>";
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </section>
    <script>
        function load() {

            let bars = document.querySelectorAll(".bar");
            let percentage = document.querySelectorAll(".bar-value");

            bars.forEach(bar => {

                let value = bar.children[0].innerHTML;

                if (parseInt(value) > 0) {
                    bar.style.height = (value * 2) + "%";
                }
            });
        }
    </script>
</body>

</html>