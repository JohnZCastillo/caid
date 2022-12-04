<?php

namespace controller\user;

session_start();

if (isset($_SESSION['isLogin'])) {

    if ($_SESSION['isLogin'] === true) {

        session_destroy();

        header('Location: ./login');

        die();
    }
}

$_SESSION['loginError'] = "You're not login!";

header('Location: ./login');

die();
