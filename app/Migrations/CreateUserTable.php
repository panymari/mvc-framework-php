<?php

namespace App\Migrations;

use App\Components\Db;
use App\Components\Migration;
use PDOException;

class CreateUserTable extends Migration
{
    public const TABLE_NAME = 'users';

    public static function up()
    {
        $sql = 'CREATE TABLE `users`(' .
            'id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,' .
            'email VARCHAR(30) NOT NULL UNIQUE,' .
            'name VARCHAR(30) NOT NULL,' .
            'password VARCHAR(150) NOT NULL,' .
            'create_date DATE' .
            ')';

        (new Db())->getConnection()->query($sql);
        die;


        if (!self::tableExist(self::TABLE_NAME)) {
            try {
                (new Db())->getConnection()->query($sql);

                self::consoleMessage(printf('Table %s created successfully', self::TABLE_NAME));
            } catch (PDOException $exception) {
                self::consoleMessage($exception->getMessage());
            }
        } else {
            self::consoleMessage(printf('Table %s already exist', self::TABLE_NAME));
        }
    }

    public static function down()
    {
        if (self::tableExist(self::TABLE_NAME)) {
            self::deleteTable(self::TABLE_NAME);

            self::consoleMessage(printf('Table %s successfully deleted', self::TABLE_NAME));
        } else {
            self::consoleMessage(printf('Table %s already deleted', self::TABLE_NAME));
        }
    }
}
