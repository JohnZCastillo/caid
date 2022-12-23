<?php

require_once 'autoload.php';

use views\components\Modules;
use views\components\Profile;

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

        .student {

            background-color: yellow;
            flex-basis: 20%;
            border-radius: 10px;
            padding: 20px;
            display: flex;

        }

        .student>* {
            padding: 10px 10px;
        }

        .bio {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: inherit;
            border-radius: 0px 8px 8px 0px;

        }

        .btn-logout {
            margin-left: auto;
            width: 60px;
            height: 60px;
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

        .pointer {
            cursor: pointer;
        }

        #photo {
            width: 90px;
            height: 90px;
        }

        .profile-pic-div {
            width: 90px;
            height: 90px;
        }

        .profile {
            height: auto;
            background-color: inherit;
            border-radius: 8px 0px 0px 8px;
        }

        .name {
            flex-basis: 80%;
            background-color: inherit;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .user-name {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .user-section {
            font-size: 12px;
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
                <div class="bg bg-student student">
                    <div class="profile">
                        <?php Profile::getProfile() ?>
                    </div>
                    <div class="name">
                        <span class="user-name"><?php echo $_SESSION['userName'] ?></span>
                        <span class="user-section">Course & Section: <?php echo $_SESSION['userSection'] ?></span>
                    </div>
                    <section class="bio">
                        <a onclick="logout()" class="bg btn-logout scale shadow pointer"></a>
                    </section>
                </div>
                <section class="rainbow bg bg-student">
                    <div class="action">
                        <a href="./my-rewards" class="btn-img bg bg-rewards scale shadow"></a>
                        <a href="./mastery" class="btn-img bg bg-mastery scale shadow"></a>
                        <a href="./my-score" class="btn-img bg bg-quiz-score scale shadow"></a>
                        <a href="./my-stats" class="btn-img bg bg-stats scale shadow"></a>
                    </div>
                </section>
            </div>
        </section>
    </section>
    <script src="./resources/js/profile.js"></script>
    <script src="./resources/js/logout.js"></script>
</body>

</html>