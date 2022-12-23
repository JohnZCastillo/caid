<?php

require_once 'autoload.php';

use controller\cert\Certificate;
use db\QuizResult;

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
                    <?php
                    try {
                        $ids = QuizResult::getQuizIds();
                        $location = "./assets/cert/";

                        foreach ($ids as $id) {
                            $stats = QuizResult::getResult($id);
                            // $name = $id->getTitle();

                            if ($stats !== NULL) {

                                $score = (int) $stats['score'];
                                $perfect = (int)$stats['perfect'];

                                if ($score >= 30 && $score <= 35) {
                                    $name =  Certificate::getBronze("yawa");
                                    $path = $location . $name;
                                    echo "<a href='$path'><img src='$path' class='cert'></a>";
                                    echo "<img src='./resources/cert/bronzeMedal.jpg' class='cert'>";
                                } else if ($score >= 40 && $score <= 45) {
                                    $name =  Certificate::getSilver("yawa");
                                    $path = $location . $name;
                                    echo "<a href='$path'><img src='$path' class='cert'></a>";
                                    echo "<img src='./resources/cert/silverMedal.jpg' class='cert'>";
                                } else if ($score == 50) {
                                    $name =  Certificate::getGold("yawa");
                                    $path = $location . $name;
                                    echo "<a href='$path'><img src='$path' class='cert'></a>";
                                    echo "<img src='./resources/cert/goldMedal.jpg' class='cert'>";
                                }
                            }
                        }
                    } catch (Exception $e) {
                        echo "An error has occured";
                    }
                    ?>

                </section>
            </div>
        </section>
    </section>
</body>

</html>