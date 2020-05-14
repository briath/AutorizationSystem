<?php


namespace vendor\core;


class Controller
{
    /**
     * @var array $params - пользовательские данные
     * @var $view - вид
     * @var $layout - шаблон
     * @var $route - путь (url)
     */
    protected $params = [];
    public $view, $layout;
    public $route;

    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $this->route['action'];
    }

    /*
     * Загружаем view.
     * Вызываем у view метод render и передаем в него данные.
     */
    public function getView(){
        $viewObject = new View($this->route, $this->layout, $this->view);
        $viewObject->render($this->params);
    }

    /*
     * Загружаем модель.
     */
    protected function load_model($model){
        if(class_exists($model)){
            $this->{$model.'Model'} = new $model();
        }
    }

    /*
     * Возвращаем массив содержащий id элементов и значения элементов, которые пришли из form.
     */
    protected function posted_values($post){
        $clean_ary = [];
        foreach ($post as $key => $value){
            $clean_ary[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
        }
        return $clean_ary;
    }

    /*
     * заполняем массив пользовательских данных.
     */
    public function set($params){
        $this->params = array_merge($params, $this->params);
    }
}