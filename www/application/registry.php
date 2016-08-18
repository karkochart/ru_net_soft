<?php
// Class storage
class Registry
{
    private static $_instance;
    private $_storage;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new Registry;
        }
        return self::$_instance;
    }

    // Save data
    public function __set($key, $val)
    {
        if (isset($this->_storage[$key]) == true) {
            throw new Exception('Unable to set var `' . $key . '`. Already set.');
        }
        $this->_storage[$key] = $val;
    }

    // Get data
    public function __get($key)
    {
        if (isset($this->_storage[$key])) {
            return $this->_storage[$key];
        }
        return false;
    }
}
