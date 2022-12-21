<?php

namespace views\components;

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

            //loop through all the topics
            foreach (TopicDb::getAllTopics() as $topic) {

                $count++;

                $title = $topic->getTitle();
                $id = $topic->getId();

                //check weather the student is ban on the current topic
                $notBan =  MasteryDb::hasCert($id, 0);

                $classlist = $id == $topicId ? "nav__link btn" :  "nav__link btn onview";

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
