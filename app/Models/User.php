<?php

namespace App\Models;

use App\Components\Db;
use PDO;

class User
{
    protected int $id;
    protected string $name;
    protected string $email;
    protected string $gender;
    protected string $status;

    // GET METHODS
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getStatus(): string
    {
        return $this->status;
    }


    // SET METHODS
    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setGender(string $gender)
    {
        $this->gender = $gender;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    // VALIDATION

    public static function isNameValid(string $name)
    {
        return preg_match("/^([a-zA-Z]{2,}\s[a-zA-Z]{1,}'?-?[a-zA-Z]{2,}\s?([a-zA-Z]{1,})?)$/u", $name);
    }

    public static function isEmailValid(string $email): bool|int
    {
        return preg_match('/.+@.+\..+/', $email);
    }

    public static function isGenderValid(string $gender): bool
    {
        return $gender === 'male' || $gender === 'female';
    }

    public static function isStatusValid(string $status): bool
    {
        return $status === 'active' || $status === 'inactive';
    }

    // SELECT

    /**
     * Get user by id method.
     *
     * @param int $id
     *
     * @return mixed
     */
    public static function getUserById(int $id): mixed
    {
        $connect = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE id = :id';
        $result = $connect->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get exist user's status.
     *
     * @return array
     */
    public static function getUserStatus(): array
    {
        $connect = Db::getConnection();

        $results = $connect->query('SELECT DISTINCT status FROM users;');

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get exist user's gender.
     *
     * @return array
     */
    public static function getUserGender(): array
    {
        $connect = Db::getConnection();

        $results = $connect->query('SELECT DISTINCT gender FROM users;');

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check is user's fields are valid.
     *
     * @param array $obj
     *
     * @return array
     */

    public static function getValidatedParams(array $obj): array
    {
        ['name' => $name, 'email' => $email, 'status' => $status, 'gender' => $gender] = $obj;

        if (!self::isNameValid($name)) {
            throw new \InvalidArgumentException('Invalid user name!');
        }
        if (!self::isEmailValid($email)) {
            throw new \InvalidArgumentException('Invalid user email!');
        }
        if (!self::isGenderValid($gender)) {
            throw new \InvalidArgumentException('Invalid user gender!');
        }
        if (!self::isStatusValid($status)) {
            throw new \InvalidArgumentException('Invalid user status!');
        }

        return $obj;
    }

    // CRUD OPERATIONS

    /**
     * Create user method.
     *
     * @param string $name
     * @param string $email
     * @param string $gender
     * @param string $status
     *
     * @return mixed
     */

    public static function create(string $name, string $email, string $gender, string $status): mixed
    {
        $connect = Db::getConnection();

        $sql = 'INSERT INTO users (name, email, gender, status) VALUES (:name, :email, :gender, :status)';

        $result = $connect->prepare($sql);

        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':gender', $gender, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_STR);
        $result->execute();

        return $result->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Update user method.
     *
     * @param int    $id
     * @param string $name
     * @param string $email
     * @param string $gender
     * @param string $status
     *
     * @return bool
     */

    public static function update(int $id, string $name, string $email, string $gender, string $status): bool
    {
        $connect = Db::getConnection();

        $user = User::getUserById($id);

        $sql = 'UPDATE users SET name = :name, email = :email, gender = :gender, status = :status WHERE id = :user_id;';
        $result = $connect->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':gender', $gender, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_STR);
        $result->bindParam(':user_id', $user['id'], PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Delete user method.
     *
     * @param int $id
     *
     * @return bool
     */

    public static function delete(int $id): bool
    {
        $connect = Db::getConnection();

        $user = User::getUserById($id);

        $sql = 'DELETE FROM users WHERE id = :user_id;';
        $result = $connect->prepare($sql);
        $result->bindParam(':user_id', $user['id'], PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Read user method.
     *
     * @return array
     */

    public static function all(): array
    {
        $connect = Db::getConnection();

        $results = $connect->query('SELECT id, name, email, gender, status FROM users;');

        return $results->fetchAll(PDO::FETCH_ASSOC);
    }
}
