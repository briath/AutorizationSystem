<?php


namespace vendor\core;

/*
 * Класс загружает данные в $properties методом setProperty.
 * Из любой точки программы пользователь может получить эти данные методом getProperty.
 */

class Registry
{
    protected static $_instance = null;
    protected static $properties = [];

    public static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new Registry();
        }
        return self::$_instance;
    }

    public static function setProperty($name, $value)
    {
        self::$properties[$name] = $value;
    }

    public static function getProperty($name)
    {
        if(isset(self::$properties[$name])){
            return self::$properties[$name];
        }
        return null;
    }
}