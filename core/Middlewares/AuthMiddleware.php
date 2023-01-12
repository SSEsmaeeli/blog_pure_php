<?php

namespace Core\Middlewares;

use Core\App;
use Core\Contracts\RouteMiddleware;
use Core\Request;
use Core\Session;

class AuthMiddleware implements RouteMiddleware
{
    public function handle(Request $request)
    {
        if(! isAuth()) {
            abort('403', 'Sorry you are not able to access the resource.');
        }
    }
}