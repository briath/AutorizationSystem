<?php


namespace app\controllers;


use vendor\core\App;
use vendor\core\Controller;
use app\classes\Languages;
use vendor\core\Lang;

/*
 * Выполняем действия, которые необходимы для каждого controller
 * Наследуемся от базового controller, получаем языки и создаем экземпляр класса Languages.
 */

class AppController extends Controller
{
    public $languages;

    public function __construct($route)
    {
        parent::__construct($route);
        App::$app->setProperty('langs', Languages::getLanguages());
        App::$app->setProperty('lang', Languages::getLanguage(App::$app->getProperty('langs')));
        Lang::load(App::$app->getProperty('lang')['code'], $this->route);
        $languages = new Languages();
        $this->set(compact(['languages']));
    }
}