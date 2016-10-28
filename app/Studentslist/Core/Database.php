<?php

namespace Studentslist\Core;

/**
 * Класс подключения к базе данных
 */
class Database {

    private static $instance;
    private $pdo;

    private function __construct() {
        $dbOptions = [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode = 'STRICT_ALL_TABLES'"];
        $dbConfig = $this->parseConfig();
        $this->pdo = new \PDO("mysql:host={$dbConfig['db_host']};dbname={$dbConfig['db_name']};charset=utf8", 
                $dbConfig['db_user'], 
                $dbConfig['db_pass'], 
                $dbOptions);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    private function __clone() {}
      
    public static function getInstance() {
        if (empty(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }


    private function parseConfig() {
        return \parse_ini_file("../config.ini");
    }

    /**
     * Метод получения объекта класса PDO
     * @return PDO $pdo
     */
    public function getPDO() {
        return $this->pdo;
    }

}
