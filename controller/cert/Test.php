<?php

namespace controller\cert;

class Test
{

    public static function getCert()
    {

        $jpg_image = Gold::getGold();

        // Set the content type header - in this case image/jpeg
        header('Content-Type: image/jpeg');

        // $imagePath = "assets";
        // $imageName = "test";

        // move_uploaded_file($jpg_image, $imagePath . $imageName);

        // file_put_contents("TEST.jpg", file_get_contents($jpg_image));


        // Output the image
        // imagejpeg($jpg_image);

        // Free up memory
        // imagedestroy($jpg_image);

    }
}
