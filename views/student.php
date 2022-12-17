<?php

use db\TopicDb;
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
if ($_SESSION['userRole'] !== Role::$STUDENT) {
    header('Location: ./redirect');
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="./resources/css/student.css">
</head>

<body>


    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>
    <div class="modules">
        <a href="" class="onview">DASHBOARD</a><br><br>

        <!-- Load topics -->
        <?php

        try {
            foreach (TopicDb::getAllTopics() as $topic) {
                $title = $topic->getTitle();
                $id = $topic->getId();
                echo "<a href=\"./intro?id=$id\" class=\"button\">$title</a><br><br>";
            }
        } catch (Exception  $e) {
            echo "No topics yet";
        }

        ?>
    </div>
    <div class="profilediv">
        <div class="dropdown">
            <button class="mainmenubtn" onclick="Login(this.form)"></button>
            <script type="text/javascript">
                function Login(form) {
                    var retVal = confirm("Do you want to log out?");
                    if (retVal == true) {
                        window.location = "./logout"
                        alert("Account has been logging out!");
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>
        </div>
        <div class="profile-pic-div">
            <img src="" id="photo">
            <input type="file" id="file">
            <label for="file" id="uploadBtn">Choose</label>
        </div>
        <script src="/CAIDSA/Javascripts/app.js"></script>
        <div id="nameandbio">
            <h3><span style="padding-left:100px;"><?php echo $_SESSION['userName'] ?></h3>
            <h6><span style="padding-left:100px;">Course & Section: BSIT 701</h6>
            <h6><span style="padding-left:100px;">Profession: Future Full-Stack</h6>
        </div>
    </div>
    <div class="box">
        <div class="form">
            <div class="containers">
                <div class="container1">
                    <a href="" class="pictures">
                        <img src="./resources/images/icons/rewards.jpg" width="317px" height="180px">
                    </a>
                </div>
                <div class="container2">
                    <a href="" class="pictures">
                        <img src="./resources/images/icons/mastery.jpg" width="317px" height="180px">
                    </a>
                </div>
                <div class="container3">
                    <a href="" class="pictures">
                        <img src="./resources/images/icons/quiz-score.jpg" width="317px" height="180px">
                    </a>
                </div>
                <div class="container4">
                    <a href="" class="pictures">
                        <img src="./resources/images/icons/statistics.jpg" width="317px" height="180px">
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html