<?php

require_once 'autoload.php';

use db\UserDb;
use db\TopicDb;
use db\MasteryDb;
use db\QuizResult;
use controller\cert\Certificate;

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
            padding: 10px;
            gap: 10px;
            overflow-x: auto;
        }

        .filler {
            padding-block: 10px;
            display: grid;
            grid-template-columns: 1fr;
            justify-content: center;
            gap: 20px;
        }

        .student-name {
            align-self: flex-start;
            padding: 10px;
            font-weight: bold;
        }

        .scroll {
            overflow-y: scroll;
            height: 100%;
        }

        .student {
            width: 90%;
            margin-inline: auto;
            border-radius: 10px;
            display: grid;
            grid-template-columns: 1fr;
            min-height: 300px;
            padding: 10px;
            background-color: blue;
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
            <div class="content-right rainbow">
                <div class="scroll">

                    <section class="filler">
                        <?php
                        try {

                            $ids = QuizResult::getQuizIds();
                            $students = UserDb::getStudents();
                            $location = "./assets/cert/";
                            $topics = TopicDb::getAllTopics();

                            $hasReward = null;
                            $maxPercent = (int)count($topics) * 100;

                            foreach ($students as $student) {


                                $studentId = $student->getId();
                                $name = $student->getFullName();

                                echo "<div class='student'><div class='student-name'> $name</div>";

                                $meron = false;

                                foreach ($ids as $id) {
                                    $quizName = QuizResult::getQuizName($id);
                                    $stats = QuizResult::getResultByStudent($id, $studentId);

                                    if ($stats !== NULL) {

                                        $meron = true;

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
                                        } else {
                                            $meron = false;
                                        }
                                        echo $score >= 30 ? "</div>" : "";
                                    } else {
                                        $meron = false;
                                    }
                                }

                                $myPercent = (int)0;

                                foreach ($topics as $topic) {
                                    $id = $topic->getId();
                                    $percent = MasteryDb::getStudentPercent($id, $studentId);
                                    $myPercent  += $percent;
                                }

                                if ($myPercent === $maxPercent) {

                                    $meron = true;
                                    $studentName =  ucwords($studentName);

                                    $certName = $studentName . ".jpg";

                                    if (!file_exists($location . $certName)) {
                                        $certName =  Certificate::getGold("", $studentName);
                                    }

                                    $path = $location . $certName;

                                    echo "<a href='$path' class='cert-link'><img src='$path' class='cert'></a>";
                                }

                                echo $meron ? "" : "<br>no rewords yet";

                                echo "</div>";
                            }
                        } catch (Exception $e) {
                            echo "No Rewards Yet";
                        }

                        ?>
                    </section>
                </div>
            </div>
        </section>
    </section>
</body>

</html>