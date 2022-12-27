<?php

require_once 'autoload.php';

use views\components\Profile;
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

<body>

    <style>
        .content-right {
            padding: 6px;
            background-color: var(--color-blue);
        }

        .btn-img {
            width: auto;
        }

        .filler {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            padding-block: 50px;
            padding-inline: 50px;
            /* flex-wrap: wrap; */
            gap: 20px;
            height: 100%;
            /* justify-content: space-evenly; */
            overflow-y: auto;
            border-radius: 10px;
        }
    </style>
    <section class="main-wrapper bg bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <div class="profile">
                    <?php Profile::getProfile() ?>
                    <h3>Admin Profile</h3>
                </div>
                <nav class="nav">
                    <a href="#" class="nav__link btn onview">Dashboard</a>
                    <a href="./accounts" class="nav__link btn">Accounts</a>
                    <a onclick="logout()" class="nav__link btn">Logout</a>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="filler">
                    <a href="./admin-reward" class="btn-img bg bg-rewards scale shadow"></a>
                    <a href="./admin-progress" class="btn-img bg bg-mastery scale shadow"></a>
                    <a href="./admin-score" class="btn-img bg bg-quiz-score scale shadow"></a>
                    <a href="./admin-stats" class="btn-img bg bg-stats scale shadow"></a>
                    <a href="./admin-module" class="btn-img bg bg-modules scale shadow"></a>
                </section>
            </div>
        </section>
    </section>
    <script src="./resources/js/profile.js"></script>
    <script src="./resources/js/logout.js"></script>
</body>

</html>