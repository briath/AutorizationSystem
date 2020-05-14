<?php

namespace app\controllers;


use vendor\core\App;
use vendor\core\Router;

/*
 * Controller смены языка.
 * Меняем язык и записываем в куки язык, который будет действовать
 */

class LanguageController extends AppController
{
    public function changeAction(){
        $lang = !empty($_GET['lang']) ? $_GET['lang'] : null;
        if($lang){
            if(array_key_exists($lang, App::$app->getProperty('langs'))){
                setCookie('lang', $lang, time() + 3600*24*7, '/');
            }
        }
        Router::redirect();
    }
}