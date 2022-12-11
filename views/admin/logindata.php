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

    <div class="modules">
        <div id="profile"><br>
            <div class="profile-pic-div">
                <?php
                //show default profile
                if (!isset($_SESSION['userProfile'])) {
                    echo "<img src='./assets/profile/default.png' id='photo'>";
                } else {
                    echo "<img src='./assets/profile/" . $_SESSION['userProfile'] . "'" . " id='photo'>";
                }
                ?>

                <input type="file" id="file">
                <label for="file" id="uploadBtn">Choose</label>
            </div>
            <script src="/CAIDSA/Javascripts/app.js"></script>
            <h4>ADMIN PROFILE</h4>
        </div>
        <div class="nav">
            <a href="./admin" class="nav-link">DASHBOARD</a>
            <a href="./account" class="nav-link nav-link-active">Accounts</a>
            <a href="./logout" class="nav-link" onclick="Login(this.form)">LOGOUT</a><br><br>
        </div>

    </div>
    <div class="box">
        <div class="form">
            <table class="styled-tabled">
                <thead>
                    <tr>
                        <th>Student Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Course</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach (UserDb::getUsers() as $user) {

                        $id = $user->getId();
                        $fname = $user->getFname();
                        $lname = $user->getLname();
                        $course = $user->getCourse();
                        $year = $user->getYear();

                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$fname</td>";
                        echo "<td>$lname</td>";
                        echo "<td>$course</td>";
                        echo "<td>$year</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</body>

</html>