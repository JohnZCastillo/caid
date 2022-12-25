<?php

namespace controller\cert;

session_start();

class Certificate
{

    // private static $path = "http://localhost/caid/resources/cert/";
    private static $path = "./resources/cert/";

    public static function generate($certificate, $topic, $type, $name_text)
    {

        // // Create Image From Existing File
        $jpg_image = imagecreatefromjpeg($certificate);

        // // Allocate A Color For The Text
        $white = imagecolorallocate($jpg_image, 37, 150, 190);

        // // Set Path to Font File
        $font_path = Certificate::$path . 'font.ttf';

        // $name_text = trim($_SESSION['userName']);

        //Uppercase first letter for every word
        $name_text = ucwords($name_text);

        $offset = (int) (strlen($name_text) / 2) * 46;

        $position = (1000 - $offset);

        // //start - 350
        // //end = 1550

        imagettftext($jpg_image, 100, 0, $position, 830, $white, $font_path, $name_text);

        $imageName = $name_text . "_"  . $topic . "_" . $type . ".jpg";

        $imagePath = "assets/cert/";

        // move_uploaded_file($jpg_image, $imagePath . $imageName);
        imagejpeg($jpg_image, $imagePath . $imageName);

        // Output the image
        imagedestroy($jpg_image);

        return $imageName;
    }

    public static function getGold($topic, $name)
    {
        return Certificate::generate(Certificate::$path . 'gold.jpg', $topic, "gold", $name);
    }

    public static function getBronze($topic, $name)
    {
        return Certificate::generate(Certificate::$path . 'bronze.jpg', $topic, "bronze", $name);
    }

    public static function getSilver($topic, $name)
    {
        return Certificate::generate(Certificate::$path . 'silver.jpg', $topic, "silver", $name);
    }
}
