<?php

class CreatePDOSingleton
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $db='consilium';
        $host='localhost';
        $port=3307;
        $user='root';
        $passwd='';
        $options = 
        [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ];

        $this->pdo = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$db.'', $user, $passwd, $options);
    }

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = new CreatePDOSingleton();
        }

        return self::$instance;
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}
