<?php

namespace db;

use Exception;
use model\module\Content;
use model\module\File;
use model\module\Topic;

require_once 'autoload.php';

class TopicDb
{

    //add topic to db
    public static function addTopic($id)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("INSERT INTO topics(title) values(?)");

        $stmt->bind_param(
            "s",
            $id
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    //add topic to db
    public static function deleteTopic($id)
    {

        $connection = Database::open();
        $quizId = -1;
        $quizIds = [];

        try {
            // delete file
            $deleteFile = $connection->prepare("Delete from file where topic_id = ?");

            $deleteFile->bind_param(
                "d",
                $id
            );

            $deleteFile->execute();
        } catch (Exception $e) {
            throw new Exception("delete file error");
        }


        try {

            // Select quiz id
            $getQuizId = $connection->prepare("select id from quiz where topic_id = ?");

            $getQuizId->bind_param(
                "d",
                $id
            );

            $getQuizId->execute();

            //get result
            $result = $getQuizId->get_result();

            // store result in array
            while ($data = $result->fetch_assoc()) {
                $currentId = $data['id'];
                array_push($quizIds, $currentId);
            }
        } catch (Exception $e) {
            throw new Exception("Cannot get quiz id");
        }

        foreach ($quizIds as $quizKey) {
            try {
                // Delete quiz_choice
                $deleteQuizChoice = $connection->prepare("Delete from quiz_choice where quiz_id = ?");

                $deleteQuizChoice->bind_param(
                    "d",
                    $quizKey
                );

                $deleteQuizChoice->execute();
            } catch (Exception $e) {
                throw new Exception("Cant delete Quiz Choice");
            }

            try {
                // Delete quiz_data
                $deleteQuizData = $connection->prepare("Delete from quiz_data where quiz_id = ?");

                $deleteQuizData->bind_param(
                    "d",
                    $quizKey
                );

                $deleteQuizData->execute();
            } catch (Exception $e) {
                throw new Exception("$quizId Cant delete Quiz Data");
            }

            // delete result 
            try {

                $ids = [];

                $selectIds = $connection->prepare("SELECT quiz_result.id from ((quiz_result JOIN quiz as qz on quiz_result.quiz_id = qz.id )JOIN content as cn on qz.content_id = cn.id) where cn.topics = ?");

                $selectIds->bind_param(
                    "d",
                    $id
                );

                // execute prepared statement
                $selectIds->execute();

                //get result
                $result =  $selectIds->get_result();

                while ($data = $result->fetch_assoc()) {
                    array_push($ids, $data['id']);
                }

                // Delete quiz_data
                $deleteQuizData = $connection->prepare("DELETE from quiz_result WHERE id = ?");

                foreach ($ids as $currentId) {

                    $deleteQuizData->bind_param(
                        "d",
                        $currentId
                    );

                    $deleteQuizData->execute();
                }
            } catch (Exception $e) {
                throw new Exception("$id Cant delete result");
            }
        }

        // delete mastery
        try {
            // Delete quiz_data
            $deleteMastery = $connection->prepare("Delete from mastery where topic_id = ?");

            $deleteMastery->bind_param(
                "d",
                $id
            );

            $deleteMastery->execute();
        } catch (Exception $e) {
            throw new Exception("Cant delete Mastery");
        }

        try {
            // Delete quiz
            $deleteQuiz = $connection->prepare("Delete from quiz where topic_id = ?");

            $deleteQuiz->bind_param(
                "d",
                $id
            );

            $deleteQuiz->execute();
        } catch (Exception $e) {
            throw new Exception("$id Cant delete quiz" . $e->getMessage());
        }


        try {

            // delete content
            $stmt = $connection->prepare("Delete from content where topics = ?");

            $stmt->bind_param(
                "d",
                $id
            );

            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception("Cant delete quiz");
        }


        // Delete topic
        $stmt = $connection->prepare("Delete from topics where id = ?");

        $stmt->bind_param(
            "d",
            $id
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($error) {
            throw new Exception($error);
        }
        return $error;
    }

    public static function getAllTopics()
    {

        // open database connection
        $conn = Database::open();

        $stmt = $conn->prepare("SELECT * FROM topics");

        // execute prepared statement
        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $topics = array();

        while ($data = $result->fetch_assoc()) {
            $topic = new Topic($data['title']);

            // update id baso on db
            $topic->setId($data['id']);

            array_push($topics, $topic);
        }

        Database::close($conn);

        // throw an exception data is null that means username is not present in db
        if ($topics == null) {
            throw new Exception('Empty Topics');
        }

        return $topics;
    }
}
