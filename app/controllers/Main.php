<?php

namespace app\controllers;

use vendor\core\Controller;

class Main extends Controller
{
    public function indexAction(){
        echo 'Main::index';
        $this->render('main/index');
    }
}