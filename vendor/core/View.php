<?php


namespace vendor\core;


class View
{
    protected static $_view;
    protected $_head, $_body, $_siteTitle = SITE_TITLE, $_layout = DEFAULT_LAYOUT, $_outputBuffer, $_attr;

    public $view, $title, $displayErrors, $codeContent;
    public $previousPage, $nextPage, $activePage, $countPage;



    public static function getView()
    {
        if (null === self::$_view) {
            self::$_view = new self();
        }

        return self::$_view;
    }


    public function render($viewPath, $viewName, $attr = null){
        $this->_attr = $attr;
        $file = $viewPath . $viewName . '.php';
        $this->title = 'ProPUBG';
        if(file_exists($file)){
            $this->view = $file . '';
            include $this->view;
            include $viewPath . 'layouts/' . $this->_layout . '.php';
        } else {
            die('the view \"' . $viewName . '\" does not exist.' . ' Dir \"' . $viewPath . '\"' . '<br/>' . __DIR__);
        }
    }

    private function _render(){
        $arr = explode('/', __DIR__);
        array_splice($arr, 4);
        $filePath = implode('/', $arr) . '/app/view/main/';
        if(my_fr::$isGuest){
            if(file_exists($filePath)) {
                include $filePath . 'index.php';
            }
        } else {
            if(file_exists($filePath)) {
                include $filePath . 'index.php';
            }
        }
    }

    public function content($type){
        if($type == 'head'){
            return $this->_head;
        } elseif ($type == 'body'){
            return $this->_body;
        }
        return false;
    }

    public function start($type){
        $this->_outputBuffer = $type;
        ob_start();
    }

    public function end(){
        if($this->_outputBuffer == 'head'){
            $this->_head = ob_get_clean();
        } elseif ($this->_outputBuffer == 'body'){
            $this->_body = ob_get_clean();
        } else {
            die('View function end');
        }

    }

    public function siteTitle(){
        return $this->_siteTitle;
    }

    public function setSiteTitle($title){
        $this->_siteTitle = $title;
    }

    public function setLayout($path){
        $this->_layout = $path;
    }

    public function code($params = null){
        if(!empty($params)){

        }

    }
}