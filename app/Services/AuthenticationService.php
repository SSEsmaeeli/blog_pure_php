<?php

namespace App\Services;
class AuthenticationService
{
    public function handle()
    {
        $user = $this->getUserOrFail();

        return $this->successfulLogin($user);
    }

    private function getUserOrFail()
    {
        // @todo
    }

    private function successfulLogin($user)
    {
        // @todo
    }
}