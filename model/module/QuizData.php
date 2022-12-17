<?php

namespace model\module;

class QuizData {

    private $question;
    private $answer;
    private $choices;

    public function __construct() {
        $this->choices = array();
    }

    public function getQuestion() {
        return $this->question;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function getChoices() {
        return $this->choices;
    }

    public function setQuestion($question): void {
        $this->question = $question;
    }

    public function setAnswer($answer): void {
        $this->answer = $answer;
    }

    public function addChoices($choice): void {
        array_push($this->choices, $choice);
    }

    public function setChoices($choice): void {
        $this->choices = $choice;
    }

}
