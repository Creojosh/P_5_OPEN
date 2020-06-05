<?php


class Database
{
    private $_host;
    private $_dbName;
    private $_username;
    private $_password;

    public function __construct()
    {
    $this->_host = 'localhost';
    $this->_dbName = 'open_5';
    $this->_username = 'root';
    $this->_password = '';
    }

    public function dbConnect()
    {
        try {
            $db = new PDO('mysql:='.$this->_host.';dbname='.$this->_dbName.';charset=utf8', ''.$this->_username.'', ''.$this->_password.'');
            /** Set error reporting */
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $db->query('CREATE DATABASE IF NOT EXISTS '. $this->_dbName);
            return $db;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}