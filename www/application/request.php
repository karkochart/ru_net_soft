<?php

class Request
{
    private $_controller;
    private $_method;
    private $_args;

    public function __construct()
    {
        $parts = array();
        if (isset($_SERVER['PATH_INFO'])) {
            $parts = explode("/", $_SERVER['PATH_INFO']);
        }
        $parts = array_filter($parts);
        $this->_controller = ($c = array_shift($parts)) ? $c : 'index';
        if ($this->_controller == $_SERVER['SERVER_NAME']) {
            $this->_controller = array_shift($parts);
        }
        $this->_method = ($c = array_shift($parts)) ? $c : 'index';

        $queryString = $_SERVER['QUERY_STRING'];
        parse_str($queryString, $this->_args);
    }

    public function getController()
    {
        return $this->_controller;
    }

    public function getMethod()
    {
        return $this->_method;
    }

    public function getArgs()
    {
        return $this->_args;
    }
}
