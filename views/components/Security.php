<?php

namespace views\components;

use model\user\Role;

error_reporting(0);

session_start();

class Security
{

    public static function isLogin()
    {
        return isset($_SESSION["isLogin"]);
    }

    public static function adminOnly()
    {
        if (!Security::isLogin()) {
            return false;
        }

        if (!($_SESSION['userRole'] === Role::$ADMIN)) {
            return false;
        }
        return true;
    }

    public static function userOnly()
    {
        if (!Security::isLogin()) {
            return false;
        }

        if (!($_SESSION['userRole'] === Role::$STUDENT)) {
            return false;
        }
        return true;
    }

    public static function adminOnlyStrict()
    {
        if (!Security::adminOnly()) {
            header("location: ./redirect");
            die();
        }
    }

    public static function studentOnlyStrict()
    {
        if (!Security::userOnly()) {
            header("location: ./redirect");
            die();
        }
    }
}
