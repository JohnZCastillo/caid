<?php

use db\ContentDb;
use db\TopicDb;
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
    </style>
    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>
    <div class="modules">
        <a href="" class="onview">DASHBOARD</a><br><br>

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

                    foreach (ContentDb::getContent($topicId) as $content) {
                        echo "<div class='topic'>
                                <a href='/CAIDSA/Student_Module/topic-1/4.1--Handout1.1-open-h.php' class='pictures'>
                                    <img src='/CAIDSA/Photos/Handout.jpg' class='topic-img'>
                                </a>
                            </div>";
                    }
                } catch (Exception $error) {
                    echo "no content found";
                }

                ?>
            </div>
        </div>
    </div>
</body>

</html>