<?php

namespace App\Components;

class Session
{
    /**
     * Start session for log in user.
     *
     * @param string $name
     * @param string $value
     *
     * @return string
     */

    public static function set(string $name, string $value): string
    {
        $_SESSION[$name] = $value;

        return $_SESSION[$name];
    }

    /**
     * Get name value from session obj.
     *
     * @param $name
     *
     * @return mixed
     */
    public static function get($name): mixed
    {
        return $_SESSION[$name] ?? false;
    }

    /**
     * End the session.
     *
     * @param $name
     *
     * @return bool
     */
    public static function delete($name): bool
    {
        unset($_SESSION[$name]);
        session_destroy();

        return true;
    }

    /**
     * Start the session.
     */

    public static function start(): void
    {
        session_start();
    }
}
