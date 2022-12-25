<?php

require_once 'autoload.php';

use db\UserDb;
use db\QuizResult;
use model\user\Role;
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
        .container {
            padding: 10px;
            height: 90%;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 9fr;
        }

        .lbl {
            display: grid;
            text-align: right;
            font-weight: bold;
        }

        .lbl:first-child {
            margin-top: 10px;
        }

        .main {
            padding: 10px;
            background-color: #555;
            margin-inline: 0.5em;
            border-radius: 0.5em;
            display: flex;
            gap: 2em;
            align-items: end;

        }

        .bar {
            border-radius: 0.5em 0.5em 0 0;
            width: 5em;
            background-color: aqua;
            display: grid;
            justify-content: center;

            background: rgb(94, 159, 249);
            box-shadow: 0 0 10px 0 rgb(23 192 235 / 50%);
        }

        .bar:hover {
            background: #45f3ff;
            box-shadow: 0 0 10px 0 rgb(236 241 239 / 50%);
            cursor: pointer;
        }

        .bar div {
            text-align: center;
            font-weight: bold;
            width: 5em;
            overflow-wrap: break-word;
        }

        .bar-name {
            align-self: end;
        }

        .filler {
            height: 100%;
            width: 100%;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .content-right {
            padding: 6px;
        }

        .no-quiz {
            /* align-items: center; */
            align-self: center;
            color: white;
        }

        .container-wrapper {
            flex-shrink: 0;
            height: 100%;
            padding: 10px;
            background-color: white;
            width: 95%;
            border-radius: 10px;
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
            <div class="content-right rainbow bg-dashboard">
                <section class="filler">

                    <?php

                    $ids = QuizResult::getQuizIds();
                    $students = UserDb::getUsers();

                    foreach ($students as $student) {

                        if ($student->getRole() !== Role::$STUDENT) {
                            continue;
                        }

                        $userId = $student->getId();
                        $name = $student->getFName();

                        $hasQuiz = false;


                        echo "<div class='container-wrapper'> <span class='user-name'>$name</span>";

                        echo "<section class='container'>";
                        echo "<div class='lbl'>  
                                <label>100%</label>
                                <label>50%</label>
                         </div>";

                        echo "<div class='main'>";

                        foreach ($ids as $id) {

                            $stats = QuizResult::getResultByStudent($id, $userId);

                            if ($stats !== NULL) {

                                $hasQuiz = true;

                                $score = (int) $stats['score'];
                                $perfect = (int)$stats['perfect'];

                                $percent = 0;

                                if ($score > 0) {
                                    $percent = ($score / $perfect) * 100;
                                }

                                echo "<div class='bar'>
                                    <div class='bar-value'>$percent</div>
                                </div>";
                            }
                        }

                        echo $hasQuiz ? "" : "<div class='no-quiz'>Student Have not taken any quiz yet</div>";

                        echo "</div></section></div>";
                    }
                    ?>
                </section>
            </div>
        </section>
    </section>
    <script>
        function load() {

            let bars = document.querySelectorAll(".bar");
            let percentage = document.querySelectorAll(".bar-value");

            bars.forEach(bar => {

                let value = bar.children[0].innerHTML;

                if (parseInt(value) > 0) {
                    bar.style.height = value + "%";
                }
            });
        }
    </script>
</body>

</html>