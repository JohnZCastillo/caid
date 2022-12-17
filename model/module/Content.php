<?php

namespace model\module;

class Content {

    private $id;
    private $name;
    private $description;
    private $order;
    private $topics;
    private $type;
    private $data;

    public function __construct() {
        $this->data = array();
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getOrder() {
        return $this->order;
    }

    public function getTopics() {
        return $this->topics;
    }

    public function getType() {
        return $this->type;
    }

    public function getData() {
        return $this->data;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setDescription($description): void {
        $this->description = $description;
    }

    public function setOrder($order): void {
        $this->order = $order;
    }

    public function setTopics($topics): void {
        $this->topics = $topics;
    }

    public function setType($type): void {
        $this->type = $type;
    }

    public function appendData($data): void {
        array_push($this->data, $data);
    }

}
