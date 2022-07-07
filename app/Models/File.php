<?php

namespace App\Models;

use App\Components\Db;
use PDO;

class File
{
    protected int $id;
    protected string $file_name;
    protected string $type;
    protected string $size;

    // VALIDATION

    public static function isFormatValid(string $filename): bool
    {
        $allowed = ['txt', 'jpg'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return true;
        }

        return false;
    }

    // check is file is existed and if not create it

    public static function createFolder(string $folder)
    {
        if (!file_exists($folder)) {
            @mkdir($folder, 0777); //create folder in server
        }
    }


    // WRITE LOG FILE

    public static function writeLogFile(string $message, string $file_name, string $file_type, string $size)
    {

        //Something to write to txt log
        $log = date('F j, Y, g:i a').PHP_EOL.
            'Attempt: '. $message .PHP_EOL.
            'File name: '.$file_name.PHP_EOL.
            'Type: '.$file_type.PHP_EOL.
            'Size: '.$size.PHP_EOL.
            '-------------------------'.PHP_EOL;

        self::createFolder('logs/');

        //Save string to log, use FILE_APPEND to append.
        file_put_contents(LOGS_FOLDER . '/upload_'.date('d-m-Y').'.log', $log, FILE_APPEND);
    }

    // CRUD OPERATIONS

    /**
     * Create new file method.
     *
     * @param string $file_name
     * @param string $type
     * @param string $size
     *
     * @return mixed
     */

    public static function create(string $file_name, string $type, string $size): mixed
    {
        $connect = Db::getConnection();

        $sql = 'INSERT INTO files (file_name, type, size) VALUES (:file_name, :type, :size)';

        $result = $connect->prepare($sql);

        $result->bindParam(':file_name', $file_name, PDO::PARAM_STR);
        $result->bindParam(':type', $type, PDO::PARAM_STR);
        $result->bindParam(':size', $size, PDO::PARAM_STR);
        $result->execute();

        return $result->fetch(PDO::FETCH_OBJ);
    }


    /**
     * Read user method.
     *
     * @return array
     */

    public static function all(): array
    {
        $connect = Db::getConnection();

        $results = $connect->query('SELECT id, file_name, type, size FROM files;');

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
}
