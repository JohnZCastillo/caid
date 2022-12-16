<?php

namespace model\module;

class Topic
{

    private $id;
    private $title;
    private $files = array();
    private $quizes = array();

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function addFile(File $file)
    {
        array_push($this->data, $file);
    }

    public function addQuiz(File $file)
    {
        array_push($this->data, $file);
    }

    public  function getFiles()
    {
        return $this->files;
    }
}
