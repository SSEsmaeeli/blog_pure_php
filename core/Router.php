<?php

namespace Core;

use Exception;

class Router
{
    private const CONTROLLER_BASE_PATH = 'App\\Http\\Controllers\\';

    private App $app;

    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function setContainer(App $container): static
    {
        $this->app = $container;
        return $this;
    }

    public static function load($routeFile): static
    {
        $router = new static;

        require $routeFile;

        return $router;
    }

    /**
      * @throws Exception
      */
     public function resolve(string $uri, string $method)
     {
         $uri = trim($uri, '/');

         if(! array_key_exists($uri, $this->routes[$method])) {
             abort(404, 'Sorry the page you are looking for is not available at the moment!');
         }

         $controllerNameAndMethod = $this->routes[$method][$uri];

         return $this->callAction(
             ...explode('@', $controllerNameAndMethod)
         );
     }

     public function get($uri, $controllerAndAction): void
     {
         $this->routes['GET'][trim($uri, '/')] = $controllerAndAction;
     }

     public function post($uri, $controllerAndAction): void
     {
         $this->routes['POST'][trim($uri, '/')] = $controllerAndAction;
     }

     private function callAction(string $controller, string $action)
     {
         $controller = $this->app->resolve(static::CONTROLLER_BASE_PATH . $controller);

         if(! method_exists($controller, $action)) {
             $controllerName = $controller::class;
             throw new Exception("Sorry, {$action} is not available inside controller {$controllerName}.");
         }

         return $controller->$action();
     }
}