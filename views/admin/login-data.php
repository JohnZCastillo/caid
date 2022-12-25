<?php

require_once 'autoload.php';

use db\UserDb;
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
    <title>Test Layout</title>
</head>

<body>

    <style>
        .content-right {
            padding: 6px;
            background-color: blue;
        }

        .btn-img {
            width: auto;
        }

        .filler {
            display: grid;
            grid-template-columns: 1fr;
            padding-block: 50px;
            padding-inline: 50px;
            /* flex-wrap: wrap; */
            gap: 20px;
            height: 100%;
            /* justify-content: space-evenly; */
            overflow-y: auto;
            border-radius: 10px;
        }

        table,
        tr,
        td {
            color: white;
        }

        th {
            color: yellow;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
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
                </section>
            </div>
        </section>
    </section>
    <script src="./resources/js/profile.js"></script>
</body>

</html>