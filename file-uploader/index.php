<?php

use App\Components\Router;

require_once './config/const.php';
require_once './vendor/autoload.php';

$router = new Router();
$router->run();
