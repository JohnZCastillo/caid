<?php

namespace controller\topic;

session_start();

require_once 'autoload.php';

use Exception;
use db\TopicDb;

// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json, true);

function addTopic()
{

    global $data;

    try {
        TopicDb::addTopic($data['title']);
        echo json_encode(['message' => 'ok']);
    } catch (Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => $e->getMessage()]);
    }
}

function isValid()
{
    global $data;

    if (isset($data['title'])) {
        return strlen($data['title']);
    }
    return false;
}

if (!isValid()) {
    http_response_code(401);
    echo json_encode(['message' => 'missing input']);
    die();
}

addTopic();
