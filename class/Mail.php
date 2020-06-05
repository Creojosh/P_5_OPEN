<?php


class Mail
{
    private $_host;
    private $_dbName;
    private $_username;
    private $_password;

    public function __construct()
    {
    $this->_host = 'localhost';
    $this->_dbName = 'test';
    $this->_username = 'root';
    $this->_password = '';
    }


    public function getUsername()
    {

    }
}