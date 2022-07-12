<?php

namespace App\Migrations;

use App\Components\Db;
use App\Components\Migration;
use PDOException;

class CreateFilesTable extends Migration
{
    public const TABLE_NAME = 'files';

    public static function up()
    {
        $sql = 'CREATE TABLE `files`(' .
            'id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,' .
            'file_name VARCHAR(100) NOT NULL,' .
            'type VARCHAR(100) NOT NULL,' .
            'size VARCHAR(100) NOT NULL' .
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
