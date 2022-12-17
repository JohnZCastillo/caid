<?php

namespace db;

require_once 'autoload.php';

use model\module\Quiz;

class QuestionDb
{

    public static function addQuestion($questions, $topic, $name)
    {

        $description = "yow mama";
        $order = 2;
        $type = 4;

        $connection = Database::open();

        // insert into content
        $stmt = $connection->prepare("INSERT INTO content(name,description,`order`,topics,type) values (?,?,?,?,?)");

        $stmt->bind_param(
            "ssddd",
            $name,
            $description,
            $order,
            $topic,
            $type
        );

        $stmt->execute();

        
    
        
        $stmt = $connection->prepare("INSERT INTO quiz(name,topic_id) values(?,?)");

        $stmt->bind_param(
            "sd",
            $name,
            $topic
        );

        $stmt->execute();

        $stmt = $connection->prepare("select last_insert_id() as id");

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        //do not remove I know its redundant
        $quizId = $data['id'];

        $stmt = $connection->prepare("INSERT INTO quiz_data(quiz_id,question,answer) values(?,?,?)");

        foreach ($questions as $topic) {

            $question = $topic['question'];
            $answer = $topic['answer'];

            $stmt->bind_param(
                "dss",
                $quizId,
                $question,
                $answer
            );

            $stmt->execute();
        }

        $error = mysqli_error($connection);
        Database::close($connection);
        return $error;
    }

    public static function addQuiz(Quiz $quiz)
    {
        $name = $quiz->getName();
        $description = $quiz->getDescription();
        $type = $quiz->getType();
        $order = $quiz->getOrder();
        $topicId = $quiz->getTopicId();
        

        $connection = Database::open();

        // insert into content
        $stmt = $connection->prepare("INSERT INTO content(name,description,`order`,topics,type) values (?,?,?,?,?)");

        $stmt->bind_param(
            "ssddd",
            $name,
            $description,
            $order,
            $topicId,
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
        
        $quiz->setContentId($contentId);
        
        $stmt = $connection->prepare("INSERT INTO quiz(name,content_id) values(?,?)");

        $stmt->bind_param(
            "sd",
            $name,
           $contentId 
        );

        $stmt->execute();

        $stmt = $connection->prepare("select last_insert_id() as id");

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        // store result in array
        $data = $result->fetch_assoc();

        //do not remove I know its redundant
        $quizId = $data['id'];

        $quiz->setId($quizId);

        $stmt = $connection->prepare("INSERT INTO quiz_data(quiz_id,question,answer) values(?,?,?)");

        foreach ($quiz->getQuiz() as $topic) {

            $question =  $topic->getQuestion();
            $answer =  $topic->getAnswer();
            
            $stmt->bind_param(
                "dss",
                $quizId,
                $question,
                $answer
            );

            $stmt->execute();
        }

        $error = mysqli_error($connection);
        Database::close($connection);
        return $error;
    }
}
