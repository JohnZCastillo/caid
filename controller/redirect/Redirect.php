<?php

// This file redirec users to their corresponding role
namespace controller\redirect;

session_start();

use model\user\Role;

require_once 'autoload.php';


// check weather user is login if not redirect them to login page
if (isset($_SESSION['isLogin'])) {
    if (!$_SESSION['isLogin']) {
        header('Location: /caid/login');
        die();
    }
} else {
    header('Location: /caid/login');
    die();
}

if (isset($_SESSION['userRole'])) {

    switch ($_SESSION['userRole']) {

        case Role::$ADMIN:

            header('Location: /caid/admin');

            die();

            break;

        case Role::$STUDENT;

            header('Location: /caid/student');

            die();

            break;
    }
}

// reach this line if user role is not define
http_response_code(401);
