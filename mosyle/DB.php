<?php

namespace Mosyle;

class DB
{

    private static $instance;

    public static function init($config)
    {
        if (!self::$instance) {
            self::$instance = new \PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'],
                $config['user'],
                $config['password']
            );
            self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function pdo()
    {
        return self::$instance;
    }

}