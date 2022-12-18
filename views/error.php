<?php

use db\FileDb;
use db\QuestionDb;
use model\module\Content;

// echo " File not found !";

$quizData = QuestionDb::getQuiz(44);

$quiz = $quizData->getQuiz();

foreach ($quiz as $test) {

    $question = $test->getQuestion();

    echo "<div>Question: $question</div>";

    foreach ($test->getChoices() as $choice) {
        echo "<div>Choice: $choice</div>";
    }
}
