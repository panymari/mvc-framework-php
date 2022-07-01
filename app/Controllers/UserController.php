<?php

namespace App\Controllers;

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
        $users = User::all();
        $statuses = User::getUserStatus();

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
            ['name' => $name, 'email' => $email, 'status' => $status, 'gender' => $gender] = User::getValidatedParams($_POST);

            $user = User::create($name, $email, $gender, $status);

            redirect(301, USER_ROOT_REF);
        }

        require VIEW_ROOT_USERS . 'create.php';
    }

    public function delete($user_id)
    {
        User::delete($user_id);

        redirect(301, $_SERVER['HTTP_REFERER']);
    }

    public function edit($user_id)
    {
        $user = User::getUserById($user_id);
        $statuses = User::getUserStatus();
        $genders = User::getUserGender();

        if (isset($_POST['edit'])) {
            ['name' => $name, 'email' => $email, 'status' => $status, 'gender' => $gender] = User::getValidatedParams($_POST);

            User::update($user_id, $name, $email, $gender, $status);

            redirect(301, USER_ROOT_REF);
        }
        require VIEW_ROOT_USERS . 'edit.php';
    }
}
