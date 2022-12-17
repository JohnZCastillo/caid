<?php

namespace model\module;

class File {

    private $id;
    private $location;
    private $topicId;
    private $contenId;
    
    public function getId() {
        return $this->id;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getTopicId() {
        return $this->topicId;
    }

    public function getContenId() {
        return $this->contenId;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setLocation($location): void {
        $this->location = $location;
    }

    public function setTopicId($topicId): void {
        $this->topicId = $topicId;
    }

    public function setContenId($contenId): void {
        $this->contenId = $contenId;
    }

}
