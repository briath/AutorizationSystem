<?php

error_reporting(-1);
use \vendor\core\Router;
$query = $_SERVER['QUERY_STRING'];

define('WWW', __DIR__);
define('ROOT', dirname(WWW));
define('CORE', ROOT . '/vendor/core');
define('APP', ROOT . '/app');

require '../vendor/autoload.php';
require '../vendor/libs/functions.php';

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::submit($query);