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


    // WRITE LOG FILE

    public static function writeLogFile()
    {
        $start_locked_time = date('d.m.Y H:i:s', Session::get('locked_time'));
        $diff = time() - Session::get('locked_time');
        $last = 900 - $diff;
        $end = $last + Session::get('locked_time');
        $end_locked_time = date('d.m.Y H:i:s', $end);

        $user_api = Session::get('user_api');

        $attacker_email = Session::get('attacker_email');

        //log attacker IP-address and email, start and end blocking period
        //Something to write to txt log
        $log = date('F j, Y, g:i a') . PHP_EOL .
            'IP-address: ' . $user_api . PHP_EOL .
            'email: ' . $attacker_email . PHP_EOL .
            'start period: ' . $start_locked_time . PHP_EOL .
            'block period: ' . $end_locked_time . PHP_EOL .
            '-------------------------' . PHP_EOL;

        createFolder(LOGS_FOLDER . '/');

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


    // SELECTS

    /**
     * Check if user is log in.
     *
     * @param string $email
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

    public static function getUserById(string $id): mixed
    {
        $connect = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE id = :id';
        $result = $connect->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_STR);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    // remember me method

    public static function rememberUser($check, $id)
    {
        if ($check === 'on') {
            setcookie('user_id', $id, time() + WEEK_TO_SEC);
        }
    }

    // forget me method

    public static function forgetUser($id, $sec)
    {
        Session::start();
        Session::delete('email');

        setcookie('user_id', $id, time() + $sec);
    }

    // block user if attempts is too much

    public static function blockByAttempts($login_attempts, $email)
    {
        if ($login_attempts >= LIMITED_ATTEMPTS) {
            Session::set('user_api', $_SERVER['REMOTE_ADDR']);
            Session::set('locked_time', time());
            Session::set('attacker_email', $email);

            self::writeLogFile();
        }
    }

    // get how much time is left for unblocking user

    public static function getLeftTime($blockTime)
    {
        Session::start();

        $difference = time() - Session::get('locked_time');
        $last = $blockTime - $difference;

        if ($difference > $blockTime) {
            $last = 0;
        }

        return $last;
    }

    // check is user block

    public static function isUserBlock()
    {
        $loginAttemptsAcc = $_COOKIE['login_attempts'] ?? 0;
        $lockedTime = Session::get('locked_time') ?? 0;
        $difference = time() - $lockedTime;

        $condition = ($loginAttemptsAcc >= LIMITED_ATTEMPTS || $difference < BLOCK_TIME)
            && str_starts_with($_SERVER['REMOTE_ADDR'], Session::get('user_api'));
        if ($condition) {
            return true;
        } else {
            Session::delete(['locked_time', 'user_api', 'attacker_email']);
        }
    }

    //check is user is saved in cookie

    public static function isUserSave()
    {
        if (isset($_COOKIE['user_id'])) {
            $user = User::getUserById($_COOKIE['user_id']);
            Session::set('email', $user['email']);
            redirect(301, ROOT_REF_FILE);
        } else {
            return false;
        }
    }

    //check credentials if there are wrong return true

    public static function checkCredentials($user, $userFromPost)
    {
        $check = $_POST['check'] ?? '';
        $loginAttemptsAcc = $_COOKIE['login_attempts'] ?? 0;

        if ($user) {
            $checkCredentials = $user['name'] === $userFromPost['name'] && $user['email'] === $userFromPost['email']
                && (password_verify($userFromPost['password'], $user['password']) || $userFromPost['password'] === $user['password']);
            if ($checkCredentials) {
                Session::set('email', $user['email']); // create session for previously registered user

                User::rememberUser($check, $user['id']);

                redirect(301, ROOT_REF_FILE);
            } else {
                // if attempts of log in is more than possible, block user
                $login_attempts = $loginAttemptsAcc + 1;
                setcookie('login_attempts', $login_attempts, time() + BLOCK_TIME);

                User::blockByAttempts($login_attempts, $userFromPost['email']);

                return true;
            }
        }
    }
}
