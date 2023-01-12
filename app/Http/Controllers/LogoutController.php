<?php

namespace App\Http\Controllers;

use App\Services\LogoutService;

class LogoutController
{
    public function __construct(private readonly LogoutService $logoutService)
    {}

    public function logout()
    {
        $this->logoutService
            ->handle();

        redirectTo('/');
    }
}