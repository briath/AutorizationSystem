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
                $route['controller'] = self::upperSimbols($route['controller']);
                self::$_route = $route;
                return true;
            }
        }
        return false;
    }

    /**
     * Принимает URL и перенаправляет на нужный контроллер
     * @param string $url - входящий url
     */
    public static function submit() {
        $url = self::removeQueryString($_SERVER['QUERY_STRING']);
        if(self::searchRoute($url)){
            $controller_name = 'app\controllers\\' . self::$_route['controller'] . 'Controller';
            if(class_exists($controller_name)){
                $controller = new $controller_name(self::$_route);
                $action = self::lowerSimbol(self::$_route['action']) . 'Action';
                if(method_exists($controller, $action)){
                    $controller->$action();
                    $controller->getView();
                } else {
                    http_response_code(404);
                    include '404.html';
                }
            } else {
                http_response_code(404);
                include '404.html';
            }
        } else {
            http_response_code(404);
            include '404.html';
        }
    }

    protected static function upperSimbols($name){
        return str_replace('-', '', ucwords($name, '-'));
    }

    protected static function lowerSimbol($name){
        return lcfirst(self::upperSimbols($name));
    }

    protected static function removeQueryString($url){
        if($url){
            $params = explode('&', $url, 2);
            if(false === strpos($params[0], '='))
                return rtrim($params[0], '/');
            else
                return '';
        }
        return $url;
    }

    public static function redirect($http = false){
        if($http){
            $redirect = $http;
        } else {
            $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
        }
        header("Location: $redirect");
        exit();
    }
}