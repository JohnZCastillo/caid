<?php

require_once 'autoload.php';

use model\user\Role;
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
            width: 300;
            height: 200;
        }

        .filler {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
                    <a href="./admin" class="nav__link btn">Dashboard</a>
                    <a href="#" class="nav__link btn onview">Accounts</a>
                    <a onclick="logout()" class="nav__link btn">Logout</a>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="filler">
                    <a href="./signup-admin" class="btn-img bg bg-new-admin scale shadow"></a>
                    <a href="./signup" class="btn-img bg bg-new-student scale shadow"></a>
                    <a href="./login-data" class="btn-img bg bg-account-data scale shadow"></a>
                </section>
            </div>
        </section>
    </section>
    <script src="./resources/js/profile.js"></script>
    <script src="./resources/js/logout.js"></script>

</body>

</html>