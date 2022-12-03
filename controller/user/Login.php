<?php

/* 
    
    Note: 
        This File handle login logic!

    Desription: 
        The File expect a JSON Object  with required username and password.
        failure to suppliment required field will result to an error. 
    
*/

//recieved json object
$json = file_get_contents('php://input');

// Converts recieved json to php object
$data = json_decode($json, true);

//check if recieved content contains username and password
//if not then return a 403 status code and an error message
if (!isset($data['username'], $data['password'])) {
    http_response_code(403);
    echo json_encode(['message' => "Username and Password are required"]);
    //prevent the code below from running
    die();
}

http_response_code(403);
echo json_encode(['message' => "login success"]);
