<?php

use db\ContentDb;

// Initialize URL to the variable
$topicId = $_REQUEST['id'];
$index = $_REQUEST['index'];

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
    <title>Data</title>
</head>

<body>
    <header class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </header>
    <div class="modules">

        <?php
        echo "<a href='./intro?id=$topicId' class='button'>Back</a><br><br>";

        if (!((count($content) - 1) == $index)) {
            $nextIndex = $index + 1;
            echo "<a href='./data?id=$topicId&index=$nextIndex' id='ap1'></a><br><br>";
        }

        ?>
    </div>
    <div class="box">
        <div class="form">

            <?php
            try {
                switch ($type) {
                    case 1:
                        echo "<div id='handout'>
                                <object data='\CAIDSA\Student_Module\topic-1\1.1-Getting-Started.pdf' width='725' height='570'>
                            </div>";
                        break;
                    case 2:
                        echo "<div id='handout'>
                                <object data='\CAIDSA\Student_Module\topic-1\1.1-Getting-Started.pdf' width='725' height='570'>
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
                echo "no content found";
            }
            ?>
        </div>
    </div>
</body>

</html>