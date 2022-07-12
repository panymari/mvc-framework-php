<?php

namespace App\Seeders;

use App\Components\Migration;
use App\Models\User;

class UserSeeder extends Migration
{
    public static function UserSeeder()
    {
        User::create('Maria Ivanova', 'user1@mail.ru', 'female', 'active');
        User::create('Oleg Andreychuk', 'user2@mail.ru', 'male', 'inactive');
        User::create('Alex Black', 'user3@mail.ru', 'male', 'active');
        User::create('Alexandra Green', 'user4@mail.ru', 'female', 'inactive');
        User::create('Olga Petrova', 'user5@mail.ru', 'female', 'active');
        User::create('Valery Korolev', 'user6@mail.ru', 'male', 'inactive');
        User::create('Eugene Yellow', 'user7@mail.ru', 'male', 'active');
        User::create('Dana Blue', 'user8@mail.ru', 'female', 'active');
    }
}
