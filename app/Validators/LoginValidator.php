<?php

namespace App\Validators;

use Core\Contracts\Validator;

class LoginValidator implements Validator
{
    public function validate()
    {
        $username = request()->get('username');
        $password = request()->get('password');

        if(! isset($username) || empty($username)) {
            throw new \Exception('Sorry username should be filled');
        }

        if(! isset($password) || empty($password)) {
            throw new \Exception('Sorry password cannot be empty');
        }
    }
}