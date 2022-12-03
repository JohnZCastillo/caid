<?php

namespace db;

require_once 'autoload.php';

class Database
{

    public static function open()
    {

        $connection = mysqli_connect(
            Config::getServername(),
            Config::getUsername(),
            Config::getPassword(),
            Config::getDatabase()
        );

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        return $connection;
    }

    public static function close($connection)
    {
        $connection->close();
    }
}
