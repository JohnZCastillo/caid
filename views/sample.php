<?php

require_once 'autoload.php';

use views\components\Modules;

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

<body>
    <style>
        .content-right {
            display: flex;
            flex-direction: column;
            gap: 10px;
            border-radius: 0;
            background-color: transparent !important;
        }

        .bio {
            flex-basis: 20%;
            border-radius: 10px;
        }

        .rainbow {
            flex-basis: 80%;
            padding: 6px;
            border-radius: 10px;
        }

        .action {
            display: flex;
            padding-block: 20px;
            flex-wrap: wrap;
            gap: 20px;
            height: 100%;
            justify-content: space-evenly;
            overflow-y: auto;
            border-radius: 10px;
        }
    </style>
    <section class="main-wrapper bg bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="" class="nav__link btn onview">Dashboard</a>
                    <?php
                    // Note: return  <a class='nav_link btn'>title</a>
                    Modules::getModules(-1);
                    ?>
                </nav>
            </div>
            <div class="content-right">
                <div class="bio bg bg-student">
                    <?php
                    //show default profile
                    // if (!isset($_SESSION['userProfile'])) {
                    //     echo "<img src='./assets/profile/default.png' class='profile'>";
                    //     exit();
                    // }
                    // echo "<img src='./assets/profile/" . $_SESSION['userProfile'] . "'" . " class='profile'>";
                    ?>
                </div>
                <section class="rainbow bg bg-student">
                    <div class="action">
                        <a href="./my-score" class="btn-img bg bg-rewards scale shadow"></a>
                        <a href="./mastery" class="btn-img bg bg-mastery scale shadow"></a>
                        <a href="./my-score" class="btn-img bg bg-quiz-score scale shadow"></a>
                        <a href="./my-stats" class="btn-img bg bg-stats scale shadow"></a>
                    </div>
                </section>
            </div>
        </section>
    </section>
</body>

</html>