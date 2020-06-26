<?php


class ServerObject
{
    public static function method($key)
    {
        return (isset($_SERVER[$key]) ? $_SERVER[$key] : null);
    }
    public static function post($key)
    {
        return (isset($_POST[$key]) ? $_POST[$key] : null);
    }
    public static function get($key)
    {
        return (isset($_GET[$key]) ? $_GET[$key] : null);
    }

}