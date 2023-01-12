<?php

namespace App\Services;
use App\Models\User;
use Core\Session;

class AuthenticationService
{
    public function __construct(private readonly Session $session)
    {}

    public function handle()
    {
        $user = $this->getUserOrFail();

        $this->putUserOnSession($user);
    }

    private function getUserOrFail()
    {
        $user = User::query()->findByUsernameAndPassword(request()->get('username'), md5(request()->get('password')));

        if(! $user) {
            throw new \Exception('User/Password is wrong');
        }

        return $user;
    }

    private function putUserOnSession($user): void
    {
        $this->session->set('user_id', $user->id);
    }
}