<?php


namespace vendor\core;

/*
 * Вход приложения.
 */

class App
{

    public static $app;

    public function __construct()
    {

    }

    /*
     * Старт сессии.
     * Загружаем класс Registry.
     * В роутер добавляем пути.
     * Стартуем роутер.
     */
    static public function start(){

        Session::start();

        self::$app = Registry::getInstance();

//        Router::add('^main/?(?P<alias>[a-z-]+)?$', ['controller' => 'Main', 'action' => 'view']);
        Router::add('^main/?(?P<action>[a-z-]+)?/?(?P<alias>[a-z-]+)?$', ['controller' => 'Main']);
        Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
        Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

        Router::submit();
    }

}