<?php

namespace views\components;

use db\ContentDb;
use Exception;
use db\TopicDb;
use db\MasteryDb;

// The purpose of this class is to return all the topics
class Modules
{
    public static function getModules($topicId)
    {

        try {

            //get all the topics
            $topics = TopicDb::getAllTopics();

            //store the current topic where the user is currently working on
            $latestTopic = -1;

            //loop through all the topics
            for ($i = 0; $i <= count($topics) - 1; $i++) {

                $topic = $topics[$i];

                $title = $topic->getTitle();
                $id = $topic->getId();

                $contents = null;
                $notBan = false;
                $classlist = $id == $topicId ? "nav__link btn onview" :  "nav__link btn";

                try {
                    //get all contents  of the current topic
                    $contents = ContentDb::getContent($id);
                    //get the last content of the topic
                    $lastContent = $contents[count($contents) - 1];

                    //get the id of last content
                    $lastContentId = $lastContent->getId();

                    // //check weather the student is ban on the current topic
                    $notBan =  MasteryDb::hasCert($id, $lastContentId);


                    //update the latest topic if user is not ban 
                    $latestTopic = $notBan ? $i : $latestTopic;
                } catch (Exception $e) {
                    //no content found
                }

                if ($i == 0 && (!$notBan)) {
                }

                if ($notBan || ($latestTopic + 1) == $i) {



                    echo "<a href=\"./intro?id=$id\" class=\"$classlist\">$title</a>";
                    continue;
                }

                echo "<a href='' class=\"$classlist ban\">$title</a>";
            }
        } catch (Exception  $e) {
            echo $e->getMessage();
            // echo "<span class='content-none'>No topics yet<span>";
        }
    }
}
