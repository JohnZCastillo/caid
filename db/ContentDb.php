<?php

namespace db;

use Exception;
use model\module\Content;

class ContentDb {

    public static function addContent(Content $content) {

        $name = $content->getName();
        $description = $content->getDescription();
        $order = $content->getOrder();
        $type = $content->getType();
        $topics = $content->getTopics();

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

    public static function getContent($id) {
        
        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * FROM content WHERE topics = ?");

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
            
            $content->setId($id);
            $content->setName($data['name']);
            $content->setDescription($data['description']);
            $content->setOrder($data['order']);
            $content->setTopics($data['topics']);
            
            switch($data['type']){
                case 3: 
                    FileDb::appendFile($content);
                    break;
                case 4: 
                    FileDb::appendFile($content);
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
}
