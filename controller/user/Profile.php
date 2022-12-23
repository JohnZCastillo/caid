<?php

namespace controller\user;

session_start();

use db\UserDb;
use Exception;

require_once 'autoload.php';

try {

    // throw an error if image is missing
    if (!isset($_FILES['sample_image'])) {
        throw new Exception("Missing Image");
    }

    // throw an error if user is not login
    if (!isset($_SESSION['userId'])) {
        throw new Exception('userid not found');
    }

    // path where images will ba saved
    $imagePath = './assets/profile/';

    $extension = pathinfo($_FILES['sample_image']['name'], PATHINFO_EXTENSION);
    $imageName = $_SESSION['userId'] . '.' . $extension;

    move_uploaded_file($_FILES['sample_image']['tmp_name'], $imagePath . $imageName);

    $id =  $_SESSION['userId'];
    // update user profile in db 

    //updat user profile in db
    UserDb::updateUserProfile($id, $imageName);

    //udpate session profile
    $_SESSION['userProfile'] = $imageName;

    //return profile name
    echo json_encode(['message' => $imageName]);
    die();
} catch (Exception $e) {
    http_response_code(403);
    echo json_encode(['message' => $e->getMessage()]);
}
