<?php

namespace App\Components;

/**
 * Connect to api.
 */
class API
{
    private static $connect = null;

    public static function getParams()
    {
        return include_once realpath('./') . '\config\db.php';
    }

    public static function getConnection()
    {
        $params = self::getParams();

        //PDO
        if (self::$connect === null) {
            try {
                $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
                $db = new PDO($dsn, $params['user'], $params['password']);
                $db->exec('set names utf8');
                self::$connect = $db;
            } catch (\PDOException $exception) {
                echo $exception->getMessage();
            }
        }

        return self::$connect;
    }
}
