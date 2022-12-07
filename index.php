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
        require __DIR__ . '/views/login.php';
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
    case $base . 'register':
        require __DIR__ . '/controller/user/Signup.php';
        break;
    case $base . 'update-profile':
        require __DIR__ . '/controller/user/Profile.php';
        break;
    case $base . 'student':
        require __DIR__ . '/views/student.php';
        break;
    case $base . 'admin':
        require __DIR__ . '/views/admin.php';
        break;
    case $base . 'account':
        require __DIR__ . '/views/admin-account.php';
        break;
    case $base . 'logout':
        require __DIR__ . '/controller/user/Logout.php';
        break;
    case $base . 'redirect':
        require __DIR__ . '/controller/redirect/Redirect.php';
        break;
    case $base . 'admin-register':
        require __DIR__ . '/controller/user/Admin.php';
        break;
    case $base . 'singup-admin':
        require __DIR__ . '/views/admin-register.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/error.php';
        break;
}
