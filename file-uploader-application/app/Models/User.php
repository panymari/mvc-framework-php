<?php

namespace App\Models;

use App\Components\Db;
use App\Components\Session;
use PDO;

class User
{
    // VALIDATION

    public static function isNameValid(string $name): bool
    {
        return preg_match("/^([a-zA-Z]{2,}\s[a-zA-Z]{1,}'?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)$/u", $name);
    }

    public static function isEmailValid(string $email): bool
    {
        return preg_match('/.+@.+\..+/', $email);
    }

    public static function isPasswordValid(string $password): bool
    {
        return preg_match('/^(?=.*?[a-z])(?=.*?[0-9]).{8,}$/u', $password);
    }


    // SELECT

    /**
     * Check is user's fields are valid.
     *
     * @param array $obj
     *
     * @return string
     */

    public static function checkData(array $obj): array|string
    {
        ['email' => $email, 'name' => $name, 'password' => $password] = $obj;

        $fields = [];

        if (!self::isNameValid($name)) {
            array_push($fields, 'name');
        }
        if (!self::isEmailValid($email)) {
            array_push($fields, 'email');
        }
        if (!self::isPasswordValid($password)) {
            array_push($fields, 'password');
        }

        return $fields;
    }

    // check is file is existed and if not create it



    // WRITE LOG FILE

    public static function writeLogFile()
    {
        $start_locked_time = date('d.m.Y H:i:s', Session::get("locked_time"));
        $diff = time() - Session::get("locked_time");
        $last = 900 - $diff;
        $end = $last + Session::get("locked_time");
        $end_locked_time = date('d.m.Y H:i:s', $end);

        $user_api = Session::get("user_api");

        $attacker_email = Session::get("attacker_email");

        //log attacker IP-address and email, start and end blocking period
        //Something to write to txt log
        $log = date('F j, Y, g:i a') . PHP_EOL .
            'IP-address: ' . $user_api . PHP_EOL .
            'email: ' . $attacker_email . PHP_EOL .
            'start period: ' . $start_locked_time . PHP_EOL .
            'block period: ' . $end_locked_time . PHP_EOL .
            '-------------------------' . PHP_EOL;

        createFolder('logs/');

        //Save string to log, use FILE_APPEND to append.
        file_put_contents(LOGS_FOLDER . '/api-attack_' . date('d-m-Y') . '.log', $log, FILE_APPEND);
    }

    // CRUD OPERATIONS

    /**
     * Create user method.
     *
     * @param string $email
     * @param string $name
     * @param string $password
     *
     * @return mixed
     */

    public static function create(string $email, string $name, string $password): mixed
    {
        $connect = Db::getConnection();

        $password = password_hash($password, PASSWORD_DEFAULT);

        $created_date = date('Y-m-d H:i:s');

        $sql = 'INSERT INTO users (email, name, password, created_date) VALUES (:email, :name, :password, :created_date)';

        $result = $connect->prepare($sql);

        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':created_date', $created_date, PDO::PARAM_STR);

        $result->execute();

        return $result->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Check if user is log in.
     *
     * @param string $email
     * @param string $name
     * @param string $password
     *
     * @return mixed
     */

    public static function getUserByEmail(string $email): mixed
    {
        $connect = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE email = :email';
        $result = $connect->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public static function getUserFromSession(): mixed
    {
        return User::getUserByEmail(Session::get('email'));
    }
}
