<?php

use db\TopicDb;


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
        </div>
        <div class="modules box glowing limit">

            <?php
            try {
                foreach (TopicDb::getAllTopics() as $topic) {

                    $title = $topic->getTitle();
                    $id = $topic->getId();


                    echo "<div class='module'>";
                    echo "<h2>$title</h2>";

                    try {
                        foreach (TopicDb::getContent($id) as $content) {
                            $location = $content->getLocation();
                            $name = $content->getName();
                            echo "<div>
                            $name
                            $location
                            </div>";
                        }
                    } catch (Exception $error) {
                        echo "no content found";
                    }


                    echo "<div class='module__btn'>";
                    echo "<a href='./module-file' class='btn'>File</a>";
                    echo "<button class='btn' id='$title'>Delete</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } catch (Exception $e) {
                // echo "No modules found";
                $e->getMessage();
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
    </script>
</body>

</html>