<?php

namespace Core\Contracts;

use Core\Request;

interface RouteMiddleware
{
    public function handle(Request $request);
}