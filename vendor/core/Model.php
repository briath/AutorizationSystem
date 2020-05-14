<?php


namespace vendor\core;


class Model
{
    protected $pdo;
    protected $table;
    protected $pk;
    protected $_columnNames = [];

    public function __construct()
    {
        $this->pdo = DB::getInstance();
        $sql = "SHOW COLUMNS FROM {$this->table}";
        $columns =  $this->pdo->query($sql);
        foreach ($columns as $column){
            $this->_columnNames[] = $column['Field'];
            $this->{$column['Field']} = null;
        }
    }

    public function query($sql, $params = []){
        return $this->pdo->execute($sql, $params);
    }

    public function findAll(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    public function findFirst($id, $field = ''){
        $field = $field ? : $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        $res = $this->pdo->query($sql, [$id]);
        return isset($res[0])? $res[0]: false;
    }

    public function assign($params){
        if(!empty($params)){
            foreach ($params as $key => $value){
                if(in_array($key, $this->_columnNames)){
                    $this->$key = htmlentities($value, ENT_QUOTES, 'UTF-8'); //преобразовали символы
                }
            }
            return true;
        }
        return false;
    }

    public function save(){
        $fields =[];
        foreach ($this->_columnNames as $column){
            $fields[$column] = $this->$column;
        }

        if(property_exists($this, 'id') && $this->id != ''){
            return $this->update($this->id, $fields);
        } else {
            return $this->insert($fields);
        }
    }

    public function insert($fields){
        if(empty($fields)) return false;
        $fieldsString = '';
        $valueString = '';
        $values = [];

        foreach ($fields as $field => $value){
            $fieldsString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }
        $fieldsString = rtrim($fieldsString, ",");
        $valueString = rtrim($valueString, ",");
        $sql = "INSERT INTO {$this->table} ({$fieldsString}) VALUES ({$valueString})";
        return $this->query($sql, $values);
    }

    public function update($id, $fields){
        if(empty($fields) || $id == '') return false;
        $fieldString = '';
        $values = [];

        foreach ($fields as $field => $value){
            $fieldString .= ' ' . $field . ' = ?,';
            $values[] = $value;
        }
        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ',');
        $sql = "UPDATE {$this->table} SET {$fieldString} WHERE id = {$id}";
        return $this->query($sql, $values);
    }
}