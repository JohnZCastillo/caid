<?php

use db\FileDb;
use db\TopicDb;
use db\ContentDb;
use model\user\Role;
use model\module\File;
use model\module\Content;

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

if (isset($_FILES['file'], $_POST['title'], $_POST['description'], $_POST['topic'])) {

    try {

        //see database type for file type

        // path where images will ba saved
        $imagePath = './assets/file/';

        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $imageName = $_POST['title'] . '.' . $extension;

        move_uploaded_file($_FILES['file']['tmp_name'], $imagePath . $imageName);

        $topicId = $_POST['topic'];
        $title = $_POST['title'];
        $description =  $_POST['description'];

        $content = new Content();
        $content->setName($title);
        $content->setDescription($description);
        $content->setOrder(1);
        $content->setType(3);
        $content->setTopics($topicId);

        ContentDb::addContent($content);

        $file = new File();
        $file->setContenId($content->getId());
        $file->setLocation($imageName);
        $file->setTopicId($topicId);

        FileDb::addFile($file);

        header("location: ./admin-module");
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Accounts</title>
    <link rel="stylesheet" href="./resources/css/admin.css">
</head>

<body>
    <style>
        .form {
            color: white;
        }

        select {
            font-weight: 600;
            border: none;
            margin-top: 0;
            position: static;
            margin-left: 0;
            width: auto;
            height: auto;
            z-index: 1;
            background: white;
            text-align: left;
        }

        form>div {
            display: flex;
            flex-direction: column;
            padding-block: 5px;
        }

        input,
        select {
            padding: 10px;
        }

        .btn-wrapper {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .btn {
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 10px;
            background-color: rgb(70, 70, 70);
            border: none;
            color: white;
            font-size: 1rem;
        }

        .btn:hover {
            transform: scale(1.2);
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
        }

        .btn-submit {
            background-color: #fff04b;
            color: black;
        }
    </style>
    <div class="Header">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </div>

    <div class="box">
        <div class="form">
            <h1>ADD PDF</h1>
            <form action="" method="POST" action="./add-file" enctype="multipart/form-data">
                <div>
                    <label for="name">Title</label>
                    <input type="text" name="title">
                </div>
                <div>
                    <label for="topic">Topic</label>
                    <select name="topic" required>
                        <?php
                        try {
                            foreach (TopicDb::getAllTopics() as $topic) {

                                $title = $topic->getTitle();
                                $id = $topic->getId();
                                echo "<option value='$id'>$title</option>";
                            }
                        } catch (Exception $e) {
                            echo "No modules found";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="file">File</label>
                    <input type="file" name="file" required>
                </div>
                <div>
                    <label for="file">Description</label>
                    <textarea name="description"> </textarea>
                </div>
                <div class="btn-wrapper">
                    <button type="submit" class="btn btn-submit">Submit</button>
                    <a href="./admin-module" class="btn">cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>