<?php

namespace controller\topic;

use Exception;
use db\QuestionDb;

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

if (isset($data['answers'], $data['quiz'])) {
    try {

        $id = $data['quiz'];

        $quizData = QuestionDb::getQuiz($id);
        $quiz = $quizData->getQuiz();
        $answers = $data['answers'];
        $count = 0;
        $score = 0;

        foreach ($quiz as $test) {

            if ($test->getAnswer() === $answers[$count]) {
                $score++;
            }

            $count++;
        }

        echo json_encode(['message' => $score]);
        die();
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
        die();
    }
}
