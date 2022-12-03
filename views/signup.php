<?php

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
        <form method="post" action="">
            <div class="form">
                <h2>SIGN UP</h2>
                <div class="inputbox">
                    <input id="id" name="id" type="text" required>
                    <span>Student Number</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="Username" name="Username" type="text" required>
                    <span>Username</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="Password" name="Password" type="password" required>
                    <span>Password</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="FirstName" name="Firstname" required>
                    <span>First Name</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="MiddleInitial" name="Middle" required>
                    <span>Middle Initial</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input id="Lastname" name="Lastname" type="text" required>
                    <span>Last Name</span>
                    <i></i>
                </div>
                <div class="inputbox">
                    <input date id="Email" name="Email" required>
                    <span>Email</span>
                    <i></i>
                </div>
                <table>
                    <tr>
                        <th>
                            <div class="dropdown">
                                <select name="Gender" id="Gender">
                                    <option value="o" selected>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </th>
                        <th>
                            <div class="dropdown">
                                <select name="Course" id="Course">
                                    <option value="c" selected>Course</option>
                                    <option value="BSIT">BSIT</option>
                                    <option value="BSCpE">BSCpE</option>
                                </select>
                            </div>
                        </th>
                        <th>
                            <div class="dropdown">
                                <select name="YearLevel" id="YearLevel">
                                    <option value="o" selected>Year Level</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                </select>
                            </div>
                        </th>
                    </tr>
                </table>
                <div class="inputbox">
                    <input type="date" id="Birthdate" name="Birthdate" value="2018-01-01" min="1990-01-01" max="2018-12-31" required>
                    <span>Birth Date</span>
                    <i></i>
                </div>
                <input type="submit" onclick="AddUser(this.form)" name="Click" value="Add User">
                <div id="cancelbtn">
                    <a href="/CAIDSA/Admin_Module/Admin-New-Account.php">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>



</html>