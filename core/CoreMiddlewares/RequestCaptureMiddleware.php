<?php

namespace Core\CoreMiddlewares;

use Core\App;
use Core\Contracts\CoreMiddleware;
use Core\Request;

class RequestCaptureMiddleware implements CoreMiddleware
{
    private App $app;

    public function __construct(private readonly Request $request)
    {
        $this->app = App::instance();
    }

    public function handle(?string $request = null)
    {
        $this->request->captureParameters();

        $this->app->set(Request::class, $this->request);
    }
}