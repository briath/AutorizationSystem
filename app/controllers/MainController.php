<?php

namespace app\controllers;

use app\models\Main;
use vendor\core\Controller;
use vendor\core\Cookie;
use vendor\core\Session;

/*
 * Controller главной страницы.
 */

class MainController extends AppController
{
    public $layout = 'default';

    public function indexAction(){
        $this->layout = 'default';
    }
}