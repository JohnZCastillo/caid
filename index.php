<?php

// Act as a router.
// all incoming request will be sent to this file.

$request = $_SERVER['REQUEST_URI'];

require_once './autoload.php';

// folder inside htdocs.
// check htaccess.
$base = '/caid/';

// reroute request to views.
switch ($request) {
    case $base:
        require __DIR__ . '/views/home.php';
        break;
    case $base . 'signup':
        require __DIR__ . '/views/signup.php';
        break;
    case $base . 'login':
        require __DIR__ . '/views/login.php';
        break;
    case $base . 'auth':
        require __DIR__ . '/controller/user/Login.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/error.php';
        break;
}
