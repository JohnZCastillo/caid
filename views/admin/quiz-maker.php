<?php

use db\QuestionDb;
use db\TopicDb;
use model\module\Quiz;

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

if (isset($data['questions'], $data['topic'], $data['name'])) {
    try {

        $questions = $data['questions'];
        $topic = $data['topic'];
        $name = $data['name'];

        //        QuestionDb::addQuestion($questions, $topic, $name);

        $quiz = new Quiz();

        $quiz->setName($name);
        $quiz->setType(4);
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

        // var_dump($questions);
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
    <title>Quiz-maker</title>
</head>

<body>
    <section>

        <div>
            <label for="topic">Topic</label>
            <select name="topic" id="topic">
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
            <label for="">Quiz Name</label>
            <input type="text" name="quiz-name" id="quiz-name">
        </div>

        <form action="" id="form">
            <div>
                <label for="question">Question</label>
                <input type="text" name="question" id="question">
            </div>
            <div>
                <input type="radio" id="answer-a" name="answer" value="a">
                <label for="question">A</label>
                <input type="text" name="a" id="a">
            </div>
            <div>
                <input type="radio" id="answer-b" name="answer" value="a">
                <label for="question">B</label>
                <input type="text" name="b" id="b">
            </div>
            <div>
                <input type="radio" id="answer-c" name="answer" value="a">
                <label for="question">C</label>
                <input type="text" name="c" id="c">
            </div>
            <div>
                <input type="radio" id="answer-d" name="answer" value="a">
                <label for="question">D</label>
                <input type="text" name="d" id="d">
            </div>
            <div>
                <button type="submit">Submit</button>
                <span id="add-question">Add question</span>
            </div>
        </form>
    </section>
</body>
<script>
    const questions = [];
    const topic = document.querySelector("#topic");
    const name = document.querySelector("#quiz-name");
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
        const question = {
            question: problem.value,
            choices: [choiceA.value, choiceB.value, choiceC.value, choiceD.value],
            answer: ""
        }

        if (correctA.checked == true) {
            question.answer = "a";
        } else if (correctB.checked == true) {
            question.answer = "b";
        } else if (correctC.checked == true) {
            question.answer = "c";
        } else if (correctD.checked == true) {
            question.answer = "d";
        }

        questions.push(question);
        form.reset();
    })

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        try {

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

            if (!status)
                throw new Error(result.message);

            alert("Added");
            window.location.reload();
        } catch (error) {
            alert(error.message);
            //clear questions uppon error
            questions = [];
        }
    })
</script>

</html>