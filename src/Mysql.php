<?php

namespace pureTask;

use \Slim\PDO\Database;

final class Mysql
{
    /**
     * @var \Slim\PDO\Database
     */
    private static $instance;

    private function __construct(){}

    /**
     * Get Slim PDO Instance
     * @return Database
     */
    public static function getInstance(){

        if( self::$instance == null){
            $dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=utf8';
            self::$instance = new Database($dsn, USER, PASSWORD);
        }

        return self::$instance;
    }

}