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
    <section class="main-wrapper bg bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="" class="nav__link btn onview">Dashboard</a>
                    <?php
                    // Note: return  <a class='nav_link btn'>title</a>
                    Modules::getModules(76);
                    ?>
                </nav>
            </div>
            <div class="content-right rainbow">
                <div class="bio">
                    <?php
                    //show default profile
                    if (!isset($_SESSION['userProfile'])) {
                        echo "<img src='./assets/profile/default.png' class='profile'>";
                        exit();
                    }
                    echo "<img src='./assets/profile/" . $_SESSION['userProfile'] . "'" . " class='profile'>";
                    ?>
                </div>
                <div class="action">

                </div>
            </div>
        </section>
    </section>
</body>

</html>