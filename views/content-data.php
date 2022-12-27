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


if (isset($_REQUEST['next'])) {
    $nextTopic = $_REQUEST['next'];
}

$data = ContentDb::getContentById($topicId, $index);

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
    <title>Topics</title>
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
                    <a href="./intro?id=<?php echo $topicId ?>" class="nav__link btn">Back</a>
                </nav>
                <div class="next-topic">
                    <?php
                    try {

                        $nextContentId = MasteryDb::getNextStepId($topicId, $index);

                        if ($nextContentId != $index) {

                            $nextContent = ContentDb::getContentById($topicId, $nextContentId);

                            $iconId = TopicBg::getTopicBackground($nextContent->getType());

                            $iconId = $iconId . " bg img-btn-sm";

                            echo "<a href='./data?id=$topicId&index=$nextContentId' class='$iconId'></a>";
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

                        // register to mastery if not yet registered
                        if (MasteryDb::hasCert($topicId, $index)) {
                            MasteryDb::register($topicId, $index);
                        }

                        switch ($type) {
                            case 1:
                                $location = $payload->getLocation();
                                echo "<object data='./assets/game/$location/index.html' width='100%' height='100%'>";
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