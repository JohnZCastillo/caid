<?php

// This file redirec users to their corresponding role
namespace controller\redirect;

session_start();

use model\user\Role;

require_once 'autoload.php';

// check weather user is login if not redirect them to login page
if (isset($_SESSION['isLogin'])) {
    if (!$_SESSION['isLogin']) {
        header('Location: ./login');
        die();
    }
} else {
    header('Location: ./login');
    die();
}

if (isset($_SESSION['userRole'])) {

    switch ($_SESSION['userRole']) {

        case Role::$ADMIN:

            header('Location: ./admin');

            die();

            break;

        case Role::$STUDENT;

            header('Location: ./student');

            die();

            break;
    }
}

echo $_SESSION['userRole'];
// reach this line if user role is not define
http_response_code(401);
