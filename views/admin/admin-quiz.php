<?php

require_once 'autoload.php';

use db\TopicDb;
use db\QuestionDb;
use model\module\Quiz;
use views\components\Security;

Security::adminOnlyStrict();

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

if (isset($data['questions'], $data['topic'], $data['name'])) {
    try {

        $questions = $data['questions'];
        $topic = $data['topic'];
        $name = $data['name'];

        $quiz = new Quiz();

        $quiz->setName($name);
        $quiz->setType(2);
        $quiz->setTypeName("QUIZ");
        $quiz->setDescription("I am a test");
        $quiz->setOrder(2);
        $quiz->setTopicId($topic);

        foreach ($questions as $topic) {
            $question = $topic['question'];
            $answer = $topic['answer'];
            $choices = $topic['choices'];
            $quiz->addQuestion($question, $answer, $choices);
        }

        QuestionDb::addQuiz($quiz);
        echo json_encode(['message' => "Added"]);
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
    <title>Admin Quiz</title>
</head>

<body>

    <style>
        .content-right {
            padding: 6px;
            background-color: white;
        }

        .quiz-wrapper {
            display: grid;
            grid-template-columns: 1fr;
            height: 100%;
            overflow-y: auto;
        }

        .quiz-inner-wrapper {
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        .quiz-group {
            display: flex;
            flex-direction: column;
        }

        #form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        input,
        select {
            padding: 5px;
            outline: none;
        }

        .choice {
            display: grid;
            grid-template-columns: 30px 30px 2fr;

        }

        .choice>label {
            text-align: center;
        }

        .buttons {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .buttons>* {
            width: 150px;
            height: 50px;
        }
    </style>
    <section class="main-wrapper bg-dashboard">
        <header class="header">COMPUTER AIDED INSTRUCTION MATERIAL FOR DATA STRUCTURE AND ALGORITHM</header>
        <section class="content">
            <div class="content-left">
                <nav class="nav">
                    <a href="./admin-module" class="nav__link btn">Back</a>
                </nav>
            </div>
            <div class="content-right rainbow">
                <section class="quiz-wrapper">
                    <div class="quiz-inner-wrapper">
                        <div class="quiz-group">
                            <label for="topic">Topic</label>
                            <select name="topic" id="topic">
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

                        <div class="quiz-group">
                            <label for="">Quiz Name</label>
                            <input type="text" name="quiz-name" id="quiz-name">
                        </div>

                        <form action="" id="form">
                            <div class="quiz-group">
                                <label for="question">Question</label>
                                <input type="text" name="question" id="question">
                            </div>
                            <div class="choice">
                                <input type="radio" id="answer-a" name="answer" value="a">
                                <label for="question">A</label>
                                <input type="text" name="a" id="a">
                            </div>
                            <div class="choice">
                                <input type="radio" id="answer-b" name="answer" value="a">
                                <label for="question">B</label>
                                <input type="text" name="b" id="b">
                            </div>
                            <div class="choice">
                                <input type="radio" id="answer-c" name="answer" value="a">
                                <label for="question">C</label>
                                <input type="text" name="c" id="c">
                            </div>
                            <div class="choice">
                                <input type="radio" id="answer-d" name="answer" value="a">
                                <label for="question">D</label>
                                <input type="text" name="d" id="d">
                            </div>
                            <div>
                                <span>Total Question </span>
                                <span class="question-count">0</span>
                            </div>
                            <div class="buttons">
                                <button class="btn" type="submit">Submit</button>
                                <span class="btn" id="add-question">Add question</span>
                            </div>
                        </form>
                    </div>
                    <div class="preview-quiz">

                    </div>
                </section>
            </div>
        </section>
    </section>
    <script>
        const questions = [];
        const topic = document.querySelector("#topic");
        const name = document.querySelector("#quiz-name");
        const count = document.querySelector(".question-count");

        let problem = document.querySelector("#question");
        let choiceA = document.querySelector("#a");
        let choiceB = document.querySelector("#b");
        let choiceC = document.querySelector("#c");
        let choiceD = document.querySelector("#d");
        let correctA = document.querySelector("#answer-a")
        let correctB = document.querySelector("#answer-b")
        let correctC = document.querySelector("#answer-c")
        let correctD = document.querySelector("#answer-d")
        const addQuqestionBtn = document.querySelector("#add-question");
        const form = document.querySelector("#form");

        addQuqestionBtn.addEventListener("click", () => {

            try {

                if (problem.value.length <= 0) {
                    throw new Error("No question define");
                }

                const question = {
                    question: problem.value,
                    choices: [choiceA.value, choiceB.value, choiceC.value, choiceD.value],
                    answer: ""
                }

                if (correctA.checked == true) {
                    question.answer = choiceA.value;
                } else if (correctB.checked == true) {
                    question.answer = choiceB.value;
                } else if (correctC.checked == true) {
                    question.answer = choiceC.value;
                } else if (correctD.checked == true) {
                    question.answer = choiceD.value;
                } else {
                    throw new Error("No answer define. Please tick the radio box for the correct answer");
                }

                questions.push(question);
                count.innerHTML = questions.length;
                form.reset();
            } catch (error) {
                alert(error.message);
            }

        })

        form.addEventListener('submit', async (event) => {

            try {

                event.preventDefault();

                if (questions.length <= 0) {
                    throw new Error("Empty Question");
                }

                if (name.value.length <= 0) {
                    throw new Error("The quiz has no name");
                }

                let result = await fetch("./quiz-maker", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        questions: questions,
                        topic: topic.value,
                        name: name.value
                    })
                });

                const status = result.ok;
                result = await result.json();

                if (!status) throw new Error(result.message);

                alert("Quiz Added!");

                window.location.replace("./admin-module");

            } catch (error) {
                alert(error.message);
                //clear questions uppon error
                questions = [];
            }
        })
    </script>
</body>

</html>