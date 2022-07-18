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
        // timer functionality
        $leftTime = User::getLeftTime(BLOCK_TIME);

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
            if (User::isUserBlock()) {
                echo $this->twig->render('login.twig', [
                    'error' => ATTEMPTS_ERROR,
                ]);
                die;
            }

            // if user is existed in bd log in, if not show error
            $user = User::getUserByEmail($email);
            if (User::checkCredentials($user, $_POST)) {
                echo $this->twig->render('login.twig', [
                    'error' => LOGIN_ERROR,
                ]);
                die;
            }

        }
        if (!User::isUserSave()) {
            echo $this->twig->render('login.twig');
        }
    }


    public function logout()
    {
        $user_id = $_COOKIE['user_id'];

        User::forgetUser($user_id, WEEK_TO_SEC);

        redirect(301, USER_ROOT_REF);
    }
}
