<?php

namespace App\Components;

use PDOException;

/**
 * Relative Migration class.
 */
class Migration
{
    /**
     * Print the message into console.
     */
    public static function consoleMessage($message): void
    {
        echo $message . '<br>';
    }

    /**
     * Check if table exist in db.
     */
    public static function tableExist($name): bool
    {
        try {
            $results = (new Db())->getConnection()->query("SHOW TABLES LIKE '$name'");
        } catch (PDOException $exception) {
            echo $exception->getMessage() . "\n";
        }

        return $results->rowCount() > 0;
    }

    /**
     * Delete table by id.
     */
    public static function deleteTable($id)
    {
        try {
            (new Db())->getConnection()->query("DROP TABLE $id");

            self::consoleMessage('Table deleted successfully');
        } catch (PDOException $exception) {
            echo $exception->getMessage() . "\n";
        }
    }
}
