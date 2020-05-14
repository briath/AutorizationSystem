<?php


namespace vendor\core;

/*
 * Работа с bd.
 * Просто велосипед...
 */

class DB
{
    protected $pdo;
    protected static $_instance = null;
    protected $_count = 0;
    protected static $_queries = [];

    private function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        try {
            $this->pdo = new \PDO("mysql:host={$db['host']};dbname={$db['dbname']}", $db['user'], $db['pass'], $options);
        }catch (\PDOException $e){
            die($e->getMessage());
        }
    }

    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function execute($sql, $params = []){
        self::$_queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function query($sql, $params = []){
        self::$_queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if($res !== false){
            $this->_count = $stmt->rowCount();
            return $stmt->fetchAll();
        }
        return [];
    }

    public function getAssoc($sql, $params = []){
        self::$_queries[] = $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        $results = [];
        if($res !== false){
            foreach ($stmt->fetchAll() as $r){
                $results[array_shift($r)] = $r;
            }
        }
        return $results;
    }

    public function count(){
        return $this->_count;
    }

    public static function getQueries(){
        return self::$_queries;
    }

}