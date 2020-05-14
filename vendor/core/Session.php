<?php


namespace vendor\core;


class Session
{
    static public function start(){
        session_start();
    }

    static public function stop(){
        session_destroy();
    }

    static public function set($key, $value){
        $_SESSION[$key] = $value;
        return;
    }

    static public function delete($var){
        if(isset($_SESSION[$var])){
            unset($_SESSION[$var]);
        }
        return;
    }

    public static function get($name){
        return $_SESSION[$name];
    }

    public static function exists($name){
        return (isset($_SESSION[$name])) ? true: false;
    }

    public static function uagent_no_version(){
        $uagent = $_SERVER['HTTP_USER_AGENT'];
        $regx = '/\/[a-zA-Z0-9.]+/';
        $newString = preg_replace($regx, '', $uagent);
        return $newString;
    }
}