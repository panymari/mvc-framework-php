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

    public static function checkTheValidation(array $obj): string
    {
        ['email' => $email, 'name' => $name, 'password' => $password] = $obj;

        $fields = [];
        $status = true;

        if (!self::isNameValid($name)) {
            array_push($fields, 'name');
            $status = false;
        }
        if (!self::isEmailValid($email)) {
            array_push($fields, 'email');
            $status = false;
        }
        if (!self::isPasswordValid($password)) {
            array_push($fields, 'password');
            $status = false;
        }

        return json_encode(
            [
                'fields' => $fields,
                'status' => $status,
            ]
        );
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

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (email, name, password) VALUES (:email, :name, :hash_password)';

        $result = $connect->prepare($sql);

        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
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
        $result->bindParam(':email', $email, PDO::PARAM_INT);
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
