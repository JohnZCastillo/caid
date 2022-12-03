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

    //check db if username and password match.
    if (!UserDb::login($username, $password)) throw new Exception("Incorrect Username/Password");


    // reach this line no error 
    $_SESSION['isLogin'] = true;
    header('Location: ./panel');
} catch (Exception $ex) {
    $_SESSION['loginError'] = $ex->getMessage();
    header('Location: ./login');
    die();
}
