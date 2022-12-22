<?php

namespace views\components;

use Exception;
use db\TopicDb;
use db\ContentDb;
use db\MasteryDb;


class Contents
{

    public static function getContents($topicId)
    {
        try {

            $count = 0;

            $topics = TopicDb::getAllTopics();
            $nextId = NULL;

            $returnValue = "";

            // Get the next content after the current content
            for ($i = 0; $i <= count($topics) - 1; $i++) {
                if ($topics[$i]->getId() == $topicId && $i <  (count($topics) - 1)) {
                    $nextId = $topics[$i + 1]->getId();
                }
            }

            // loop through the contents of the current topic
            foreach (ContentDb::getContent($topicId) as $content) {

                //check if user has cert on the current content
                $notBan =  MasteryDb::hasCert($topicId, $count);

                //get the content type of the content eg: quiz, etc..
                $type = $content->getType();

                $url = "";
                $classlist = "btn-img-l bg scale shadow";

                //allow for first topic 
                if ($count == 0) {
                    $notBan = true;
                }

                //change url base on progress
                if ($notBan && $nextId !== NULL) {
                    $url = "./data?id=$topicId&index=$count&next=$nextId";
                } else if ($notBan) {
                    $url = "./data?id=$topicId&index=$count";
                } else {
                    $url = "";
                    $classlist = "btn-img-l bg ban scale shadow";
                }

                $topicBg = TopicBg::getTopicBackground($type);

                $classlist = $topicBg . " " . $classlist;

                $currentContent = "<a href='$url' class='$classlist'></a>";

                $returnValue = $returnValue . $currentContent;

                $count++;
            }

            return $returnValue;
        } catch (Exception $error) {
            throw new Exception("No Content");
        }
    }
}
