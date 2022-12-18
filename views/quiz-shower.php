<?php

use db\QuestionDb;

// Initialize URL to the variable
$id = $_REQUEST['id'];

$quizData = QuestionDb::getQuiz($id);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="/CAIDSA/CSS/Topics.css">

</head>

<body>

    <style>
        body {
            background-image: none;
            background-color: transparent;
        }

        .hide {
            display: none;
        }

        .quiz-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px 2px black;
            width: 600px;
            margin-top: 0;
            text-align: center;
            margin-left: 0;
        }
    </style>

    <div class="quiz-container" id="quiz">
        <div class="quiz-header">

            <?php

            try {

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
            echo "<button id='submit' onclick=\"next()\">Submit</button>";
            ?>
        </div>
    </div>
    <script>
        let answers = [];
        let currentIndex = 0;
        const questions = document.querySelectorAll('.test');

        const addAnswer = (number, answer) => {
            console.log(number, answer);
            answers[number - 1] = answer;
            console.log(answers);
        }

        const next = () => {

            console.log(currentIndex);

            console.log(questions.length);

            if (currentIndex === questions.length) {
                processAnswer();
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

                alert(result.message);
                window.location.reload();
            } catch (error) {
                alert(error.message);
            }

        }

        next();
    </script>
</body>

</html>