<?php


class ServerObject
{
    public function method($key)
    {
        $server = filter_input(INPUT_SERVER, $key);
        return (isset($server) ? $server : null);
    }

    public function post($key)
    {
        $post = filter_input(INPUT_POST, $key);
        return (isset($post) ?  $post : null);
    }

    public function get($key)
    {
        $get = filter_input(INPUT_GET, $key);
        return (isset($get) ? $get : null);
    }

}