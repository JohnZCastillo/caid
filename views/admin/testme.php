<?php

use db\UserDb;
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
    <title>Accounts</title>
    <link rel="stylesheet" href="./resources/css/admin.css">
</head>

<body>



    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>

    <div class="box">
        <div class="form">
            <form method="post" action='./upload-game' enctype="multipart/form-data">
                <input type="file" name="files[]" id="files" webkitdirectory mozdirectory>
                <input class="button" type="submit" value="Upload" />
            </form>
        </div>
    </div>
</body>

</html>