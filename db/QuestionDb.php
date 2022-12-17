<?php

namespace db;

require_once 'autoload.php';

use Exception;
use model\module\Quiz;
use model\module\Content;

class QuestionDb
{

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

        $stmt = $connection->prepare("INSERT INTO quiz(name,topic_id,content_id) values(?,?,?)");

        $stmt->bind_param(
            "sdd",
            $name,
            $topicId,
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

        $quizDataQuery = $connection->prepare("INSERT INTO quiz_data(quiz_id,question,answer) values(?,?,?)");

        foreach ($quiz->getQuiz() as $topic) {

            $question =  $topic->getQuestion();
            $answer =  $topic->getAnswer();

            $quizDataQuery->bind_param(
                "dss",
                $quizId,
                $question,
                $answer
            );

            $quizDataQuery->execute();

            $lastIdQuery = $connection->prepare("select last_insert_id() as id");

            $lastIdQuery->execute();

            //get result
            $result = $lastIdQuery->get_result();

            // store result in array
            $data = $result->fetch_assoc();

            //do not remove I know its redundant
            $quizData = $data['id'];

            foreach ($topic->getChoices() as $choice) {

                $quizChoiceQuery = $connection->prepare("INSERT INTO quiz_choice(choice,quiz_data,quiz_id) values(?,?,?)");
                $quizChoiceQuery->bind_param(
                    "sdd",
                    $choice,
                    $quizData,
                    $quizId
                );

                $quizChoiceQuery->execute();
            }
        }

        $error = mysqli_error($connection);
        Database::close($connection);
        return $error;
    }

    public static function appendQuiz(Content $content)
    {

        $id = $content->getTopics();

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT * FROM quiz WHERE topic_id = ?");

        $stmt->bind_param(
            "s",
            $id
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

        $quiz = new Quiz();
        $quiz->setId($data['id']);
        $quiz->setName($data['name']);
        $quiz->setContentId($data['content_id']);
        $quiz->setTopicId($data['topic_id']);

        $content->appendData($quiz);

        if ($error) {
            throw new Exception("An error has occured");
        }

        return $error;
    }

    private static function getChoices($id)
    {
        $connection = Database::open();

        $stmt = $connection->prepare("SELECT choice from quiz_choice where quiz_data = ?");

        $stmt->bind_param(
            "d",
            $id
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $choices = [];

        // store result in array
        while ($data = $result->fetch_assoc()) {
            $choice = $data['choice'];
            array_push($choices, $choice);
        }

        $error = mysqli_error($connection);

        Database::close($connection);

        return $choices;
    }

    public static function getQuiz($id)
    {

        $connection = Database::open();

        $stmt = $connection->prepare("SELECT question,answer,quiz_data.id from (quiz_data INNER join quiz_choice as choice on quiz_data.id = choice.quiz_data)  where choice.quiz_id = ?  GROUP by choice.quiz_data");

        $stmt->bind_param(
            "d",
            $id
        );

        $stmt->execute();

        //get result
        $result = $stmt->get_result();

        $quiz = new Quiz();

        $quiz->setType(1);
        $quiz->setTypeName("QUIZ");
        $quiz->setOrder(2);

        // store result in array
        while ($data = $result->fetch_assoc()) {
            $question = $data['question'];
            $answer = $data['answer'];

            $id = $data['id'];
            var_dump($id);
            $choices = QuestionDb::getChoices($id);

            $quiz->addQuestion($question, $answer, $choices);
        }

        $error = mysqli_error($connection);

        Database::close($connection);

        // if ($data == null) {
        //     throw new Exception('Empty Contents');
        // }

        return $quiz;
    }
}
