<?php

require_once './config/const.php';
require_once './vendor/autoload.php';
require_once './environment.php';

use App\Components\Router;

$router = new Router();
$router->run();
