<?php

namespace controller\user;

session_start();

require_once 'autoload.php';

use db\UserDb;
use Exception;
use model\user\Role;
use model\user\User;


// prevent from accessing this file

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


try {

    //check if required field are present    
    if (!isset(
        $_POST['id'],
        $_POST['username'],
        $_POST['password'],
        $_POST['email'],
        $_POST['firstname'],
        $_POST['middlename'],
        $_POST['lastname'],
        $_POST['gender'],
        $_POST['course'],
        $_POST['year'],
        $_POST['birthdate']
    )) {

        throw new Exception('Missing Input');
    }

    //prevent xss attack    
    $id = htmlspecialchars($_POST['id']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $email = htmlspecialchars($_POST['email']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $middlename = htmlspecialchars($_POST['middlename']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $gender = htmlspecialchars($_POST['gender']);
    $course = htmlspecialchars($_POST['course']);
    $year = htmlspecialchars($_POST['year']);
    $birthdate = htmlspecialchars($_POST['birthdate']);

    //create a user object
    $user = new User(
        $id,
        $username,
        $password,
        $email,
        $firstname,
        $middlename,
        $lastname,
        $gender,
        $course,
        $year,
        $birthdate
    );

    //set the role to admin
    $user->setRole(Role::$ADMIN);

    //add user to db    
    UserDb::addUser($user);
    header('Location: ./accounts');
    die();
} catch (Exception $ex) {
    http_response_code(403);
    $_SESSION['singupError'] = $ex->getMessage();
    header('Location: ./admin-signup');
    die();
}
