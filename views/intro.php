<?php

use db\ContentDb;
use db\MasteryDb;
use db\TopicDb;

error_reporting(0);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Geting Started</title>
    <link rel="stylesheet" href="./resources/css/student.css">
</head>

<body>

    <style>
        .box {
            top: 20px;
            height: 595px;
        }

        .topic-img {
            width: 530px;
            height: 400px;
            display: block;
            margin-inline: auto !important;
            /* margin: 0 auto; */
        }

        .topic {
            margin-top: 50px;
        }

        /* .topic>a {
            display: flex;
            justify-content: center;
            align-items: center;
        } */

        .ban {
            cursor: not-allowed !important;
        }
    </style>
    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>
    <div class="modules">
        <a href="./student" class="onview">DASHBOARD</a><br><br>

        <!-- Load topics -->
        <?php

        try {
            foreach (TopicDb::getAllTopics() as $topic) {
                $title = $topic->getTitle();
                $id = $topic->getId();
                echo "<a href=\"./intro?id=$id\" class=\"button\">$title</a><br><br>";
            }
        } catch (Exception  $e) {
            echo "No topics yet";
        }

        ?>
    </div>
    <div class="box">
        <div class="form">
            <div class="containers">
                <?php
                try {

                    // Initialize URL to the variable
                    $topicId = $_REQUEST['id'];

                    $count = 0;

                    foreach (ContentDb::getContent($topicId) as $content) {

                        $notBan =  MasteryDb::hasCert($topicId, $count);

                        $type = $content->getType();

                        switch ($type) {
                            case 1:
                                if ($notBan) {
                                    echo "<div class='topic'>
                                    <a href='./data?id=$topicId&index=$count' class='pictures'>
                                        <img src='./resources/images/bg/quiz.jpg' class='topic-img'>
                                    </a>
                                </div>";
                                } else {
                                    echo "<div class='topic'>
                                    <a href='' class='pictures ban'>
                                        <img src='./resources/images/bg/quiz.jpg' class='topic-img ban'>
                                    </a>
                                </div>";
                                }
                                break;
                            case 2:
                                if ($notBan) {
                                    echo "<div class='topic'>
                                    <a  href='./data?id=$topicId&index=$count' class='pictures'>
                                        <img src='./resources/images/bg/game.jpg' class='topic-img'>
                                    </a>
                                </div>";
                                } else {
                                    echo "<div class='topic'>
                                            <a  href='' class='pictures  ban'>
                                                <img src='./resources/images/bg/game.jpg' class='topic-img ban'>
                                            </a>
                                        </div>";
                                }
                                break;
                            case 3:
                                if ($notBan) {
                                    echo "<div class='topic'>
                                    <a  href='./data?id=$topicId&index=$count' class='pictures'>
                                        <img src='./resources/images/bg/handout.jpg' class='topic-img'>
                                    </a>
                                </div>";
                                } else {
                                    echo "<div class='topic'>
                                    <a  href='' class='pictures ban'>
                                        <img src='./resources/images/bg/handout.jpg' class='topic-img ban'>
                                    </a>
                                </div>";
                                }

                                break;
                            case 4:
                                if ($notBan) {
                                    echo "<div class='topic'>
                                    <a  href='./data?id=$topicId&index=$count' class='pictures'>
                                        <img src='./resources/images/bg/discussion.jpg' class='topic-img'>
                                    </a>
                                </div>";
                                } else {
                                    echo "<div class='topic'>
                                    <a  href='' class='pictures ban'>
                                        <img src='./resources/images/bg/discussion.jpg' class='topic-img ban'>
                                    </a>
                                </div>";
                                }

                                break;
                        }

                        $count++;
                    }
                } catch (Exception $error) {
                    echo "Hello";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>