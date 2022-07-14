<?php

namespace App\Controllers;

use App\Components\Session;
use App\Models\User;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class UserController
{
    private FilesystemLoader $loader;
    protected Environment $twig;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('./views/authentication');
        $this->twig = new Environment($this->loader);
    }

    public function index()
    {
        Session::start();

        $diff = time() - Session::get('locked_time');
        $last = 900 - $diff;

        if ($diff > 900) {
            $last = 0;
        }

        echo $this->twig->render('index.twig', [
            'diffTime' => $last,
        ]);
    }

    public function signup()
    {
        if (isset($_POST['submit'])) {
            ['email' => $email, 'name' => $name, 'password' => $password] = $_POST;
            $fields = User::checkData($_POST);
            if (!empty($fields)) {
                echo $this->twig->render('signup.twig', [
                    'fields' => $fields,
                ]);
                die;
            }
            $user = User::getUserByEmail($email);
            if ($user) {
                $error = 'This user have already registered.';
                echo $this->twig->render('signup.twig', [
                    'error' => $error,
                ]);
                die;
            } else {
                User::create($email, $name, $password);
                Session::start();
                Session::set('email', $email); // create session for user

                redirect(301, ROOT_REF_FILE);
            }
        }
        echo $this->twig->render('signup.twig');
    }

    /**
     * Method to log in a previously registered user.
     *
     * @return void
     */

    public function login()
    {
        Session::start();

        if (isset($_POST['submit'])) {

            ['email' => $email, 'name' => $name, 'password' => $password] = $_POST;

            $check = $_POST['check'] ?? '';

            $fields = User::checkData($_POST);
            $loginAttemptsAcc = $_COOKIE['login_attempts'] ?? 0;
            if (!empty($fields)) {
                echo $this->twig->render('login.twig', [
                    'fields' => $fields,
                ]);
                die;
            }

            $lockedTime = Session::get('locked_time') ?? 0;
            $difference = time() - $lockedTime;
            if ($loginAttemptsAcc >= 3 || $difference < 900) {
                if (str_starts_with($_SERVER['REMOTE_ADDR'], Session::get('user_api'))) {
                    $attemptsError = 'Please wait for 15 minutes.';

                    echo $this->twig->render('login.twig', [
                        'error' => $attemptsError,
                    ]);
                    die;
                }
            } else {
                Session::delete('locked_time');
                Session::delete('user_api');
                Session::delete('attacker_email');
            }

            $user = User::getUserByEmail($email);
            if ($user) {
                if ($user['name'] === $name && $user['email'] === $email && (password_verify($password, $user['password']) || $password === $user['password'])) {
                    Session::set('email', $user['email']); // create session for previously registered user
                    if ($check === 'on') {
                        $weekToSec = 604800;
                        setcookie('user_id', $user['id'], time() + $weekToSec);
                    }

                    redirect(301, ROOT_REF_FILE);
                } else {
                    $login_attempts = $loginAttemptsAcc + 1;
                    $seconds = 900; // 15 minutes
                    setcookie('login_attempts', $login_attempts, time() + $seconds);

                    if ($login_attempts >= 3) {
                        Session::set('user_api', $_SERVER['REMOTE_ADDR']);
                        Session::set('locked_time', time());
                        Session::set('attacker_email', $email);

                        User::writeLogFile();
                    }

                    $error = 'Login is incorrect.';
                    echo $this->twig->render('login.twig', [
                        'error' => $error,
                    ]);
                    die;
                }
            }
        }
        if (isset($_COOKIE['user_id'])) {
            $user = User::getUserById($_COOKIE['user_id']);
            Session::set('email', $user['email']);
            redirect(301, ROOT_REF_FILE);
        } else {
            echo $this->twig->render('login.twig');
        }
    }


    public function logout()
    {
        Session::start();
        Session::delete('email');

        redirect(301, USER_ROOT_REF);
    }
}
