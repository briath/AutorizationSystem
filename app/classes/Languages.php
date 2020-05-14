<?php

namespace app\classes;

use vendor\core\App;

/*
 * Класс виджет языков.
 * Сначала controller должен получить все языки и действующий язык. (getLanguages, getLanguage)
 * Потом controller создает экземпляр класса и передает его параметром view.
 * View получет select. (/views/lang.php)
 */

class Languages
{
    protected $tpl;
    protected $languages;
    protected $language;

    public function __construct()
    {
        $this->tpl = APP . '/views/lang.php';
        $this->run();
    }

    /*
     * В переменную languages запоминает все доступные языки.
     * В переменную language запоминает действующий язык.
     */
    protected function run(){
        $this->languages = App::$app->getProperty('langs');
        $this->language = App::$app->getProperty('lang');
    }

    /*
     * Получаем из таблицы languages все доступные языки
     */
    public static function getLanguages(){
        return \vendor\core\DB::getInstance()->getAssoc("SELECT code, title, base FROM languages ORDER BY base DESC");
    }

    /*
     * var $languages - массив языков
     * возвращаемое значение - либо язык из куки, либо базовый язык
     */
    public static function getLanguage($languages){
        if(isset($_COOKIE['lang']) && array_key_exists($_COOKIE['lang'], $languages)){
            $key = $_COOKIE['lang'];
        } else {
            $key = key($languages);
        }
        $lang = $languages[$key];
        $lang['code'] = $key;
        return $lang;
    }

    /*
     * возвращаемое значение select языков
     */
    public function getHtml(){
        return require $this->tpl;
    }
}