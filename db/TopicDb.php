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

        try {
            // delete file
            $stmt = $connection->prepare("Delete from file where topic_id = ?");

            $stmt->bind_param(
                "d",
                $id
            );

            $stmt->execute();
        } catch (Exception $e) {
        }

        try {

            // Select quiz id
            $stmt = $connection->prepare("select id from quiz where topic_id = ? LIMIT 1");

            $stmt->bind_param(
                "d",
                $id
            );

            $stmt->execute();

            //get result
            $result = $stmt->get_result();


            // store result in array
            $data = $result->fetch_assoc();

            if ($data == null) throw new Exception("Data null");


            $quizId = $data['id'];
        } catch (Exception $e) {
        }

        try {
            // Delete quiz_data
            $stmt = $connection->prepare("Delete from quiz_data where quiz_id = ?");

            $stmt->bind_param(
                "d",
                $quizId
            );

            $stmt->execute();
        } catch (Exception $e) {
        }

        try {
            // Delete quiz
            $stmt = $connection->prepare("Delete from quiz where topic_id = ?");

            $stmt->bind_param(
                "d",
                $id
            );

            $stmt->execute();
        } catch (Exception $e) {
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
