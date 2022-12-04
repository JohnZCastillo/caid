<?php

use model\user\Role;

session_start();

if (!isset($_SESSION["isLogin"])) {
    $_SESSION["loginError"] = "You're not login!. Login First";
    header('Location: ./login');
    exit();
}

//redirect to login page if not login
if (!$_SESSION["isLogin"]) {
    header('Location: ./login');
    exit();
}

// redirect if not admin
if ($_SESSION['userRole'] !== Role::$ADMIN) {
    header('Location: ./redirect');
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="./resources/css/general.css">
    <link rel="stylesheet" href="./resources/css/admin.css">

</head>

<body>

    <header class="header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </header>

    <div class="content">
        <div class="modules">
            <div id="profile"><br>
                <div class="profile-pic-div">
                    <img src="/CAIDSA/Photos/profile.png" id="photo">
                    <input type="file" id="file">
                    <label for="file" id="uploadBtn">Choose</label>
                </div>
                <h4>ADMIN PROFILE</h4>
            </div>
            <nav class="nav">
                <a href="" class="nav-link">Dashboard</a>
                <a href="" class="nav-link">Accounts</a>
                <a href="./logout" class="nav-link">Logout</a>
            </nav>
        </div>
        <div class="box">
            <div class="form">
                <div class="containers">
                    <div class="container">
                        <a href="" class="pictures">
                            <img src="./resources/images/icons/rewards.jpg" width="180px" height="180px">
                        </a>
                    </div>
                    <div class="container">
                        <a href="" class="pictures">
                            <img src="./resources/images/icons/mastery.jpg" width="180px" height="180px">
                        </a>
                    </div>
                    <div class="container">
                        <a href="" class="pictures">
                            <img src="./resources/images/icons/quiz-score.jpg" width="180px" height="180px">
                        </a>
                    </div>
                    <div class="container">
                        <a href="" class="pictures">
                            <img src="./resources/images/icons/statistics.jpg" width="180px" height="180px">
                        </a>
                    </div>
                    <div class="container">
                        <a href="" class="pictures">
                            <img src="./resources/images/icons/modules.jpg" width="180px" height="180px">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="/CAIDSA/Javascripts/app.js"></script>
</body>

</html>