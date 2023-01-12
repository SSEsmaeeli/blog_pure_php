<?php

namespace App\Services;
use App\Models\User;

class AuthenticationService
{
    public function handle()
    {
        $user = $this->getUserOrFail();

        return $this->successfulLogin($user);
    }

    private function getUserOrFail()
    {
        $user = User::query()->findByUsernameAndPassword(request()->get('username'), md5(request()->get('password')));

        if(! $user) {
            throw new \Exception('User/Password is wrong');
        }

        return $user;
    }

    private function successfulLogin($user)
    {
        dd($user);
    }
}