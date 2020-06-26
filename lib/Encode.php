<?php


class Encode
{
    public function encoder($var)
    {
        $var = htmlspecialchars($var);
        return $var;
    }

    public function checkVarIsEmpty($var)
    {
        if ($var != null)
            return $var;
        else
            return null;
    }
}