<?php

namespace controller\cert;

session_start();

class Gold
{

    public static function generate($certificate)
    {

        // // Create Image From Existing File
        $jpg_image = imagecreatefromjpeg($certificate);

        // // Allocate A Color For The Text
        $white = imagecolorallocate($jpg_image, 37, 150, 190);

        // // Set Path to Font File
        $font_path = 'font.ttf';

        // $name_text = trim($_SESSION['userName']);

        $name_text = $_SESSION['userName'];

        $offset = (int) (strlen($name_text) / 2) * 46;

        $position = (1000 - $offset);

        // //start - 350
        // //end = 1550

        imagettftext($jpg_image, 100, 0, $position, 830, $white, $font_path, $name_text);

        $imageName = $name_text . $certificate;
        $imagePath = "assets/cert/";

        // move_uploaded_file($jpg_image, $imagePath . $imageName);
        imagejpeg($jpg_image, $imagePath . $imageName);

        // Output the image
        imagedestroy($jpg_image);

        return $imageName;
    }

    public static function getGold()
    {
        return Gold::generate('certificate.jpg');
    }
}
