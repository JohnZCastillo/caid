<?php

namespace model\module;

class Quiz{
    
    private $id;
    private $topicId;
    private $contentId;
    private $order;
    private $type;
    private $typeName;
    private $name;
    private $description;
    
    private $quiz;
    
    public function __construct() {
        $this->quiz = array();
    }
    
    public function addQuestion($question,$answer,$choices){
        
        $data = new QuizData();
        $data->setQuestion($question);
        $data->setAnswer($answer);
        $data->setChoices($choices);
                
        array_push($this->quiz,$data);
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTopicId() {
        return $this->topicId;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getType() {
        return $this->type;
    }

    public function getTypeName() {
        return $this->typeName;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getQuiz(){
        return $this->quiz;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setTopicId($topicId): void {
        $this->topicId = $topicId;
    }

    public function setOrder($order): void {
        $this->order = $order;
    }

    public function setType($type): void {
        $this->type = $type;
    }

    public function setTypeName($typeName): void {
        $this->typeName = $typeName;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }
    public function getContentId() {
        return $this->contentId;
    }

    public function setContentId($contentId): void {
        $this->contentId = $contentId;
    }

}
