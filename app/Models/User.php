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
     * @return array
     */

    public static function getValidatedParams(array $obj): array|string
    {
        ['email' => $email, 'name' => $name, 'password' => $password] = $obj;

        if (empty($email) && empty($name) && empty($password)) {
            return '';
        }

        if (!self::isNameValid($name)) {
            return 'Invalid name!';
        }
        if (!self::isEmailValid($email)) {
            return 'Invalid email!';
        }
        if (!self::isPasswordValid($password)) {
            return 'Invalid password!';
        }

        return $obj;
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

        $sql = 'INSERT INTO users (email, name, password) VALUES (:email, :name, :password)';

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
