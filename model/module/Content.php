<?php

namespace model\module;

class Content
{

    private $id;
    private $title;
    private $name;
    private $description;
    private $order;
    private $type;
    private $typeName;
    private $location;
    
    
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
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

    public function getType() {
        return $this->type;
    }

    public function getTypeName() {
        return $this->typeName;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setTitle($title): void {
        $this->title = $title;
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

    public function setType($type): void {
        $this->type = $type;
    }

    public function setTypeName($typeName): void {
        $this->typeName = $typeName;
    }

    public function setLocation($location): void {
        $this->location = $location;
    }

}
