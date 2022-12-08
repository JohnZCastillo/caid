<?php

namespace db;

use Exception;
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
