<?php

namespace Core;

use Closure;
use Exception;

class Router
{
    private const CONTROLLER_BASE_PATH = 'App\\Http\\Controllers\\';

    private App $app;

    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    private array $latestMiddlewareAdded = [];

    private array $routeMiddlewares = [];

    private array $matchedRoute;

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
    public function resolve(string $uri, string $method): Closure
    {
        $uri = trim(
            parse_url($uri, PHP_URL_PATH), '/'
        );

        if (!array_key_exists($uri, $this->routes[$method])) {
            abort(404, 'Sorry the page you are looking for is not available at the moment!');
        }

        $this->matchedRoute = [
            'method' => $method,
            'uri' => $uri
        ];

        $controllerNameAndMethod = $this->routes[$method][$uri];

        [$controllerClassName, $controllerAction] = explode('@', $controllerNameAndMethod['action']);

        $controllerInstance = $this->handleController(
            $controllerClassName, $controllerAction
        );

        return fn() => $controllerInstance->$controllerAction();
    }

    public function get($uri, $controllerAndAction): static
    {
        $uri = trim($uri, '/');

        $this->routes['GET'][$uri] = [
            'action' => $controllerAndAction
        ];

        $this->updateLatestMiddlewareAdded(
            'GET',
            $uri
        );

        return $this;
    }

    public function post($uri, $controllerAndAction): static
    {
        $uri = trim($uri, '/');

        $this->routes['POST'][$uri] = [
            'action' => $controllerAndAction
        ];

        $this->updateLatestMiddlewareAdded(
            'POST',
            $uri
        );

        return $this;
    }

    private function updateLatestMiddlewareAdded($method, $uri): void
    {
        $this->latestMiddlewareAdded = compact('method', 'uri');
    }

    public function middleware(...$middlewares): void
    {
        $this->routes[$this->latestMiddlewareAdded['method']][$this->latestMiddlewareAdded['uri']]['middlewares'] = $middlewares;
    }

    public function getMiddlewares(): array
    {
        return $this->routes[$this->matchedRoute['method']][$this->matchedRoute['uri']]['middlewares'] ?? [];
    }

    private function handleController(string $controller, string $action)
    {
        $controller = $this->app->resolve(static::CONTROLLER_BASE_PATH . $controller);

        if (!method_exists($controller, $action)) {
            $controllerName = $controller::class;
            throw new Exception("Sorry, {$action} is not available inside controller {$controllerName}.");
        }

        return $controller;
    }
}