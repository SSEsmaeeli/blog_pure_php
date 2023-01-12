<?php

namespace Core;

use Closure;
use Exception;

class Pipeline
{
    private App $container;

    private Closure $router;

    public function setContainer(App $container): static
    {
        $this->container = $container;
        return $this;
    }

    public function setRouteCallable(Closure $router): static
    {
        $this->router = $router;
        return $this;
    }

    public function runMiddlewares(array $routeMiddlewareStack, array $middlewares): static
    {
        array_reduce($middlewares, function ($accumulator, $middlewareAlias) use ($routeMiddlewareStack){
            if(! array_key_exists($middlewareAlias, $routeMiddlewareStack)) {
                throw new Exception('Middleware is not available or is not registered.');
            }

            $this->container->resolve($routeMiddlewareStack[$middlewareAlias])
                ->handle(request());
        });

        return $this;
    }

    public function runRoute(): void
    {
        call_user_func($this->router);
    }
}