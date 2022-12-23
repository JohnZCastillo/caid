<?php

require_once 'autoload.php';

use db\ContentDb;
use db\MasteryDb;
use db\QuestionDb;
use views\components\Modules;
use views\components\TopicBg;

// Initialize URL to the variable
$topicId = $_REQUEST['id'];
$index = $_REQUEST['index'];

$nextTopic = NULL;

if (isset($_REQUEST['next'])) {
    $nextTopic = $_REQUEST['next'];
}

$content = ContentDb::getContent($topicId);

$data = $content[$index];

$type = $data->getType();
$dataValue = $data->getData();
$payload = array_pop($dataValue);

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
        .content-left {
            display: flex;
            flex-direction: column;
        }

        .next-topic {
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
            padding: 20px;
        }

        .img-btn-sm {
            border-radius: 10px;
        }

        .content-right {
            padding: 6px;
        }

        .filler {
            height: 100%;
        }
    </style>
    <section class="main-wrapper bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./student" class="nav__link btn">Back</a>
                </nav>
                <div class="next-topic">
                    <?php
                    try {

                        if (!((count($content) - 1) == $index)) {

                            $nextIndex = $index + 1;
                            MasteryDb::register($topicId, $nextIndex);
                            $nextContent = ContentDb::getContent($topicId);

                            $nextType = $nextContent[$nextIndex]->getType();

                            $iconId = TopicBg::getTopicBackground($nextType);

                            $iconId = $iconId . " bg img-btn-sm";

                            $icon = "<a href='./data?id=$topicId&index=$nextIndex&next=$nextTopic' class='$iconId'></a>";

                            if ($nextTopic !== NULL) {
                                echo $icon;
                            } else {
                                echo "<a href='./data?id=$topicId&index=$nextIndex' class='$iconId'></a>";
                            }
                        } else {
                            //register next topic 
                            if ($nextTopic !== NULL) {
                                MasteryDb::register($nextTopic, 0);
                            }
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </div>
            </div>
            <div class="content-right rainbow bg-dashboard">
                <section class="filler">
                    <?php
                    try {
                        MasteryDb::register($topicId, $index);

                        switch ($type) {
                            case 1:
                                echo "<object data='\CAIDSA\Student_Module\topic-1\1.1-Getting-Started.pdf' width='100%' height='100%'>";
                                break;
                            case 2:
                                $id = $data->getId();
                                $quizId = QuestionDb::getQuizId($id);
                                echo "<iframe src='./quiz-shower?id=$quizId' width='100%' height='100%'></iframe>";
                                break;
                            case 3:
                                $location = $payload->getLocation();
                                echo "<object data='./assets/file/$location' width='100%' height='100%'>";
                                break;
                            case 4:
                                $location = $payload->getLocation();
                                echo "<object data='./assets/video/$location' width='100%' height='100%'>";
                                break;
                            case 5:
                                $location = $payload->getLocation();
                                echo "<object data='./assets/discussion/$location' width='100%' height='100%'>";
                                break;
                        }
                    } catch (Exception $error) {
                        echo $error->getMessage();
                    }
                    ?>
                </section>

            </div>
        </section>
    </section>
</body>

</html>