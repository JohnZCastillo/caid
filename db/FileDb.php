<?php

namespace db;

require_once 'autoload.php';

use Exception;
use model\module\File;
use model\user\User;

class FileDb
{


    //register user to db
    public static function addFile(File $file)
    {

        $title = $file->getTitle();
        $order = $file->getOrder();
        $topicId = $file->getTopicId();
        $type = $file->getType();
        $location = $file->getLocation();

        $connection = Database::open();

        // insert into content
        $stmt = $connection->prepare("INSERT INTO content(name,`order`,topics,type) values (?,?,?,?)");

        $stmt->bind_param(
            "sddd",
            $title,
            $order,
            $topicId,
            $type
        );

        $stmt->execute();

        // insert to file
        $stmt = $connection->prepare("INSERT INTO file(location,topic_id) values (?,?)");

        $stmt->bind_param(
            "sd",
            $location,
            $topicId
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    
}
