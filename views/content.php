<?php

use db\TopicDb;

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
