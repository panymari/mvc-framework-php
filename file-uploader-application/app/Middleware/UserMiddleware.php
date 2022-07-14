<?php

namespace App\Middleware;

use App\Components\Session;

class UserMiddleware
{
    public static function isAuthorized(string $name)
    {
        Session::start();
        if (!Session::get($name)) {
            redirect(301);
        }
    }
}
