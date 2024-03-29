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
    case $base . 'admin-module':
        require __DIR__ . '/views/admin/admin-module.php';
        break;
    case $base . 'register':
        require __DIR__ . '/controller/user/Signup.php';
        break;
    case $base . 'update-profile':
        require __DIR__ . '/controller/user/Profile.php';
        break;
    case $base . 'add-module':
        require __DIR__ . '/controller/topic/TopicAdd.php';
        break;
    case $base . 'student':
        require __DIR__ . '/views/sample.php';
        break;
    case $base . 'rewards':
        require __DIR__ . '/views/rewards.php';
        break;
    case $base . 'answers':
        require __DIR__ . '/controller/topic/Answers.php';
        break;
    case $base . 'login-data':
        require __DIR__ . '/views/admin/login-data.php';
        break;
    case $base . 'admin':
        require __DIR__ . '/views/admin/admin.php';
        break;
    case $base . 'test':
        require __DIR__ . '/views/admin/testme.php';
        break;
    case $base . 'admin-score':
        require __DIR__ . '/views/admin/admin-score.php';
        break;
    case $base . 'account':
        require __DIR__ . '/views/admin/account.php';
        break;
    case $base . 'accounts':
        require __DIR__ . '/views/admin/accounts.php';
        break;
    case $base . 'mastery':
        require __DIR__ . '/views/my-progess.php';
        break;
    case $base . 'admin-progress':
        require __DIR__ . '/views/admin/admin-progess.php';
        break;
    case $base . 'my-score':
        require __DIR__ . '/views/my-score.php';
        break;
    case $base . 'my-stats':
        require __DIR__ . '/views/my-stats.php';
        break;
    case $base . 'admin-mastery':
        require __DIR__ . '/views/admin/mastery.php';
        break;
    case $base . 'admin-stats':
        require __DIR__ . '/views/admin/admin-stats.php';
        break;
    case $base . 'logout':
        require __DIR__ . '/controller/user/Logout.php';
        break;
    case $base . 'my-rewards':
        require __DIR__ . '/views/my-rewards.php';
        break;
    case $base . 'redirect':
        require __DIR__ . '/controller/redirect/Redirect.php';
        break;
    case $base . 'admin-register':
        require __DIR__ . '/controller/user/Admin.php';
        break;
    case $base . 'signup-admin':
        require __DIR__ . '/views/admin/register.php';
        break;
    case $base . 'module-file':
        require __DIR__ . '/views/add-file.php';
        break;
    case $base . 'module-game':
        require __DIR__ . '/views/add-game.php';
        break;
    case $base . 'module-video':
        require __DIR__ . '/views/add-video.php';
        break;
    case $base . 'admin-reward':
        require __DIR__ . '/views/admin/admin-reward.php';
        break;
    case $base . 'quiz-maker':
        require __DIR__ . '/views/admin/admin-quiz.php';
        break;
    case $base . 'data':
        require __DIR__ . '/views/data.php';
        break;
    case $base . 'upload-game':
        require __DIR__ . '/controller/topic/Game.php';
        break;
    case $base . 'intro':
        require __DIR__ . '/views/intro.php';
        break;
    case $base . 'quiz-shower':
        require __DIR__ . '/views/quiz-shower.php';
        break;
    case $base . 'data?' . $_SERVER["QUERY_STRING"]:
        require __DIR__ . '/views/content-data.php';
        break;
    case $base . 'content-data?' . $_SERVER["QUERY_STRING"]:
        require __DIR__ . '/views/content-data.php';
        break;
    case $base . 'topic?' . $_SERVER["QUERY_STRING"]:
        require __DIR__ . '/views/content.php';
        break;
    case $base . 'intro?' . $_SERVER["QUERY_STRING"]:
        require __DIR__ . '/views/topic.php';
        break;
    case $base . 'topic?' . $_SERVER["QUERY_STRING"]:
        require __DIR__ . '/views/topic.php';
        break;
    case $base . 'quiz-shower?' . $_SERVER["QUERY_STRING"]:
        require __DIR__ . '/views/quiz-shower.php';
        break;
    case $base . 'testme':
        require __DIR__ . '/views/admin/testme.php';
        break;
    case $base . 'modules':
        require __DIR__ . '/views/components/Modules.php';
        break;
    case $base . 'sample':
        require __DIR__ . '/views/sample.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/error.php';
        break;
}
