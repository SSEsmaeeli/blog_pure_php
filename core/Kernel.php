<?php

namespace Core;

use Core\CoreMiddlewares\AuthenticateUser;
use Core\CoreMiddlewares\RequestCaptureMiddleware;
use Core\CoreMiddlewares\SessionStartMiddleware;
use Core\Middlewares\AuthMiddleware;

class Kernel
{
    private App $app;

    protected array $globalMiddlewares = [
        SessionStartMiddleware::class,
        RequestCaptureMiddleware::class,
        AuthenticateUser::class,
    ];

    public array $registeredRouteMiddlewares = [
        'auth' => AuthMiddleware::class
    ];

    private Router $router;

    public function handle(): void
    {
        $this->app = App::instance();

        $this->resolveGlobalMiddlewares();

        $this->resolveRoutes();

        (new Pipeline)
            ->setContainer($this->app)
            ->setRouteCallable($this->router->resolve(
                $_SERVER['REQUEST_URI'],
                $_SERVER['REQUEST_METHOD']
            ))
            ->runMiddlewares($this->registeredRouteMiddlewares, $this->router->getMiddlewares())
            ->runRoute();
    }

    private function resolveGlobalMiddlewares(): void
    {
        foreach ($this->globalMiddlewares as $middlewareFullName) {
            $this->app->resolve($middlewareFullName)->handle();
        }
    }

    private function resolveRoutes(): void
    {
        $this->router = Router::load('../routes/web.php')
            ->setContainer($this->app);
    }
}