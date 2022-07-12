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

        foreach ($this->routes as $uriPattern => $path) {
            if (isset($this->routes[$uri])) {
                if (preg_match("~$uriPattern~", $uri)) {
                    $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                    $segments = explode('/', $internalRoute);
                    $controllerName = array_shift($segments) . 'Controller';
                    $controllerName = ucfirst($controllerName);

                    $actionName = array_shift($segments);

                    $actionNameCorrect = str_contains($actionName, '?') ? array_key_last($_GET) : $actionName;

                    $parameters = $segments;

                    $controllerFile = 'App\\Controllers\\' . $controllerName;

                    $controllerObject = new $controllerFile();

                    call_user_func_array([$controllerObject, $actionNameCorrect], $parameters);

                    break;
                }
            } else {
                redirect(404, '');
            }
        }
    }
}
