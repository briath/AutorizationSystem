<?php


namespace vendor\core;


class Input
{
    /*
     * Возвращаем безопасные данные.
     */
    public static function sanitize($dirty){
        return htmlentities($dirty, ENT_QUOTES, "UTF-8");
    }

    /*
     * Получаем из массива POST или GET безопассные данные по ключу $input.
     */
    public static function get($input){
        if(isset($_POST[$input])){
            return self::sanitize($_POST[$input]);
        } elseif (isset($_GET[$input])) {
            return self::sanitize($_GET[$input]);
        }
    }
}