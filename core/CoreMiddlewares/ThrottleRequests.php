<?php

namespace Core\CoreMiddlewares;

use Core\Contracts\CoreMiddleware;

class ThrottleRequests implements CoreMiddleware
{

    public function handle(?string $request = null)
    {
        // TODO: Implement Throttling the request for each user and so it will apply to all routes in application
    }
}