<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use App\Validators\LoginValidator;

class LoginController
{
    public function __construct(private readonly LoginValidator $validator, private readonly AuthenticationService $authenticationService)
    {}

    public function submitLogin()
    {
        $this->validator->validate();

        $this->authenticationService
            ->handle();

        redirectTo('/');
    }
}