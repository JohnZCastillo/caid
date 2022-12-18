<?php

namespace db;

use Exception;
use model\module\File;
use DivisionByZeroError;
use model\module\Content;


session_start();

class MasteryDb
{

    public static function register($topicId, $step)
    {

        $userId = $_SESSION['userId'];

        $connection = Database::open();

        $stmt = $connection->prepare("INSERT INTO mastery(user_id,topic_id,step) values(?,?,?)");

        $stmt->bind_param(
            "sdd",
            $userId,
            $topicId,
            $step,
        );

        // execute prepared statement
        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    public static function hasCert($topicId, $step)
    {

        $userId = $_SESSION['userId'];

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * from mastery where user_id = ? and topic_id = ?	and step = ?");

        $stmt->bind_param(
            "sdd",
            $userId,
            $topicId,
            $step,
        );

        // execute prepared statement
        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        $hasCert = true;

        // throw an exception data is null that means email is not present in db
        if ($data == null) {
            $hasCert = false;
        }

        Database::close($connection);

        return $hasCert;
    }

    public static function getPercent($topicId)
    {

        $userId = $_SESSION['userId'];

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * from mastery where user_id = ? and topic_id = ?	group by step");

        $stmt->bind_param(
            "sd",
            $userId,
            $topicId
        );

        // execute prepared statement
        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $totalStep = 0;

        while ($result->fetch_assoc()) {
            $totalStep++;
        }

        $stmt = $connection->prepare("SELECT * from content where topics = ?");

        $stmt->bind_param(
            "d",
            $topicId
        );

        // execute prepared statement
        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $totalContent = 0;

        while ($data = $result->fetch_assoc()) {
            $totalContent++;
        }

        $error = mysqli_error($connection);

        Database::close($connection);

        try {
            return ($totalStep / $totalContent) * 100;
        } catch (DivisionByZeroError $e) {
            return 0;
        }
    }
}
