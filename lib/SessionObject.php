<?php


class SessionObject
{

    public function __construct()
    {
        session_start();
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        return (isset($_SESSION[$key]) ? $_SESSION[$key] : null);
    }

    public static function forget($key)
    {
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        $_SESSION = array();
        session_destroy();
    }
}