<?php

use db\TopicDb;

// Initialize URL to the variable
$topicId = $_REQUEST['id'];

try {
    foreach (TopicDb::getContent($topicId) as $content) {

        $location = $content->getLocation();
        $name = $content->getName();
        echo "<iframe src='./assets/file/$location' style='width:100%; height:600px;' frameborder='0'></iframe>";
    }
} catch (Exception $error) {
    echo "no content found";
}
