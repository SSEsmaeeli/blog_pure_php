<?php

namespace App\Models;

use Core\Database\Model;

class User extends Model
{
    public string $table = 'users';

    public function findByUsernameAndPassword(string $username, string $password)
    {
        return $this->queryBuilder
            ->setTable($this->getTableName())
            ->where('username', '=', $username)
            ->where('password', '=', $password)
            ->first();
    }
}