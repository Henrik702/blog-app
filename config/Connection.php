<?php

namespace DB;


class Connection
{
    public static $_instance;

    public static function connect()
    {
        $host     = $_ENV['DB_HOST'];
        $user     = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        $db       = $_ENV['DB_NAME'];
        if (empty(self::$_instance)) {
            self::$_instance = mysqli_connect($host, $user, $password, $db);
        }

        if (mysqli_connect_errno()) {
            echo 'Connect error';
        }
        // charset
        mysqli_query(self::$_instance, "SET NAMES UTF8");
        date_default_timezone_set('Europe/Moscow');

        return self::$_instance;
    }
}