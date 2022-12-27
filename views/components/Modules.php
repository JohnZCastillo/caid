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

            $count = -1;

            //get all the topics
            $topics = TopicDb::getAllTopics();

            //store the current topic where the user is currently working on
            $latestTopic = null;

            //loop through all the topics
            foreach ($topics as $topic) {

                $count++;

                $title = $topic->getTitle();
                $id = $topic->getId();

                //get all contents  of the current topic
                $contents = ContentDb::getContent($id);

                //get the last content of the topic
                $lastContent = $contents[count($contents) - 1];

                //get the id of the last content
                $lastContentId = $lastContent->getId();

                //check weather the student is ban on the current topic
                $notBan =  MasteryDb::hasCert($id, $lastContent);

                //update the latest topic if user is not ban 
                if ($notBan) {
                    $latestTopic = $id;
                }

                $classlist = $id == $topicId ? "nav__link btn onview" :  "nav__link btn";

                if ($notBan || $count == 0) {
                    echo "<a href=\"./intro?id=$id\" class=\"$classlist\">$title</a>";
                    continue;
                }

                echo "<a href='' class=\"$classlist ban\">$title</a>";
            }
        } catch (Exception  $e) {
            echo "<span class='content-none'>No topics yet<span>";
        }
    }
}
