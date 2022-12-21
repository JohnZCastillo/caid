<?php

namespace controller\cert;

session_start();

class Gold
{

    public static function generate($imageName)
    {

        // // Create Image From Existing File
        $jpg_image = imagecreatefromjpeg($imageName);

        // // Allocate A Color For The Text
        $white = imagecolorallocate($jpg_image, 37, 150, 190);

        // // Set Path to Font File
        $font_path = 'font.ttf';

        // $name_text = trim($_SESSION['userName']);

        $name_text = "Anne Pauline Castillo";

        $offset = (int) (strlen($name_text) / 2) * 46;

        $position = (1000 - $offset);

        // //start - 350
        // //end = 1550

        imagettftext($jpg_image, 100, 0, $position, 830, $white, $font_path, $name_text);

        return $jpg_image;
    }

    public static function getGold()
    {
        return Gold::generate('certificate.jpg');
    }
}
