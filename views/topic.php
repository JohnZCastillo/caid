<?php

require_once 'autoload.php';

use db\ContentDb;
use db\MasteryDb;
use views\components\Modules;
use views\components\Contents;
use views\components\Security;

error_reporting(0);

Security::studentOnlyStrict();


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
    <title>Topic</title>
</head>

<body onload="load()">
    <style>
        .content-wrapper {
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 50px;
            overflow-y: auto;
            padding-block: 40px;
        }

        .content-wrapper>a {
            flex-shrink: 0;
            margin-inline: auto;
        }

        .content-right {
            padding: 6px;
            background-color: transparent;
        }

        .filler {
            height: 100%;
        }

        /* wizard */
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
            background-color: #d9e13a;
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
            backdrop-filter: blur(2px);
        }

        .hide {
            display: none;
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
            <div class="content-right rainbow bg bg-dashboard">
                <section class="filler">
                    <?php
                    try {
                        $contents = Contents::getContents($topicId);
                        echo "<div class='content-wrapper  '> $contents</div>";
                    } catch (Exception $e) {
                        $message = $e->getMessage();
                        echo "<div class='content-none '>$message</div>";
                    }
                    ?>
                </section>

            </div>
        </section>
    </section>

    <?php
    try {

        $firstContent = ContentDb::getFirstContent($topicId);
        $contentId = $firstContent->getId();
        $instruction = $firstContent->getDescription();

        if (!MasteryDb::hasCert($topicId, $contentId)) {
            echo "  <div class='wizard-show wizard hide'>
        <section class='dialog'>
            <section class='dialog__content'>
                <img class='dialog-img' src='./assets/profile/default.png' alt='' srcset=''>
                <p class='dialog-msg'>$instruction </p>
            </section>
            <button class='btn-ok'>Okay</button>
        </section>
    </div>
    <script>
        const wizard = document.querySelector('.wizard');
        const okBtn = document.querySelector('.btn-ok');
        const msg = document.querySelector('.dialog-msg');

        okBtn.addEventListener('click', () => {
            wizard.classList.add('hide');
        })

        window.onclick = function(event) {
            if (event.target != okBtn && !(wizard.classList.contains('hide'))) {
                event.preventDefault();
            }
        }

        const showWizard = () => {
            wizard.classList.remove('hide');
        }

        function load() {
            showWizard();
        }
    </script>";
        }
    } catch (Exception $e) {
        //an error has occured
    }
    ?>
</body>

</html>