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

        $stmt = $connection->prepare("SELECT score,perfect from quiz_result where quiz_id = ? and user_id = ?  order by id desc LIMIT 1");

        $stmt->bind_param(
            "ds",
            $quizId,
            $userId
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($data === NULL) {
            return;
        }

        $stats = [];
        $stats['score'] =  $data['score'];
        $stats['perfect'] =  $data['perfect'];


        return $stats;
    }

    public static function getResultByStudent($quizId,  $userId)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT score,perfect from quiz_result where quiz_id = ? and user_id = ?  order by id desc LIMIT 1");

        $stmt->bind_param(
            "ds",
            $quizId,
            $userId
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($data === NULL) {
            return;
        }

        $stats = [];
        $stats['score'] =  $data['score'];
        $stats['perfect'] =  $data['perfect'];


        return $stats;
    }

    public static function getQuizIds()
    {

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT id from quiz");

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $ids = [];

        // store result in array
        while ($data = $result->fetch_assoc()) {
            $quizId = $data['id'];
            array_push($ids, $quizId);
        }

        $error = mysqli_error($connection);

        Database::close($connection);

        return $ids;
    }
}
