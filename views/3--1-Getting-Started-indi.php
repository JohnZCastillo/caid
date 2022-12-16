<?php

use db\TopicDb;
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Geting Started</title>
    <link rel="stylesheet" href="./resources/css/student.css">
</head>

<body>
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
                echo "<a href=\"./topic?id=$id\" class=\"button\">$title</a><br><br>";
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


                // Initialize URL to the variable
                $topicId = $_REQUEST['id'];

                try {
                    foreach (TopicDb::getContent($topicId) as $content) {

                        $location = $content->getLocation();
                        $name = $content->getName();
                        $typeName = $content->getTypeName();

                        switch ($typeName) {
                            case "FILE":
                                echo "<iframe src='./assets/file/$location' style='width:100%; height:600px;' frameborder='0'></iframe>";
                                break;
                            case "VIDEO":
                                echo "<video width='320' height='240' controls>
                        <source src='./assets/video/$location' type='video/mp4'>
                        Your browser does not support the video tag.
                    </video>";
                                break;
                        }
                    }
                } catch (Exception $error) {
                    echo "no content found";
                }
                ?>
                <div class="container1-indi">
                    <a href="/CAIDSA/Student_Module/topic-1/4.1--Handout1.1-open-h.php" class="pictures">
                        <img src="/CAIDSA/Photos/Handout.jpg" width="180px" height="180px"></a>
                </div>
                <div class="content2"></div>
                <div class="container2">
                    <a href="/CAIDSA/Student_Module/topic-1/Animated-Presentation1.1-open-h.php" class="pictures">
                        <img src="/CAIDSA/Photos/Animated-Presentation.jpg" width="180px" height="180px"></a>
                </div>
                <div class="content3"></div>
                <div class="container3">
                    <a href="/CAIDSA/Student_Module/topic-1/Quiz1.1-open-h.php" class="pictures">
                        <img src="/CAIDSA/Photos/Quiz.jpg" width="180px" height="180px"></a>
                </div>
                <div class="content4"></div>
                <div class="container4">
                    <a href="/CAIDSA/Student_Module/topic-1/Practical-Discussion1.1-open-h.php" class="pictures">
                        <img src="/CAIDSA/Photos/Practical-Discussion.jpg" width="180px" height="180px"></a>
                </div>
                <div class="content5"></div>
                <div class="container5">
                    <a href="/CAIDSA/Student_Module/topic-1/Game1.1-open-h.php" class="pictures">
                        <img src="/CAIDSA/Photos/Game.jpg" width="180px" height="180px"></a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>