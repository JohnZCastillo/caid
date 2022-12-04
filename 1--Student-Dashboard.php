<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="/CAIDSA/CSS/Student-Dashboard.css">
    <style>
        li {
            display: inline;
        }
    </style>
</head>

<body>
    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>
    <div class="modules">
        <a href="/CAIDSA/Student_Module/topic-1/1--Student-Dashboard.php" class="onview">DASHBOARD</a><br><br>
        <a href="/CAIDSA/Student_Module/topic-1/2--1-Getting-Started.php" class="button">1.1 Getting Started</a><br><br>
        <a href="/CAIDSA/Student_Module/2-Classes-and-Objects.php" class="button" id="b2">1.2 Classes and Objects</a><br><br>
        <a href="/CAIDSA/Student_Module/3-Strings-Wrappers-Arrays-and-Enum-Types.php" class="button" id="b3">1.3 Strings, Wrappers, Arrays, and Enum Types</a><br><br>
        <a href="/CAIDSA/Student_Module/4-Expressions.php" class="button" id="b4">1.4 Expressions</a><br><br>
        <a href="/CAIDSA/Student_Module/5-Control-Flow.php" class="button" id="b5">1.5 Control Flow</a><br><br>
        <a href="/CAIDSA/Student_Module/6-Simple-Input-and-Output.php" class="button" id="b6">1.6 Simple Input and Output</a><br><br>
        <a href="/CAIDSA/Student_Module/7-An-Example-Program.php" class="button" id="b7">1.7 An Example Program</a><br><br>
        <a href="/CAIDSA/Student_Module/8-Packages-and-Imports.php" class="button" id="b8">1.8 Packages and Imports</a><br><br>
        <a href="/CAIDSA/Student_Module/9-Software-and-Development.php" class="button" id="b9">1.9 Software and Development</a><br><br>
        <a href="/CAIDSA/Student_Module/10-Exercises.php" class="button" id="b10">1.10 Exercises</a><br><br>
    </div>
    <div class="profilediv">
        <div class="dropdown">
            <button class="mainmenubtn" onclick="Login(this.form)"></button>
            <script type="text/javascript">
                function Login(form) {
                    var retVal = confirm("Do you want to log out?");
                    if (retVal == true) {
                        window.location = "/CAIDSA/Student_Module/Login.php"
                        alert("Account has been logging out!");
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>
        </div>
        <div class="profile-pic-div">
            <img src="/CAIDSA/Photos/profile.png" id="photo">
            <input type="file" id="file">
            <label for="file" id="uploadBtn">Choose</label>
        </div>
        <script src="/CAIDSA/Javascripts/app.js"></script>
        <div id="nameandbio">
            <h3><span style="padding-left:100px;">Name: Ani M. Aker</h3>
            <!--<span style="padding-left:100px;">-->
            <h6><span style="padding-left:100px;">Course & Section: BSIT 701</h6>
            <h6><span style="padding-left:100px;">Profession: Future Full-Stack</h6>
        </div>
    </div>
    <div class="box">
        <div class="form">
            <div class="containers">
                <ul>
                    <div class="container1">
                        <a href="/CAIDSA/Student_Module/Student-Dashboard-Folder/Dashboard-Act-Rewards.php" class="pictures">
                            <li><img src="/CAIDSA/Photos/Student-Rewards.jpg" width="317px" height="180px">
                        </a></li>
                    </div>
                    <div class="container2">
                        <a href="/CAIDSA/Student_Module/Student-Dashboard-Folder/Dashboard-Act-Mastery.php" class="pictures">
                            <li><img src="/CAIDSA/Photos/Student-Mastery.jpg" width="317px" height="180px">
                        </a></li>
                    </div>
                    <div class="container3">
                        <a href="/CAIDSA/Student_Module/Student-Dashboard-Folder/Dashboard-Act-Quiz-Scores.php" class="pictures">
                            <li><img src="/CAIDSA/Photos/Student-Quiz-Scores.jpg" width="317px" height="180px">
                        </a></li>
                    </div>
                    <div class="container4">
                        <a href="/CAIDSA/Student_Module/Student-Dashboard-Folder/Dashboard-Act-Statistics.php" class="pictures">
                            <li><img src="/CAIDSA/Photos/Student-Statistics.jpg" width="317px" height="180px">
                        </a></li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>