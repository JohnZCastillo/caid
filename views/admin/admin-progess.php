<?php

require_once 'autoload.php';

use db\UserDb;
use db\TopicDb;
use db\MasteryDb;
use views\components\Security;

Security::adminOnlyStrict();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Test Layout</title>
</head>

<body onload="load()">

    <style>
        .border {
            height: 200px;
            width: 200px;
            border-radius: 50%;
            border: 10px solid rgb(46, 151, 255);
            box-shadow: 0 0 10px 0.5em rgba(255, 247, 86, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main {
            background-color: rgb(8, 8, 116);
            border-radius: 50%;
            height: 90%;
            width: 90%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main label {
            font-size: 2rem;
            font-weight: bold;
            font-family: "poppins";
            color: white;
        }

        .student {
            padding: 20px;
            width: 100%;
            border-radius: 10px;
            box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
            background-color: white;
        }

        .student-progress {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            width: 100%;
            padding: 20px;
        }

        .progress {
            width: max-content;
            max-width: 200px;
            text-align: center;
            padding: 10px;
            cursor: pointer;
            margin: 0 auto;
        }

        .progress-title {
            display: block;
            padding: 10px;
            max-width: 20ch;
            word-wrap: break-word;
        }

        .content-right {
            padding: 6px;
        }

        .filler {
            padding: 50px;
            height: 100%;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;

            overflow-y: auto;

        }
    </style>
    <section class="main-wrapper bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./admin" class="nav__link btn">Back</a>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="filler bg bg-dashboard">
                    <?php
                    try {

                        $topics = TopicDb::getAllTopics();
                        foreach (UserDb::getUsers() as $user) {

                            if ($user->getRole() == 'ADMIN') {
                                continue;
                            }

                            $studentId = $user->getId();
                            $studentName = $user->getFullName();

                            echo "<div class='student'>$studentName <div class='student-progress'>";
                            foreach ($topics as $topic) {
                                $title = $topic->getTitle();
                                $id = $topic->getId();
                                $percent = MasteryDb::getStudentPercent($id, $studentId);

                                //format decimal when percent is not whole number eg 33.3333
                                if (strpos($percent, ".")) {
                                    $percent = number_format($percent, 2);
                                }

                                echo "<div class='progress scale'> 
                                    <span class='progress-title'>$title</span>
                                        <div class='border'>
                                            <div class='main'>
                                            <label class='value'>$percent</label>
                                            </div>
                                        </div>
                                    </div>";
                            }
                            echo "</div></div>";
                        }
                    } catch (Exception  $e) {
                        echo $e->getMessage();
                    }
                    ?>
                </section>
            </div>
        </section>
    </section>
    <script>
        function load() {

            let value = document.querySelectorAll(".value");
            let border = document.querySelectorAll(".border");

            value.forEach((currentValue, index) => {

                let maxValue = currentValue.textContent;

                let progress = 0;

                console.log(maxValue);

                let interval = setInterval(() => {

                    if (maxValue === 0) {
                        clearInterval(interval);
                    }

                    border[index].style.background = `conic-gradient(rgba(255, 247, 86, 0.5) ${progress * 3.6}deg,grey  ${progress * 3.6}deg)`;
                    currentValue.textContent = progress + "%";

                    if (progress >= maxValue) {
                        clearInterval(interval);
                    }

                    progress++;


                }, 20)


            });

        }
    </script>
</body>

</html>