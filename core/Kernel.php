<?php

namespace Core;

use Core\CoreMiddlewares\SessionStartMiddleware;

class Kernel
{
    private App $app;

    protected array $globalMiddlewares = [
        SessionStartMiddleware::class,
    ];

    public function handle(): void
    {
        $this->app = App::instance();

        $this->resolveGlobalMiddlewares();

        $this->resolveRoutes();
    }

    private function resolveGlobalMiddlewares(): void
    {
        foreach ($this->globalMiddlewares as $middlewareFullName) {
            $this->app->resolve($middlewareFullName)->handle();
        }
    }

    private function resolveRoutes(): void
    {
        Router::load('../routes/web.php')
            ->setContainer($this->app)
            ->resolve(
                $_SERVER['REQUEST_URI'],
                $_SERVER['REQUEST_METHOD']
            );
    }
}