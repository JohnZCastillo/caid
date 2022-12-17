<?php

use db\ContentDb;
use db\TopicDb;

// Initialize URL to the variable
$topicId = $_REQUEST['id'];

try {
    foreach (ContentDb::getContent($topicId) as $content) {

        $location = $content->getLocation();
        $name = $content->getName();

        $typeName = $content->getType();

        if ($typeName == 3) {
        }

        switch ($typeName) {
            case 3:
                echo "<iframe src='./assets/file/$location' style='width:100%; height:600px;' frameborder='0'></iframe>";
                break;
            case 4:
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
