<?php

namespace db;

use Exception;
use model\module\Content;
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

    public static  function addContent(Content $content)
    {


        $id = $content->getId();
        $name = $content->getName();
        $description = $content->getDescription();
        $order = $content->getOrder();
        $type = $content->getType();

        //file name
        $fileLocation = $content->getLocation();

        $connection = Database::open();

        // insert into content
        $stmt = $connection->prepare("INSERT INTO content(name,description,`order`,topics,type) values (?,?,?,?,?)");

        $stmt->bind_param(
            "ssddd",
            $name,
            $description,
            $order,
            $id,
            $type
        );

        $stmt->execute();

        // insert to file
        $stmt = $connection->prepare("INSERT INTO file(location,topic_id) values (?,?)");

        $stmt->bind_param(
            "sd",
            $fileLocation,
            $id
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    //add topic to db
    public static function getContent($id)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("select topic.id, topic.title,con.name,con.description,con.order,ty.title as type,fl.location from topics as topic INNER JOIN content con on con.topics = topic.id INNER JOIN file fl on fl.topic_id = topic.id 
        INNER JOIN type ty on ty.id = con.type
        where topic.id = ?");

        $stmt->bind_param(
            "s",
            $id
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $content = array();

        while ($data = $result->fetch_assoc()) {


            $topic = new Topic($data['title']);

            // update id baso on db
            $topic->setId($data['id']);

            array_push($topics, $topic);
        }


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
