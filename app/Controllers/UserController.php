<?php

namespace App\Controllers;

use App\Components\RestApiConnection;
use App\Models\User;

class UserController
{
    /**
     * Display the list of users.
     *
     * @return void
     */

    public function index()
    {
        $users = RestApiConnection::connect('https://gorest.co.in/public/v2/users', 'get');

        require VIEW_ROOT_USERS . 'index.php';
    }

    /**
     * Create new user.
     *
     * @return void
     */

    public function create()
    {
        if (isset($_POST['create'])) {
            RestApiConnection::$user_data = User::getValidatedParams($_POST);

            RestApiConnection::connect('post');

            var_dump(RestApiConnection::connect('post'));

            redirect(301, USER_ROOT_REF);
        }

        require VIEW_ROOT_USERS . 'create.php';
    }

    public function delete($user_id)
    {
        RestApiConnection::$user_data = ['id' => $user_id];

        RestApiConnection::connect("https://gorest.co.in/public/v2/users/$user_id", 'delete');

        redirect(301, $_SERVER['HTTP_REFERER']);
    }

    public function edit($user_id)
    {
        $user = User::getUserById($user_id);

        $userObj = new User();
        $statuses = User::$status;
        $genders = User::$gender;

        if (isset($_POST['edit'])) {
            RestApiConnection::$user_data = User::getValidatedParams($_POST);

            RestApiConnection::connect("https://gorest.co.in/public/v2/users/$user_id", 'put');

            redirect(301, USER_ROOT_REF);
        }
        require VIEW_ROOT_USERS . 'edit.php';
    }
}
