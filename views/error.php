<?php

use db\FileDb;
use db\QuestionDb;
use db\QuizResult;
use controller\cert\Gold;
use controller\cert\Test;
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

// try {
//     $ids = QuizResult::getQuizIds();

//     foreach ($ids as $id) {
//         $stats = QuizResult::getResult($id);

//         if ($stats !== NULL) {

//             $score = (int) $stats['score'];
//             $perfect = (int)$stats['perfect'];

//             if ($score >= 30 && $score <= 35) {
//                 echo "bronze";
//             } else if ($score >= 40 && $score <= 45) {
//                 echo "Silver";
//             } else if ($score == 50) {
//                 echo "gold";
//             } else {
//                 $location =  Gold::getGold();
//                 echo "<img src='./assets/cert/$location'>";
//             }
//         }
//     }
// } catch (Exception $e) {
//     echo "An error has occured";
// }

// echo "Not found!";

// $jpg_image = Gold::getGold();

// // $jpg_image = imagecreatefromjpeg($im);
// // file_put_contents($output, file_get_contents($input));

// // $im = Gold::getGold();
// // Set the content type header - in this case image/jpeg
// header('Content-Type: image/jpeg');

// // Output the image
// imagejpeg($jpg_image);

// // Free up memory
// imagedestroy($jpg_image);
?>
<!-- <iframe src="./assets/game/game1/index.html" frameborder="0" width="500px" height="500px"></iframe> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Topics</title>
</head>

<body onload="load">

    <style>
        .dialog {

            position: relative;
            top: 20%;
            left: 50%;
            transform: translate(-50%, 0);
            width: 80vw;
            max-width: 800px;
            border-radius: 100px;
            padding-inline: 50px;
            padding-block: 20px;
            display: grid;
            grid-template-columns: 1fr;
            background-color: palegoldenrod;
        }

        .dialog__content {
            display: flex;
            align-items: center;
        }

        .dialog-img {
            width: 300px;
            height: auto;
        }

        .btn-ok {
            max-width: max-content;
            margin-left: auto;
            padding: 10px 20px;
            border-radius: 10px;
            background-color: var(--color-yellow);
            cursor: pointer;
        }

        .wizard-show {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            width: 100vw;
            height: 100vh;
            background-color: var(--color-yellow);
            backdrop-filter: blur(15px);
            opacity: .6;
        }

        .hide {
            display: none;
        }

        /* .dialog-msg {
            height: 20px;
        } */
    </style>
    <div class="wizard-show wizard hide">
        <section class="dialog">
            <section class="dialog__content">
                <img class="dialog-img" src="./assets/profile/default.png" alt="" srcset="">
                <p class="dialog-msg">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, officiis?</p>
            </section>
            <button class="btn-ok">Okay</button>
        </section>
    </div>

    <button>Hello World</button>
    <script>
        const wizard = document.querySelector('.wizard');
        const okBtn = document.querySelector('.btn-ok');

        okBtn.addEventListener('click', () => {
            wizard.classList.add('hide');
        })

        window.onclick = function(event) {
            if (event.target != okBtn) {
                event.preventDefault();
            }
        }

        const showWizard = () => {
            wizard.classList.remove('hide');
        }
    </script>
</body>

</html>