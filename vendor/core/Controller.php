<?php


namespace vendor\core;


class Controller
{
    protected $_params = array();
    public $view;

    public function __construct()
    {
        $this->view = View::getView();
    }

    public function render($viewName, $attributes = null){
        View::getView()->render($this->getClassFromPath(), $viewName, $attributes);
    }


    public function getClassFromPath(){
        return  ROOT . '/app/view/';
    }

    protected function load_model($model){
        if(class_exists($model)){
            $this->{$model.'Model'} = new $model(strtolower($model));
        }
    }

    protected function posted_values($post){
        $clean_ary = [];
        foreach ($post as $key => $value){
            $clean_ary[$key] = htmlentities($value, ENT_QUOTES, 'UTF-8');
        }
        return $clean_ary;
    }
}