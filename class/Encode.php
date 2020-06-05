<?php


class Encode
{
    public function encoder($var)
    {
        $var = strip_tags(htmlspecialchars($var));
        return $var;
    }
}