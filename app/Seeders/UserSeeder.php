<?php

namespace App\Seeders;

use App\Components\Migration;
use App\Models\User;

class UserSeeder extends Migration
{
    public static function UserSeeder()
    {
        User::create('user1@test.com', 'John Jhones', password_hash('password1', PASSWORD_DEFAULT));
        User::create('user2@test.com', 'Jane Janes', password_hash('password1', PASSWORD_DEFAULT));
    }
}
