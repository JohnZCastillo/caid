<?php

use db\ContentDb;
use db\MasteryDb;
use db\QuestionDb;
use model\module\Content;
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
    <link rel="stylesheet" href="./resources/css/data.css">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Data</title>
</head>

<body>
    <header class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </header>
    <div class="modules">

        <?php

        echo "<a href='./intro?id=$topicId' class='button'>Back</a><br><br>";

        try {

            if (!((count($content) - 1) == $index)) {

                $nextIndex = $index + 1;
                MasteryDb::register($topicId, $nextIndex);
                $nextContent = ContentDb::getContent($topicId);

                $nextType = $nextContent[$nextIndex]->getType();

                $iconId = TopicBg::getTopicBackground($nextType);

                $iconId = $iconId . " bg img-btn-sm";

                $icon = "<a href='./data?id=$topicId&index=$nextIndex&next=$nextTopic' class='$iconId'></a><br><br>";

                if ($nextTopic !== NULL) {
                    echo $icon;
                } else {
                    echo "<a href='./data?id=$topicId&index=$nextIndex' class='$iconId'></a><br><br>";
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
    <div class="box">
        <div class="form">

            <?php
            try {
                MasteryDb::register($topicId, $index);

                switch ($type) {
                    case 1:
                        echo "<div id='handout'>
                            <object data='\CAIDSA\Student_Module\topic-1\1.1-Getting-Started.pdf' width='725' height='570'>
                          </div>";
                        break;
                    case 2:
                        $id = $data->getId();
                        $quizId = QuestionDb::getQuizId($id);
                        echo "<div id='handout' style='height:100%'>
                                    <iframe src='http://localhost/caid/quiz-shower?id=$quizId' width='100%' height='100%'></iframe>
                            </div>";
                        break;
                    case 3:
                        $location = $payload->getLocation();
                        echo "<div id='handout'>
                                <object data='./assets/file/$location' width='725' height='570'>
                            </div>";
                        break;
                    case 4:
                        $location = $payload->getLocation();
                        echo "<div id='handout'>
                        <object data='./assets/video/$location' width='725' height='570'>
                            </div>";
                        break;
                }
            } catch (Exception $error) {
                echo $error->getMessage();
            }
            ?>
        </div>
    </div>
</body>

</html>