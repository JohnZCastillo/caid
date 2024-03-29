<?php

namespace db;

use Exception;
use model\module\Content;
use model\module\File;

class FileDb
{

    public static function addFile(File $file)
    {

        //file name
        $location = $file->getLocation();
        $contentId = $file->getContenId();
        $topicId = $file->getTopicId();

        $connection = Database::open();

        // insert to file
        $stmt = $connection->prepare("INSERT INTO file(location,topic_id,content_id) values (?,?,?)");

        $stmt->bind_param(
            "sdd",
            $location,
            $topicId,
            $contentId
        );

        $stmt->execute();

        $error = mysqli_error($connection);

        Database::close($connection);

        return $error;
    }

    public static function getFile(Content $content)
    {

        $topicId = $content->getTopics();
        $contentId = $content->getId();

        // $topicId = 27;
        // $contentId = 77;

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * FROM file WHERE topic_id = ? and content_id = ?");

        $stmt->bind_param(
            "dd",
            $topicId,
            $contentId
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        $error = mysqli_error($connection);

        Database::close($connection);

        // throw an exception data is null that means username is not present in db
        if ($data == null) {
            throw new Exception('Empty Result');
        }

        $file = new File();

        $file->setId($data['id']);
        $file->setLocation($data['location']);
        $file->setTopicId($data['topic_id']);
        $file->setContenId($data['content_id']);

        if ($error) {
            throw new Exception("An error has occured");
        }

        return $file;
    }

    public static function deleteFile($topicId, $id, $step)
    {

        $connection = Database::open();

        // // delete mastery
        try {
            // Delete quiz_data
            $deleteMastery = $connection->prepare("Delete from mastery where topic_id = ? and step = ?");

            $deleteMastery->bind_param(
                "dd",
                $topicId,
                $step
            );

            $deleteMastery->execute();
        } catch (Exception $e) {
            // throw new Exception("Cant delete Mastery");
            throw new Exception($e->getMessage());
        }

        try {
            // delete file
            $deleteFile = $connection->prepare("Delete from file where content_id = ?");

            $deleteFile->bind_param(
                "d",
                $id
            );

            $deleteFile->execute();
        } catch (Exception $e) {
            throw new Exception("delete file error " . $e->getMessage());
        }


        try {
            // delete file
            $deleteContent = $connection->prepare("delete from content where id = ?");

            $deleteContent->bind_param(
                "d",
                $id
            );

            $deleteContent->execute();
        } catch (Exception $e) {
            throw new Exception("delete file error " + $e->getMessage());
        }

        $error = mysqli_error($connection);

        Database::close($connection);

        if ($error) {
            throw new Exception($error);
        }
        return $error;
    }
}
