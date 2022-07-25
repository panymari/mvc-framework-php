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

        $result = null;
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = array_shift($segments);

                $parameters = $segments;

                $controllerFile = 'App\\Controllers\\' . $controllerName;

                $controllerObject = new $controllerFile();

                $result = call_user_func_array([$controllerObject, $actionName], $parameters);

                break;
            }
        }
    }
}
