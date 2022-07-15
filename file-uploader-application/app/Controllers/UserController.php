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
    private int $weekToSec = 604800;
    private int $blockTime = 900;
    private int $limitedAttempts = 3;

    public function __construct()
    {
        $this->loader = new FilesystemLoader('./views/authentication');
        $this->twig = new Environment($this->loader);
    }

    public function index()
    {
        // timer functionality
        $leftTime = User::getLeftTime($this->blockTime);

        echo $this->twig->render('index.twig', [
            'diffTime' => $leftTime,
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

            // simple fields validation
            $fields = User::checkData($_POST);
            $loginAttemptsAcc = $_COOKIE['login_attempts'] ?? 0;
            if (!empty($fields)) {
                echo $this->twig->render('login.twig', [
                    'fields' => $fields,
                ]);
                die;
            }

            // check is user blocked show error, if else unblock user
            $lockedTime = Session::get('locked_time') ?? 0;
            $difference = time() - $lockedTime;
            if ($loginAttemptsAcc >= $this->limitedAttempts || $difference < $this->blockTime) {
                if (str_starts_with($_SERVER['REMOTE_ADDR'], Session::get('user_api'))) {
                    $attemptsError = 'Please wait for 15 minutes.';

                    echo $this->twig->render('login.twig', [
                        'error' => $attemptsError,
                    ]);
                    die;
                }
            } else {
                Session::delete(['locked_time', 'user_api', 'attacker_email']);
            }

            // if user is existed in bd log in, if not show error
            $user = User::getUserByEmail($email);
            if ($user) {
                if ($user['name'] === $name && $user['email'] === $email && (password_verify($password, $user['password']) || $password === $user['password'])) {
                    Session::set('email', $user['email']); // create session for previously registered user

                    User::rememberUser($check, $user['id'], $this->weekToSec);

                    redirect(301, ROOT_REF_FILE);
                } else {
                    // if attempts of log in is more than possible, block user
                    $login_attempts = $loginAttemptsAcc + 1;
                    setcookie('login_attempts', $login_attempts, time() + $this->blockTime);

                    User::blockByAttempts($login_attempts, $this->limitedAttempts, $email);

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
        $user_id = $_COOKIE['user_id'];

        User::forgetUser($user_id, $this->weekToSec);

        redirect(301, USER_ROOT_REF);
    }
}
