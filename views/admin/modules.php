<?php

use db\TopicDb;
use db\ContentDb;
use db\QuestionDb;

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

if (isset($data['id'])) {
    try {
        $id = $data['id'];
        TopicDb::deleteTopic($id);
        echo json_encode(['message' => "Deleted"]);
        die();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Module</title>
    <link rel="stylesheet" href="./resources/css/animation.css">
    <link rel="stylesheet" href="./resources/css/modules.css">
</head>

<body>
    <header class="heading">
        <p>COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</p>
    </header>
    <section class="content">
        <div class="menu">
            <a class="btn" href="./admin">Done Edit</a>
            <a class="btn" href="./module-file">Add PDF</a>
            <a class="btn" href="./module-video">Add Video</a>
            <a class="btn" href="./quiz-maker">Add Quiz</a>
        </div>
        <div class="modules box glowing limit">

            <?php
            try {
                foreach (TopicDb::getAllTopics() as $topic) {

                    $title = $topic->getTitle();
                    $id = $topic->getId();
                    $contentId = -1;

                    echo "<div class='module'>";
                    echo "<h2>$title</h2>";

                    try {
                        foreach (ContentDb::getContent($id) as $content) {

                            $name = $content->getName();
                            $dataValue = $content->getData();
                            $payload = array_pop($dataValue);

                            $type = $content->getType();

                            switch ($type) {
                                case 1:
                                    echo "<div id='handout'>
                                        <object data='\CAIDSA\Student_Module\topic-1\1.1-Getting-Started.pdf' width='725' height='570'>
                                      </div>";
                                    break;
                                case 2:
                                    $id = $content->getId();
                                    $quizId = QuestionDb::getQuizId($id);
                                    echo "<div><a href='./quiz-shower?id=$quizId'>$name</a></div>";
                                    break;
                                case 3:
                                    $location = $payload->getLocation();
                                    echo "<div><a href='./assets/file/$location'>$name</a></div>";
                                    break;
                                case 4:
                                    $location = $payload->getLocation();
                                    echo "<div><a href='./assets/video/$location'>$name</a></div>";
                                    break;
                            }
                        }
                    } catch (Exception $error) {
                        echo "no content found";
                    }

                    echo "<div class='module__btn'>";
                    echo "<button onclick=\"deleteTopic($id)\" class='btn' id='$title'>Delete</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            ?>

            <button class="btn" id="addm">ADD MODULE</button>
        </div>
    </section>

    <script>
        const addModule = document.querySelector("#addm");

        addModule.addEventListener('click', async () => {

            const name = window.prompt('Module name');

            if (name === null) {
                alert("cancelled");
                return;
            }

            try {

                let result = await fetch("./add-module", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        title: name,
                    })
                });

                const status = result.ok;
                result = await result.json();

                if (!status) throw new Error(result.message);

                alert("Added");
                window.location.reload();
            } catch (error) {
                alert(error.message);
            }

        })

        function uploadFile(id) {

            console.log("hello");

            const input = document.querySelector(id);
            const form = document.querySelector(id + "-form");
            const name = document.querySelector(id + "-form-name");

            const fileName = window.prompt('File name');

            if (name === null) {
                alert("cancelled");
                return;
            }

            name.value = fileName;

            form.submit();
        }

        const deleteTopic = async (id) => {
            try {


                // if (!(window.confirm('Are you sure you want to delete this module?'))) {
                //     return;
                // }

                let result = await fetch("./modules", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        id: id,
                    })
                });

                const status = result.ok;
                result = await result.json();

                if (!status) throw new Error(result.message);

                alert(result.message);
                window.location.reload();

            } catch (error) {
                alert(error.message);
            }

        }
    </script>
</body>

</html>