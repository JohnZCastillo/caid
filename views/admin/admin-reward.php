<?php

require_once 'autoload.php';

use controller\cert\Certificate;
use db\QuizResult;
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
            align-items: center;
            padding: 10px;
            gap: 10px;
            overflow-x: auto;
        }

        .filler {
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

                            $hasReward = null;

                            foreach ($students as $student) {
                                $studentId = $student->getId();
                                $name = $student->getFullName();

                                foreach ($ids as $id) {


                                    $stats = QuizResult::getResultByStudent($id, $studentId);
                                    // $name = $id->getTitle();

                                    if ($stats !== NULL) {

                                        $score = (int) $stats['score'];
                                        $perfect = (int)$stats['perfect'];

                                        echo $score >= 30 ? "<div><div class='student-name'>$name</div><div class='cert-holder'>" : "";

                                        $hasReward = $score >= 30 && $hasReward === null ?  true : false;

                                        if ($score >= 30 && $score <= 35) {
                                            $name =  Certificate::getBronze("bronze", $name);
                                            $path = $location . $name;
                                            echo "<a href='$path'><img src='$path' class='cert'></a>";
                                            echo "<img src='./resources/cert/bronzeMedal.jpg' class='cert'>";
                                        } else if ($score >= 40 && $score <= 45) {
                                            $name =  Certificate::getSilver("silver", $name);
                                            $path = $location . $name;
                                            echo "<a href='$path'><img src='$path' class='cert'></a>";
                                            echo "<img src='./resources/cert/silverMedal.jpg' class='cert'>";
                                        } else if ($score == 50) {
                                            $name =  Certificate::getGold("gold", $name);
                                            $path = $location . $name;
                                            echo "<a href='$path'><img src='$path' class='cert'></a>";
                                            echo "<img src='./resources/cert/goldMedal.jpg' class='cert'>";
                                        }
                                        echo $score >= 30 ? "</div></div>" : "";
                                    }
                                }
                            }

                            if (!$hasReward) {
                                echo "<div>No Rewards Yet</div>";
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