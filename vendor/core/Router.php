<?php

namespace vendor\core;

class Router
{
    /**
     * @var array $_routes - маршруты
     * @var array $_route - текущий маршрут
     */
    protected static $_routes = [];
    protected static $_route = [];

    /**
     * Заполняем таблицу маршрутов
     * @param $url - регулярное выражение
     * @param array $route - маршрут
     */
    public static function add($url, $route = []) {
        self::$_routes[$url] = $route;
    }

    public static function getRoutes() {
        return self::$_routes;
    }

    public static function getRoute() {
        return self::$_route;
    }

    /**
     * функция производит поиск маршрутов и возвращает boolean
     * @param $url - входящий url
     */
    protected static function searchRoute($url){
        foreach (self::$_routes as $patter => $route){
            if(preg_match("#$patter#i", $url, $res)){
                foreach ($res as $k => $v){
                    if(is_string($k)){
                        $route[$k] = $v;
                    }
                }
                if(!isset($route['action']))
                    $route['action'] = 'index';

                self::$_route = $route;
                debug(self::$_route);
                return true;
            }
        }
        return false;
    }

    /**
     * Принимает URL и перенаправляет на нужный контроллер
     * @param string $url - входящий url
     */
    public static function submit($url) {
        if(self::searchRoute($url)){
            $controller_name = 'app\controllers\\' . self::upperSimbols(self::$_route['controller']);
            if(class_exists($controller_name)){
                $controller = new $controller_name;
                $action = self::lowerSimbol(self::$_route['action']) . 'Action';
                if(method_exists($controller, $action)){
                    $controller->$action();
                } else {
                    echo 'error1';
                }
            } else {
                echo 'error';
            }
        } else {
            http_response_code(404);
            echo 404;
            #include '404.html';
        }
    }

    protected static function upperSimbols($name){
        return str_replace('-', '', ucwords($name, '-'));
    }

    protected static function lowerSimbol($name){
        return lcfirst(self::upperSimbols($name));
    }
}