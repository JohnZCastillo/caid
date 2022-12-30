<?php

require_once 'autoload.php';

use db\UserDb;
use model\user\Role;
use views\components\Security;

Security::adminOnlyStrict();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Login Data</title>
</head>

<body>

    <style>
        .content-right {
            padding: 6px;
            background-color: var(--color-blue);
        }

        .btn-img {
            width: auto;
        }

        .filler {
            display: grid;
            grid-template-columns: 1fr;
            padding-block: 50px;
            padding-inline: 50px;
            gap: 20px;
            height: 100%;
            overflow-y: auto;
            border-radius: 10px;
        }


        table {
            border-collapse: collapse;
        }

        table tr td {
            border: 1px solid black;
        }

        table tr th {
            border: 1px solid black;
        }

        table thead tr th {
            padding: 10px;
        }

        table,
        tr,
        td {
            color: white;
        }

        th {
            color: var(--color-yellow);
        }

        tbody,
        th,
        td {

            padding: 10px 20px;
        }

        td {
            padding: 5px;
        }

        .fluid-table {
            overflow-x: auto;
            min-height: 400px;
            max-height: 600px;
        }
    </style>
    <section class="main-wrapper bg bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./accounts" class="nav__link btn">Back</a>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="filler">
                    <div class="fluid-table">
                        <table class="styled-tabled">
                            <h2>Students</h2>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Course</th>
                                    <th>Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach (UserDb::getStudents() as $user) {

                                    $id = $user->getId();
                                    $name = $user->getFullName();
                                    $course = $user->getCourse();
                                    $year = $user->getYear();
                                    $email = $user->getEmail();
                                    $gender = $user->getGender();
                                    $birthdate = $user->getBirthdate();
                                    $username = $user->getUsername();

                                    echo "<tr>";
                                    echo "<td>$id</td>";
                                    echo "<td>$name</td>";
                                    echo "<td>$email</td>";
                                    echo "<td>$username</td>";
                                    echo "<td>$gender</td>";
                                    echo "<td>$birthdate</td>";
                                    echo "<td>$course</td>";
                                    echo "<td>$year</td>";
                                    echo "<td><button>Update</button><button>Block</button><button>Delete</button></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="fluid-table">
                        <table class="styled-tabled">
                            <h2>Admins</h2>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Gender</th>
                                    <th>Birthdate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach (UserDb::getAdmins() as $user) {

                                    $id = $user->getId();
                                    $name = $user->getFullName();
                                    $email = $user->getEmail();
                                    $gender = $user->getGender();
                                    $birthdate = $user->getBirthdate();
                                    $username = $user->getUsername();

                                    echo "<tr>";
                                    echo "<td>$id</td>";
                                    echo "<td>$name</td>";
                                    echo "<td>$email</td>";
                                    echo "<td>$username</td>";
                                    echo "<td>$gender</td>";
                                    echo "<td>$birthdate</td>";

                                    if ($_SESSION['userId'] == 'admin') {

                                        if ($_SESSION['userId'] == $user->getId()) {
                                            echo "<td><button>Update</button></td></tr>";
                                            continue;
                                        } else {
                                            echo "<td><button>Update</button><button>Delete</button><button>Block</button></td></tr>";
                                        }

                                        continue;
                                    }

                                    if ($_SESSION['userId'] == $user->getId()) {
                                        echo "<td><button>Update</button></td></tr>";
                                        continue;
                                    }


                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </section>
    </section>
    <script src="./resources/js/profile.js"></script>
</body>

</html>