<?php

use \Slim\PDO\Database;

final class Mysql
{
    private static $instance;

    private function __construct(){}

    public static function getInstance(){

        if( self::$instance == null ){
            self::$instance = new \Slim\PDO\Database(DATABASE, USER, PASSWORD);
        }

        return self::instance;
    }

}