<?php

use db\Database;
use model\module\Content;
use model\module\Topic;

echo " File not found !";

$connection = Database::open();

$stmt = $connection->prepare("select topic.id, topic.title,con.name,con.description,con.order,ty.title as type_name,fl.location from topics as topic INNER JOIN content con on con.topics = topic.id INNER JOIN file fl on fl.topic_id = topic.id 
INNER JOIN type ty on ty.id = con.type
where topic.id = ? group by con.id");

$id = 7;

$stmt->bind_param(
    "s",
    $id
);

$stmt->execute();

//get result
$result = $stmt->get_result();

$contents = array();

while ($data = $result->fetch_assoc()) {

    $content = new Content();

    $content->setId($data['id']);
    $content->setTitle($data['title']);
    $content->setDescription($data['description']);
    $content->setOrder($data['order']);
    $content->setTypeName($data['type_name']);
    $content->setLocation($data['location']);

    array_push($contents, $content);
}

echo $contents[0]->getLocation();
// var_dump($contents[0]);

// try {
//     foreach ($contents as $content) {
        
//     }
// } catch (Exception $error) {
//     echo "no content found";
// }
