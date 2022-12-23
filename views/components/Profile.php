<?php

namespace views\components;

error_reporting(0);

session_start();


class Profile
{
    public static function getProfile()
    {

        $image = "";

        //show default profile
        if (!isset($_SESSION['userProfile'])) {
            $image =  "<img src='./assets/profile/default.png' id='photo'>";
        } else {
            $profile = $_SESSION['userProfile'];
            $image = "<img src='./assets/profile/$profile' id='photo'>";
        }

        echo   " <div class='profile-pic-div'>
                    $image
                    <input type='file' id='file' class='hide'>
                    <label for='file' id='uploadBtn'>Choose</label>
                </div>";
    }
}
