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
            $name = $_POST['name'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $status = $_POST['status'];

            if (!User::isNameValid($name)) {
                throw new \InvalidArgumentException('Invalid user name!');
            }
            if (!User::isEmailValid($email)) {
                throw new \InvalidArgumentException('Invalid user email!');
            }
            if (!User::isGenderValid($gender)) {
                throw new \InvalidArgumentException('Invalid user gender!');
            }
            if (!User::isStatusValid($status)) {
                throw new \InvalidArgumentException('Invalid user status!');
            }

            $user = User::create($name, $email, $gender, $status);
            redirect(301, USER_ROOT_REF);
        }

        require VIEW_ROOT_USERS . 'create.php';
    }

    public function delete($user_id)
    {
        if (isset($_POST['delete'])) {
            User::delete($user_id);
        }
        redirect(301, USER_ROOT_REF);
    }

    public function edit($user_id)
    {
        $user = User::getUserById($user_id);

        if (isset($_POST['edit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $status = $_POST['status'];

            if (!User::isNameValid($name)) {
                throw new \InvalidArgumentException('Invalid user name!');
            }
            if (!User::isEmailValid($email)) {
                throw new \InvalidArgumentException('Invalid user email!');
            }
            if (!User::isGenderValid($gender)) {
                throw new \InvalidArgumentException('Invalid user gender!');
            }
            if (!User::isStatusValid($status)) {
                throw new \InvalidArgumentException('Invalid user status!');
            }

            User::update($user_id, $name, $email, $gender, $status);

            redirect(301, USER_ROOT_REF);
        }
        require VIEW_ROOT_USERS . 'edit.php';
    }
}
