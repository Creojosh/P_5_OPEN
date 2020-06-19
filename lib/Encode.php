<?php


class Encode
{
    public function encoder($var)
    {
        $var = htmlspecialchars($var);
        return $var;
    }
}