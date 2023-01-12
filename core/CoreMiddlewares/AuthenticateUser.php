<?php

namespace Core\CoreMiddlewares;

use App\Models\User;
use Core\App;
use Core\Contracts\CoreMiddleware;
use Core\Session;

class AuthenticateUser implements CoreMiddleware
{
    private App $app;

    public function __construct(private Session $session)
    {   
        $this->app = App::instance();
    }

    public function handle(?string $request = null)
    {
        if(! $this->session->has('user_id')) {
            return ;
        }

       $userId = $this->session->get('user_id');

       $user = User::query()->findById($userId);

       if(! $user) {
           $this->session->forget('user_id');
       }

       $this->app->set('AuthenticatedUser', $user);
    }
}