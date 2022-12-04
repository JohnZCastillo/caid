<?php

namespace db;

require_once 'autoload.php';

class Config
{

    // local development
    private static $servername = "127.0.0.1:3308";
    private static $username = "root";
    private static $password = "";
    private static $database = "caidsa";

    //configuration
//     private static $servername = "sql202.epizy.com";
//     private static $username = "epiz_33126141";
//     private static $password = "tVhCeR24pfyASFW";
//     private static $database = "epiz_33126141_caidsa";

    public static function getServername()
    {
        return self::$servername;
    }

    public static function getUsername()
    {
        return self::$username;
    }

    public static function getPassword()
    {
        return self::$password;
    }

    public static function getDatabase()
    {
        return self::$database;
    }
}
