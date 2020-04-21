<?php


namespace vendor\core;


class Loader
{
    public function loadClass($class){
        $file = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
        if(is_file($file))
            require_once $file;
    }
}