<?php

require_once './config/const.php';
require_once './vendor/autoload.php';

use App\Components\Router;

$router = new Router();
$router->run();
