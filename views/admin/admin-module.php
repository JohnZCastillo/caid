<?php

require_once 'autoload.php';

use db\TopicDb;
use db\ContentDb;
use db\FileDb;
use db\QuestionDb;
use views\components\Security;

Security::adminOnlyStrict();

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

if (isset($data['deleteFile'], $data['step'], $data['topicId'])) {
    try {
        $id = $data['deleteFile'];
        $step = $data['step'];
        $topicId = $data['topicId'];

        FileDb::deleteFile($topicId, $id, $step);
        echo json_encode(['message' => "Content Deleted"]);
        die();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}

if (isset($data['quizId'], $data['contentId'], $data['topicId'], $data['step'])) {
    try {

        $quizId = $data['quizId'];
        $step = $data['step'];
        $topicId = $data['topicId'];
        $contentId = $data['contentId'];

        QuestionDb::deleteQuiz($topicId, $contentId, $quizId, $step);
        echo json_encode(['message' => "Content Deleted"]);
        die();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}

if (isset($data['topicId'], $data['contentId'], $data['order'])) {
    try {
        $order = $data['order'];
        $topicId = $data['topicId'];
        $contentId = $data['contentId'];
        ContentDb::updateOrder($topicId, $contentId, $order);
        echo json_encode(['message' => "Order Updated"]);
        die();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./resources/css/style.css">
    <title>Modules</title>
</head>

<body>

    <style>
        a {
            color: white;
        }

        .content-right {
            padding: 6px;
            background-color: var(--color-blue);
        }

        .btn-img {
            width: auto;
        }

        .filler {
            padding: 10px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            overflow-y: auto;
            border-radius: 10px;
        }

        .module {
            background-color: #343435;
            border-radius: 8px;
            padding: 10px;
            color: white;
        }

        .module__btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
        }

        .btn {
            width: 100%;
        }

        .holder {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-block: 10px;
            gap: 10px;
        }



        .del {
            width: max-content;
            background-color: red;
        }

        .holder-wrapper {
            margin-left: auto;
        }

        .order {
            padding: 10px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
        }
    </style>
    <section class="main-wrapper bg bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./admin" class="nav__link btn">Done Edit</a>
                    <a href="./module-file" class="nav__link btn">Add PDF</a>
                    <a href="./module-video" class="nav__link btn">Add Video</a>
                    <a href="./quiz-maker" class="nav__link btn">Add Quiz</a>
                    <a href="./module-game" class="nav__link btn">Add Game</a>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="filler">
                    <?php
                    try {
                        foreach (TopicDb::getAllTopics() as $topic) {

                            $title = $topic->getTitle();
                            $id = $topic->getId();
                            $contentId = -1;

                            echo "<div class='module'>";
                            echo "<h2>$title</h2>";


                            try {

                                $contents = ContentDb::getContent($id);


                                function setOrder($max, $order, $contentId)
                                {
                                    global $id;

                                    $orders = " <select class='order' id='myId$id$contentId' onchange=\"changeOrder($id,$contentId,$order)\">";

                                    for ($i = 1; $i <= $max; $i++) {
                                        if ($i == $order) {
                                            $orders = $orders . "<option selected value='$i'>$i</option>";
                                        } else {
                                            $orders = $orders . "<option value='$i'>$i</option>";
                                        }
                                    }
                                    return $orders . "</select>";
                                }


                                foreach ($contents as $content) {

                                    $step = $content->getId();

                                    $name = $content->getName();
                                    $dataValue = $content->getData();
                                    $payload = array_pop($dataValue);

                                    $type = $content->getType();
                                    $orderId = $content->getOrder();

                                    $orders = setOrder(count($contents), $orderId, $step);


                                    switch ($type) {
                                        case 1:
                                            $location = $payload->getLocation();
                                            $gameId = $content->getId();
                                            $fileId = $content->getId();
                                            echo "<div class='holder'>
                                            <a href='./assets/game/$location/index.html'>$name</a>
                                            <div class='holder-wrapper'>
                                                    $orders
                                            </div>
                                            <span class='btn del' onclick=\"deleteContent($id,$gameId,$step )\">delete</span>
                                            </div>";
                                            break;
                                        case 2:
                                            $contenId = $content->getId();
                                            $quizId = QuestionDb::getQuizId($contenId);
                                            echo "<div  class='holder'>
                                            <a href='./quiz-shower?id=$quizId'>$name</a>
                                            <div class='holder-wrapper'>
                                                $orders
                                            </div>
                                            <span class='btn del' onclick=\"deleteQuiz($id,$contenId,$quizId,$step )\">delete</span>
                                            </div>";
                                            break;
                                        case 3:
                                            $location = $payload->getLocation();
                                            $fileId = $content->getId();
                                            echo "<div  class='holder'>
                                            <a href='./assets/file/$location'>$name</a>
                                            <div class='holder-wrapper'>
                                                    $orders
                                            </div>
                                             <span class='btn del' onclick=\"deleteContent($id,$fileId,$step )\">delete</span>
                                            </div>";
                                            break;
                                        case 4:
                                            $location = $payload->getLocation();
                                            $fileId = $content->getId();
                                            echo "<div  class='holder'><a href='./assets/video/$location'>$name</a>
                                            <div class='holder-wrapper'>
                                                    $orders
                                            </div>
                                            <span class='btn del' onclick=\"deleteContent($id,$fileId,$step)\">delete</span>
                                            </div>";
                                            break;
                                        case 5:
                                            $location = $payload->getLocation();
                                            $fileId = $content->getId();
                                            echo "<div  class='holder'>
                                            <a href='./assets/discussion/$location'>$name</a>
                                            <div class='holder-wrapper'>
                                                    $orders
                                            </div>
                                            <span class='btn del' onclick=\"deleteContent($id,$fileId,$step)\">delete</span>
                                            </div>";
                                            break;
                                    }
                                }
                            } catch (Exception $error) {
                                echo "no content found";
                            }

                            echo "<div class='module__btn'>";
                            echo "<button onclick=\"deleteTopic($id)\" class='btn' id='$title'>Delete Module</button>";
                            echo "<button onclick=\"deleteTopic($id)\" class='btn' id='$title'>Update Order</button>";
                            echo "</div>";
                            echo "</div>";
                        }
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                    ?>

                    <button class="btn" id="addm">ADD MODULE</button>
                </section>
            </div>
        </section>
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


                if (!(window.confirm('Are you sure you want to delete this module?'))) {
                    return;
                }

                let result = await fetch("./admin-module", {
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

        const deleteContent = async (topicId, id, step) => {
            try {

                if (!(window.confirm('Are you sure you want to delete this Content?'))) {
                    return;
                }

                let result = await fetch("./admin-module", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        deleteFile: id,
                        step: step,
                        topicId: topicId
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

        const deleteQuiz = async (topicId, contentId, quizId, step) => {
            try {

                if (!(window.confirm('Are you sure you want to delete this Content?'))) {
                    return;
                }

                let result = await fetch("./admin-module", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        contentId: contentId,
                        quizId: quizId,
                        step: step,
                        topicId: topicId
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

        const changeOrder = async (topicId, contentId, originalValue) => {

            try {

                const target = document.querySelector("#myId" + topicId + contentId);

                if (!(window.confirm('Are you sure you want to change order?'))) {
                    target.value = originalValue;
                    return;
                }

                let result = await fetch("./admin-module", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        topicId: topicId,
                        contentId: contentId,
                        order: target.value,
                    })
                });

                const status = result.ok;
                result = await result.json();

                if (!status) throw new Error(result.message);

                alert(result.message);
                window.location.reload();

            } catch (error) {
                console.log(error.message);
            }

        }
    </script>
</body>

</html>