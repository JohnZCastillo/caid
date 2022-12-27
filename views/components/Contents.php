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

            $nextId = NULL;

            $returnValue = "";
            $firstDescription = null;

            $descriptionCounter = 0;

            // loop through the contents of the current topic
            foreach (ContentDb::getContent($topicId) as $content) {

                $contentId = $content->getId();

                if ($descriptionCounter++ == 0) {
                    $firstDescription = $content->getDescription();
                }

                //check if user has cert on the current content
                $notBan =  MasteryDb::hasCert($topicId, $contentId);

                //get the content type of the content eg: quiz, etc..
                $type = $content->getType();

                $url = "";
                $classlist = "btn-img-l bg scale shadow blink";

                //allow for first topic 
                if ($count == 0) {
                    $notBan = true;
                }

                $contentId = $content->getId();

                //change url base on progress
                if ($notBan) {
                    $url = "./data?id=$topicId&index=$contentId";
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

            if ($firstDescription !== null) {
                $returnValue = $returnValue . "<script>var instruction = '$firstDescription'</script>";
            }

            return $returnValue;
        } catch (Exception $error) {
            throw new Exception("No Content");
        }
    }
}
