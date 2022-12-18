<?php

use db\QuestionDb;


// Initialize URL to the variable
$id = $_REQUEST['id'];

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

                $quizData = QuestionDb::getQuiz($id);

                $quiz = $quizData->getQuiz();

                $number = 1;

                foreach ($quiz as $test) {

                    $question = $test->getQuestion();

                    echo "<div class='hide test'>";

                    echo "<h2 id='question'>$number. $question</h2>";

                    echo "<ul>";

                    foreach ($test->getChoices() as $choice) {
                        echo "<li>";
                        echo "<input type='radio' name='choice' value='$choice'>";
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
        let currentIndex = 0;
        const questions = document.querySelectorAll('.test');

        const next = () => {

            console.log(currentIndex);

            console.log(questions.length);

            if (currentIndex === questions.length) {
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

        next();
    </script>
</body>

</html>