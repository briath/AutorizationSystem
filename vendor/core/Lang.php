<?php


namespace vendor\core;


class Lang
{

    public static $lang_data = [];
    public static $lang_layout = [];
    public static $lang_view = [];

    /*
     * Загружаем в массив $lang_data язык $code для страницы $view.
     * $code - язык.
     * $view - путь к странице.
     */
    public static function load($code, $view){
        $lang_view = APP . "/langs/{$code}/{$view['controller']}/{$view['action']}.php";
        if(file_exists($lang_view)){
            self::$lang_view = require $lang_view;
        }
        $lang_layout = APP . "/langs/{$code}.php";
        if(file_exists($lang_layout)){
            self::$lang_layout = require $lang_layout;
        }
        self::$lang_data = array_merge(self::$lang_layout, self::$lang_view);
    }

    /*
     * из массива $lang_data по ключу получаем нужный текст.
     */
    public static function get($key){
        return isset(self::$lang_data[$key]) ? self::$lang_data[$key] : $key;
    }

}