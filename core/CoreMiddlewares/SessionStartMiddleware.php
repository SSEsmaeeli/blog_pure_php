<?php

namespace Core\CoreMiddlewares;

use Core\Contracts\CoreMiddleware;

class SessionStartMiddleware implements CoreMiddleware
{
    public function handle(?string $request = null)
    {
        $this->start();
    }

    private function start()
    {
        session_start();
    }
}