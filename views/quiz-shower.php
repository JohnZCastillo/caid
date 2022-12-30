<?php

use db\QuestionDb;
use db\QuizResult;

error_reporting(0);

session_start();

// Initialize URL to the variable
$id = $_REQUEST['id'];

$quizData = QuestionDb::getQuiz($id);


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <!-- <link rel="stylesheet" href="./resources/css/topics.css"> -->
    <link rel="stylesheet" href="./resources/css/style.css">
</head>

<body>

    <style>
        body {
            background-image: none;
            background-color: transparent;

            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
        }

        .hide {
            display: none;
        }

        .quiz-container {
            padding: 10px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px 2px black;
            width: 600px;
            margin-top: 0;
            text-align: center;
            margin-left: 0;
            display: flex;
            flex-direction: column;
        }

        ul {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        li {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        li>label {
            word-break: break-all;
            text-align: left;
        }

        .quiz-header {
            max-height: 400px;
            height: 90vh;
            overflow-y: auto;
            padding-inline: 10px;
            margin-bottom: 10px;
        }

        .test {
            overflow-y: auto;
        }
    </style>

    <div class="quiz-container" id="quiz">

        <?php

        ?>
        <div class="quiz-header">

            <?php

            try {

                $userId = $_SESSION['userId'];
                $result = QuizResult::isQuizAlreadyTaken($id, $userId);

                // prevent quiz from being retaken
                if ($result  != null) {
                    echo "<div>You Have Already Taken This Quiz</div>";
                    echo "<div>You Score is $result</div>";
                    die();
                }

                echo "<script>var quizId = $id; </script>";

                $quiz = $quizData->getQuiz();

                $number = 1;

                foreach ($quiz as $test) {

                    $question = $test->getQuestion();

                    echo "<div class='hide test'>";

                    echo "<h2 id='question'>$number. $question</h2>";

                    echo "<ul>";

                    foreach ($test->getChoices() as $choice) {
                        echo "<li>";
                        echo "<input onclick=\"addAnswer($number,'$choice')\" type='radio' name='choice' value='$choice'>";
                        echo "<label>$choice</label>";
                        echo "</li>";
                    }

                    echo "</ul>";
                    echo "</div>";

                    $number++;
                }
            } catch (Exception $e) {
                echo "No quiz found";
            }

            echo "</div>";
            echo "<button class='btn' id='submit' onclick=\"next()\">Submit</button>";
            ?>
        </div>
    </div>
    <script>
        let answers = [];
        let currentIndex = 0;
        const questions = document.querySelectorAll('.test');

        const header = document.querySelector('.quiz-header');
        const submit = document.querySelector('#submit');

        const addAnswer = (number, answer) => {
            answers[number - 1] = answer;
        }

        const next = async () => {

            if (currentIndex === questions.length) {
                let result = await processAnswer();
                header.innerHTML = "Your Score Is " + result;
                submit.classList.add('hide');
                return;
            }

            questions.forEach((question, index) => {

                question.classList.add('hide');

                if (currentIndex === index) {
                    question.classList.remove('hide');
                }
            })

            currentIndex++;
        }

        const processAnswer = async () => {
            try {

                let result = await fetch("./answers", {
                    method: "POST",
                    headers: {
                        'Content-Type': "application/json"
                    },
                    body: JSON.stringify({
                        quiz: quizId,
                        answers: answers,
                    })
                });

                const status = result.ok;
                result = await result.json();

                if (!status) throw new Error(result.message);

                return result.message
            } catch (error) {
                alert(error.message);
            }

        }

        next();
    </script>
</body>

</html>