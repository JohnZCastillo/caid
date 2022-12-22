<?php

namespace views\components;

/*
    The purpose of thic class is to return a 'CSS Class' that has
    a background image base on the type of topic (game,quiz, etc...). 
    
    Note: The css
        type = game | css = background-image: url(...game);
    
*/

class TopicBg
{
    public static function getTopicBackground($type)
    {
        //check the type of content to render it properly
        switch ($type) {
            case 1:
                return "bg-game";
                break;
            case 2:
                return "bg-quiz";
                break;
            case 3:
                return "bg-handout";
                break;
            case 4:
                return "bg-animated";
                break;
            case 5:
                return "bg-discussion";
                break;
        }
    }
}
