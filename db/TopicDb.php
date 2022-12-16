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

    //add topic to db
    public static function deleteTopic($id, $contentId)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("Delete from file where content_id = ?");

        $stmt->bind_param(
            "d",
            $contentId
        );

        $stmt->execute();

        $stmt = $connection->prepare("Delete from content where topics = ?");

        $stmt->bind_param(
            "d",
            $id
        );

        $stmt->execute();

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

        $stmt = $connection->prepare("select last_insert_id() as id");

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        //do not remove I know its redundant
        $contentId = $data['id'];

        // insert to file
        $stmt = $connection->prepare("INSERT INTO file(location,topic_id,content_id) values (?,?,?)");

        $stmt->bind_param(
            "sdd",
            $fileLocation,
            $id,
            $contentId
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

        $stmt = $connection->prepare("select  tp.id, tp.title,content.id as contentId,content.name,content.description,content.order,
        ty.title as type_name,fl.location, fl.content_id from (((content INNER JOIN file fl on content.id = fl.content_id) INNER JOIN topics tp on content.topics = tp.id) INNER JOIN type ty on content.type = ty.id) WHERE content.topics = ?");

        $stmt->bind_param(
            "s",
            $id
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $contents = array();

        while ($data = $result->fetch_assoc()) {

            $content = new Content();
            $content->setContentId($data['contentId']);
            $content->setId($data['id']);
            $content->setName($data['name']);
            $content->setTitle($data['title']);
            $content->setDescription($data['description']);
            $content->setOrder($data['order']);
            $content->setTypeName($data['type_name']);
            $content->setLocation($data['location']);

            array_push($contents, $content);
        }

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($contents == null) {
            throw new Exception('Empty Contents');
        }

        if ($error) {
            throw new Exception("An error has occured");
        }
        return $contents;
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
