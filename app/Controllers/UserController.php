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
        echo $this->twig->render('index.twig');
    }

    /**
     * Method to log in a previously registered user.
     *
     * @return void
     */

    public function login()
    {
        if (isset($_POST['submit'])) {
            ['email' => $email, 'name' => $name, 'password' => $password] = $_POST;

            if (is_string(User::getValidatedParams($_POST))) {
                $error = User::getValidatedParams($_POST);
                echo $this->twig->render('logIn.twig', [
                    'error' => $error,
                ]);
                die;
            }
            $user = User::getUserByEmail($email);
            if ($user) {
                if ($user['name'] === $name && $user['email'] === $email && password_verify($password, $user['password'])) {
                    Session::start();
                    Session::set('email', $user['email']); // create session for previously registered user

                    redirect(301, USER_PROFILE_REF);
                }
            } else {
                $error = 'Login is incorrect.';
                echo $this->twig->render('logIn.twig', [
                    'error' => $error,
                ]);
                die;
            }
        }
        echo $this->twig->render('logIn.twig');
    }

    public function profile()
    {
        Session::start();
        $user = User::getUserFromSession(); // get user from session
        $message = 'Welcome back, ' . $user['name'] . '!';
        echo $this->twig->render('profile.twig', [
            'message' => $message,
        ]);
    }

    public function logout()
    {
        Session::start();
        Session::delete('email');

        redirect(301, USER_ROOT_REF);
    }
}
