<?php

namespace db;

use Exception;
use model\module\Content;

session_start();

class QuizResult
{

    public static function addQuiz($quizId, $score, $perfect)
    {

        $userId = $_SESSION['userId'];

        $connection = Database::open();

        $stmt = $connection->prepare("INSERT INTO quiz_result(user_id,quiz_id,score,perfect) values(?,?,?,?)");

        $stmt->bind_param(
            "sddd",
            $userId,
            $quizId,
            $score,
            $perfect
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    public static function getResult($quizId)
    {

        $userId = $_SESSION['userId'];

        $connection = Database::open();

        $stmt = $connection->prepare("INSERT INTO quiz_result(user_id,quiz_id,score,perfect) values(?,?,?,?)");

        $stmt->bind_param(
            "sddd",
            $userId,
            $quizId,
            $score,
            $perfect
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }
}
