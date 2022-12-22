<?php

namespace views\admin;

use db\ContentDb;
use db\FileDb;
use db\TopicDb;
use Exception;
use model\module\Content;
use model\module\File;

if (isset($_FILES['file'], $_POST['title'], $_POST['description'], $_POST['topic'], $_POST['type'])) {

    try {

        //see database type for file type

        // path where images will ba saved
        $imagePath = './assets/video/';

        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $imageName = $_POST['title'] . '.' . $extension;

        move_uploaded_file($_FILES['file']['tmp_name'], $imagePath . $imageName);

        $topicId = $_POST['topic'];
        $title = $_POST['title'];
        $description =  $_POST['description'];
        $type = $_POST['type'];

        $content = new Content();
        $content->setName($title);
        $content->setDescription($description);
        $content->setOrder(1);
        $content->setType($type);
        $content->setTopics($topicId);

        ContentDb::addContent($content);

        $file = new File();
        $file->setContenId($content->getId());
        $file->setLocation($imageName);
        $file->setTopicId($topicId);

        FileDb::addFile($file);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>

<body>

    <form action="" method="POST" action="./module-video" enctype="multipart/form-data">
        <div>
            <label for="name">Title</label>
            <input type="text" name="title">
        </div>
        <div>
            <label for="topic">Topic</label>
            <select name="topic">
                <?php
                try {
                    foreach (TopicDb::getAllTopics() as $topic) {

                        $title = $topic->getTitle();
                        $id = $topic->getId();

                        echo "<option value='$id'>
                            $title
                        </option>";
                    }
                } catch (Exception $e) {
                    echo "No modules found";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="type">Type</label>
            <select name="type" required>
                <option value="4">Animated Presentation</option>
                <option value="5">Practical Discussion</option>
            </select>
        </div>
        <div>
            <label for="file">File</label>
            <input type="file" name="file">
        </div>
        <div>
            <label for="file">Description</label>
            <textarea name="description"> </textarea>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>

</html>