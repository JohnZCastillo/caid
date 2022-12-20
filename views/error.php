<?php

use db\FileDb;
use db\QuestionDb;
use db\QuizResult;
use model\module\Content;

// echo " File not found !";

// Set the Content Type
// header('Content-type: image/jpg');

// // Create Image From Existing File
// $jpg_image = imagecreatefromjpeg('certificate.jpg');

// // Allocate A Color For The Text
// $white = imagecolorallocate($jpg_image, 37, 150, 190);

// // Set Path to Font File
// $font_path = 'font.ttf';

// $name_text = "Cecille Marie Samorillo";

// $offset = (int) (strlen($name_text) / 2) * 46;

// $position = (1000 - $offset);

// //start - 350
// //end = 1550

// imagettftext($jpg_image, 100, 0, $position, 800, $white, $font_path, $name_text);

// // Send Image to Browser
// imagejpeg($jpg_image);

// // Clear Memory
// imagedestroy($jpg_image);

try {

    $ids = QuizResult::getQuizIds();

    foreach ($ids as $id) {
        $stats = QuizResult::getResult($id);

        if ($stats !== NULL) {


            $score = (int) $stats['score'];
            $perfect = (int)$stats['perfect'];

            echo "<div>";

            if ($score >= 30 && $score <= 35) {
                echo "bronze";
            } else if ($score >= 40 && $score <= 45) {
                echo "Silver";
            } else if ($score == 50) {
                echo "gold";
            } else {
                echo "no reward";
            }
            echo "</div>";
        }
    }
} catch (Exception $e) {
    echo "An error has occured";
}

echo "Not found!";
