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

        .ban {
            cursor: not-allowed !important;
            background-color: white;
            opacity: .6;

        }

        .topic-ban {
            cursor: not-allowed !important;
            filter: brightness(30%);
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
                    $nextId = NULL;
                    $first = false;

                    for ($i = 0; $i <= count($topics) - 1; $i++) {
                        if ($topics[$i]->getId() == $topicId && $i <  (count($topics) - 1)) {
                            $nextId = $topics[$i + 1]->getId();
                            // $first = $i === 0 ? TRUE : FALSE;
                        }
                    }

                    foreach (ContentDb::getContent($topicId) as $content) {

                        $notBan =  MasteryDb::hasCert($topicId, $count);

                        $type = $content->getType();

                        $url = "";
                        $classlist = "topic-img";

                        //allow for first topic 
                        if ($count == 0) {
                            $notBan = true;
                        }

                        //chnage url base on progress
                        if ($notBan && $nextId !== NULL) {
                            $url = "./data?id=$topicId&index=$count&next=$nextId";
                        } else if ($notBan) {
                            $url = "./data?id=$topicId&index=$count";
                        } else {
                            $url = "";
                            $classlist = "topic-img topic-ban";
                        }

                        //check the type of content to render is properly
                        switch ($type) {
                            case 1:
                                echo "<div class='topic'>
                                        <a href='$url' class='pictures'>
                                            <img src='./resources/images/bg/game.jpg' class='$classlist'>
                                        </a>
                                    </div>";
                                break;
                            case 2:
                                echo "<div class='topic'>
                                            <a  href='$url' class='pictures'>
                                                <img src='./resources/images/bg/quiz.jpg' class='$classlist'>
                                            </a>
                                        </div>";
                                break;
                            case 3:
                                echo "<div class='topic'>
                                        <a  href='$url' class='pictures'>
                                            <img src='./resources/images/bg/handout.jpg' class='$classlist'>
                                        </a>
                                    </div>";
                                break;
                            case 4:
                                echo "<div class='topic'>
                                        <a  href='$url' class='pictures'>
                                            <img src='./resources/images/bg/discussion.jpg' class='$classlist'>
                                        </a>
                                    </div>";
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