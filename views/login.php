<?php

session_start();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Login</title>
    <link rel="stylesheet" href="./resources/css/general.css">
    <link rel="stylesheet" href="./resources/css/login.css">
</head>

<body>
    <div class="box">
        <div class="form">
            <form id="form" method="POST" action="./auth">
                <h2>Sign in </h2>
                <div class="inputbox">
                    <input type="text" required="required" id="username" name="username">
                    <span>Username </span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input type="password" required="required" id="password" name="password">
                    <span>Password</span>
                    <i></i>
                </div>
                <div class="links">
                    <a href="#"> Forgot Password</a>
                </div>
                <button type="submit" id="login">Login</button>
                <div class="login-error">
                    <?php
                    if (isset($_SESSION['loginError'])) {
                        echo $_SESSION['loginError'];
                        unset($_SESSION['loginError']);
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>