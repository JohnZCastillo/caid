<?php

require_once 'autoload.php';

use db\TopicDb;
use db\MasteryDb;
use db\QuizResult;
use controller\cert\Certificate;
use db\UserDb;

error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Test Layout</title>
</head>

<body>

    <style>
        .content-right {
            padding: 6px;
            background-color: white;
        }

        .cert-holder {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            gap: 10px
        }

        .filler {
            display: grid;
            grid-template-columns: 1fr;
            justify-content: center;
            gap: 20px;
        }

        .scroll {
            overflow-y: scroll;
            height: 100%;
        }

        .cert {
            display: block;
            margin-inline: auto;
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
                <div class="scroll">

                    <section class="filler">
                        <?php
                        try {
                            $ids = QuizResult::getQuizIds();
                            $location = "./assets/cert/";
                            $studentName = $_SESSION['userName'];

                            $hasReward = null;

                            foreach ($ids as $id) {
                                $stats = QuizResult::getResult($id);
                                $quizName = QuizResult::getQuizName($id);

                                if ($stats !== NULL) {

                                    $score = (int) $stats['score'];

                                    echo $score >= 30 ? "<div class='cert-holder'>" : "";

                                    $hasReward = $score >= 30 && $hasReward === null ?  true : false;

                                    if ($score >= 30 && $score <= 35) {
                                        echo "<span>$quizName</span>";
                                        echo "<img src='./resources/cert/bronzeMedal.jpg' class='cert'>";
                                    } else if ($score >= 40 && $score <= 45) {
                                        echo "<span>$quizName</span>";
                                        echo "<img src='./resources/cert/silverMedal.jpg' class='cert'>";
                                    } else if ($score == 50) {
                                        echo "<span>$quizName</span>";
                                        echo "<img src='./resources/cert/goldMedal.jpg' class='cert'>";
                                    }
                                    echo $score >= 30 ? "</div>" : "";
                                }
                            }

                            if (!$hasReward) {
                                echo "<div>None Medals to display</div>";
                            }

                            $topics = TopicDb::getAllTopics();

                            $maxPercent = (int)count($topics) * 100;
                            $myPercent = (int)0;

                            foreach ($topics as $topic) {
                                $id = $topic->getId();
                                $percent = MasteryDb::getPercent($id);

                                $myPercent  += $percent;
                            }

                            if ($myPercent === $maxPercent) {

                                $studentName =  ucwords($studentName);

                                $certName = $studentName . ".jpg";

                                if (!file_exists($location . $certName)) {
                                    $certName =  Certificate::getGold("", $studentName);
                                }

                                $path = $location . $certName;

                                echo "<a href='$path' class='cert-link'><img src='$path' class='cert'></a>";
                            }
                        } catch (Exception $e) {
                            echo "An error has occured";
                        }
                        ?>
                    </section>
                </div>
            </div>
        </section>
    </section>
</body>

</html>