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
            $count = 0;

            foreach (TopicDb::getAllTopics() as $topic) {


                $title = $topic->getTitle();
                $id = $topic->getId();

                $notBan =  MasteryDb::hasCert($id, 0);

                if ($notBan) {
                    echo "<a href=\"./intro?id=$id\" class=\"button\">$title</a><br><br>";
                } else {
                    if ($count == 0) {
                        echo "<a href=\"./intro?id=$id\" class=\"button\">$title</a><br><br>";
                    } else {
                        echo "<a href='' class=\"button ban\">$title</a><br><br>";
                    }
                }

                $count++;
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

                    $topics = TopicDb::getAllTopics();

                    $index = 0;


                    foreach (ContentDb::getContent($topicId) as $content) {

                        $index++;

                        $notBan =  MasteryDb::hasCert($topicId, $count);

                        $type = $content->getType();

                        //allow for first topic 
                        if ($count == 0) {
                            $notBan = true;
                        }

                        $nextId = $topics[$index]->getId();


                        switch ($type) {
                            case 1:
                                if ($notBan) {
                                    echo "<div class='topic'>
                                    <a href='./data?id=$topicId&index=$count&next=$nextId' class='pictures'>
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
                                    <a  href='./data?id=$topicId&index=$count&next=$nextId' class='pictures'>
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
                                    <a  href='./data?id=$topicId&index=$count&next=$nextId' class='pictures'>
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
                                    <a  href='./data?id=$topicId&index=$count&next=$nextId' class='pictures'>
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