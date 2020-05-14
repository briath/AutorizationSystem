<?php

//error_reporting(-1);

define('WWW', __DIR__);

require '../config/config.php';
require '../vendor/autoload.php';

\vendor\core\DB::getInstance();
\vendor\core\App::start();