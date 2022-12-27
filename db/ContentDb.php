<?php

namespace db;

use Exception;
use model\module\Content;

class ContentDb
{

    public static function addContent(Content $content)
    {

        $name = $content->getName();
        $description = $content->getDescription();
        $type = $content->getType();
        $topics = $content->getTopics();
        $order = ContentDb::getOrder($topics);


        $connection = Database::open();

        // insert into content
        $stmt = $connection->prepare("INSERT INTO content(name,description,`order`,topics,type) values (?,?,?,?,?)");

        $stmt->bind_param(
            "ssddd",
            $name,
            $description,
            $order,
            $topics,
            $type
        );

        $stmt->execute();

        $stmtId = $connection->prepare("select last_insert_id() as id");

        $stmtId->execute();

        //get result
        $result = $stmtId->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        $content->setId($data['id']);

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    public static function getContent($id)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * FROM content WHERE topics = ? order by `order`");

        $stmt->bind_param(
            "d",
            $id
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $contents = array();

        while ($data = $result->fetch_assoc()) {

            $content = new Content();

            $content->setId($data['id']);
            $content->setName($data['name']);
            $content->setDescription($data['description']);
            $content->setOrder($data['order']);
            $content->setTopics($data['topics']);
            $content->setType($data['type']);

            switch ($data['type']) {
                case 1:
                    $content->appendData(FileDb::getFile($content));
                    break;
                case 3:
                    $content->appendData(FileDb::getFile($content));
                    break;
                case 4:
                    $content->appendData(FileDb::getFile($content));
                    break;
                case 5:
                    $content->appendData(FileDb::getFile($content));
                    break;
            }

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

    public static function getFirstContent($id)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * FROM content WHERE topics = ? order by `order`");

        $stmt->bind_param(
            "d",
            $id
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $content = new Content();

        $content->setId($data['id']);
        $content->setName($data['name']);
        $content->setDescription($data['description']);
        $content->setOrder($data['order']);
        $content->setTopics($data['topics']);
        $content->setType($data['type']);

        switch ($data['type']) {
            case 1:
                $content->appendData(FileDb::getFile($content));
                break;
            case 3:
                $content->appendData(FileDb::getFile($content));
                break;
            case 4:
                $content->appendData(FileDb::getFile($content));
                break;
            case 5:
                $content->appendData(FileDb::getFile($content));
                break;
        }

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($content == null) {
            throw new Exception('Empty Contents');
        }

        if ($error) {
            throw new Exception("An error has occured");
        }

        return $content;
    }


    public static function getContentById($topicId, $contentId)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * FROM content WHERE topics = ? and id = ?");

        $stmt->bind_param(
            "dd",
            $topicId,
            $contentId
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();


        $data = $result->fetch_assoc();

        $content = new Content();

        $content->setId($data['id']);
        $content->setName($data['name']);
        $content->setDescription($data['description']);
        $content->setOrder($data['order']);
        $content->setTopics($data['topics']);
        $content->setType($data['type']);

        switch ($data['type']) {
            case 1:
                $content->appendData(FileDb::getFile($content));
                break;
            case 3:
                $content->appendData(FileDb::getFile($content));
                break;
            case 4:
                $content->appendData(FileDb::getFile($content));
                break;
            case 5:
                $content->appendData(FileDb::getFile($content));
                break;
        }


        $error = mysqli_error($connection);

        Database::close($connection);

        if ($content == null) {
            throw new Exception('Empty Contents');
        }

        if ($error) {
            throw new Exception("An error has occured");
        }

        return $content;
    }

    public static function getOrder($topicId)
    {
        $connection = Database::open();

        $stmt = $connection->prepare("SELECT count(id) as total FROM content WHERE topics = ?");

        $stmt->bind_param(
            "d",
            $topicId,
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();


        $data = $result->fetch_assoc();

        $order = $data['total'];

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($error) {
            throw new Exception("An error has occured");
        }

        return $order + 1;
    }

    public static function updateOrder($topicId, $contentId, $order)
    {
        $connection = Database::open();

        $stmt = $connection->prepare("update `content` set `order` = ? where id = ? and topics = ?");

        $stmt->bind_param(
            "ddd",
            $order,
            $contentId,
            $topicId
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($error) {
            throw new Exception("An error has occured");
        }

        return $error;
    }
}
