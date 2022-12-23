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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Css Syle -->
    <link rel="stylesheet" href="./resources/css/general.css">
    <link rel="stylesheet" href="./resources/css/singup.css">

    <title>Document</title>
</head>

<body>
    <div class="box">
        <form method="post" action="./register">
            <div class="form">
                <h2>SIGN UP</h2>
                <div class="inputbox">
                    <input id="id" name="id" type="text" required>
                    <span>Student Number</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="Username" name="username" type="text" required>
                    <span>Username</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="Password" name="password" type="password" required>
                    <span>Password</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="FirstName" name="firstname" required>
                    <span>First Name</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="MiddleInitial" name="middlename" required>
                    <span>Middle Initial</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="Lastname" name="lastname" type="text" required>
                    <span>Last Name</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input date id="Email" name="email" required>
                    <span>Email</span>
                    <i></i>
                </div>
                <table>
                    <tr>
                        <th>
                            <div class="dropdown">
                                <select name="gender" id="Gender">
                                    <option value="" selected>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </th>
                        <th>
                            <div class="dropdown">
                                <select name="course" id="Course">
                                    <option value="" selected>Course</option>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSCpE">BSCpE</option>
                                </select>
                            </div>
                        </th>
                        <th>
                            <div class="dropdown">
                                <select name="year" id="YearLevel">
                                    <option value="" selected>Year Level</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                </select>
                            </div>
                        </th>
                    </tr>
                </table>
                <div class="inputbox">
                    <input type="date" id="Birthdate" name="birthdate" value="2018-01-01" min="1990-01-01" max="2018-12-31" required>
                    <span>Birth Date</span>
                    <i></i>
                </div>
                <button type="submit" class="add-user">Add User</button>
                <div id="cancelbtn">
                    <a href="./accounts">Cancel</a>
                </div>

                <div class="error">
                    <?php
                    if (isset($_SESSION['singupError'])) {
                        echo $_SESSION['singupError'];
                        unset($_SESSION['singupError']);
                    }
                    ?>
                </div>

            </div>
        </form>
    </div>
</body>

</html>