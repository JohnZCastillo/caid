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
    // private static $servername = "sql104.epizy.com:3306";
    // private static $username = "epiz_33171096";
    // private static $password = "5pOXRaRFmSvVY4";
    // private static $database = "epiz_33171096_caidsa";

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
