<?php

require_once 'autoload.php';

use views\components\Modules;
use views\components\Contents;

error_reporting(0);

// Initialize URL to the variable
$topicId = $_REQUEST['id'];

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
        .content-wrapper {
            padding-block: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 50px;
        }

        .content-right {
            padding: 6px;
            background-color: transparent;
        }

        .filler {
            height: 100%;
            overflow-y: auto;
        }
    </style>
    <section class="main-wrapper bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./sample" class="nav__link btn">Dashboard</a>
                    <?php
                    Modules::getModules($topicId);
                    ?>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="filler">
                    <?php
                    try {
                        $contents = Contents::getContents($topicId);
                        echo "<div class='content-wrapper  bg-dashboard'> $contents</div>";
                    } catch (Exception $e) {
                        $message = $e->getMessage();
                        echo "<div class='content-none bg-dashboard'>$message</div>";
                    }
                    ?>
                </section>

            </div>
        </section>
    </section>
</body>

</html>