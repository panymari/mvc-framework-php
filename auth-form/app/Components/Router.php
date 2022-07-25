<?php

namespace App\Components;

class Router
{
    private mixed $routes;

    public function __construct()
    {
        $routesPath = CONFIG_ROOT . 'routes.php';
        $this->routes = include $routesPath;
    }

    private function getURI(): ?string
    {
        return (!empty($_SERVER['REQUEST_URI'])) ? trim($_SERVER['REQUEST_URI'], '/') : null;
    }

    public function run()
    {
        $uri = $this->getURI();

        if (isset($this->routes[$uri])) {

            $segments = explode('/', $uri);

            $controllerName = array_shift($segments) . 'Controller';
            $controllerName = ucfirst($controllerName);

            $actionName = array_shift($segments);

            $parameters = $segments;

            $controllerFile = 'App\\Controllers\\' . $controllerName;

            $controllerObject = new $controllerFile();

            if(empty($actionName)) {
                $actionName = "index";
            }

            call_user_func_array([$controllerObject, $actionName], $parameters);


        } else {
            redirect(404, '');
        }
    }
}
