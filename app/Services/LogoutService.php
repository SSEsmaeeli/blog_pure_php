<?php

namespace App\Services;

use Core\App;
use Core\Contracts\Service;
use Core\Session;

class LogoutService implements Service
{
    private App $app;

    public function __construct(private readonly Session $session)
    {
        $this->app = App::instance();
    }

    public function handle()
    {
        $this->app->forget('AuthenticatedUser');
        $this->session->forget('user_id');
    }
}