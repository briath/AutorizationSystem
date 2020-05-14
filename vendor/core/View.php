<?php


namespace vendor\core;


class View
{
    public $route, $layout, $view;

    public function __construct($route, $layout = '', $view)
    {
        $this->route = $route;
        if($layout === false) {
            $this->layout = false;
        }else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    public function render($params){
        if(is_array($params)) extract($params);
        $file_view = APP . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();
        if(is_file($file_view)){
            require $file_view;
        }else{
            echo "не найден вид";
        }
        $content = ob_get_clean();

        if(false !== $this->layout) {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo "не найден layout";
            }
        }
    }

    /**
     * @param $key - ключ текста на странице
     * возвращает текст страницы с ключом $key
     */
    public function __($key){
        return Lang::get($key);
    }
}