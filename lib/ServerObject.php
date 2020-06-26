<?php


class ServerObject
{
    /**
     * @var array
     */
    protected $_post;

    /**
     * @var array
     */
    protected $_server;

    /**
     * @var array
     */
    protected $_get;

    public function __construct()
    {
        $this->_server = $_SERVER;
        $this->_post = $_POST;
        $this->_get = $_GET;
    }

    public function method($key)
    {
        return (isset($this->_server[$key]) ? $this->_server[$key] : null);
    }

    public function post($key)
    {
        return (isset($this->_post[$key]) ?  $this->_post[$key] : null);
    }

    public function get($key)
    {
        return (isset($this->_get[$key]) ? $this->_get[$key] : null);
    }

}