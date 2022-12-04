<?php

use db\UserDb;

session_start();

try {

    //unset login session
    unset($_SESSION['isLogin']);

    // stop executing when username and password is null
    if (!isset($_POST['username'], $_POST['password'])) {
        throw new Exception("username and a password are required");
    }

    //prevent  xss attack
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    //get user base on username
    $currentUser = UserDb::getUserByUsername($username);

    //check if password and username is the same
    if (!($currentUser->getUsername() === $username &&
        $currentUser->getPassword() === $password)) {
        throw new Exception("Incorrect Username or Password");
    }

    // reach this line no error 
    $_SESSION['isLogin'] = true;
    $_SESSION['userRole'] = $currentUser->getRole();
    $_SESSION['userId'] = $currentUser->getId();
    $_SESSION['userName'] =  $currentUser->getFName() . " " . $currentUser->getMName() . " " .  $currentUser->getLName();

    header('Location: ./redirect');
    die();
} catch (Exception $ex) {
    http_response_code(403);
    $_SESSION['loginError'] = $ex->getMessage();
    header('Location: ./login');
    die();
}
