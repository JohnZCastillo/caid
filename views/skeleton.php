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

    </style>
    <section class="main-wrapper">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <?php
                    Modules::getModules(76);
                    ?>
                </nav>
            </div>
            <div class="content-right">

            </div>
        </section>
    </section>
</body>

</html>