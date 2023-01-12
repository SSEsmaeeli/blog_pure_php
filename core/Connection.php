<?php

namespace core;

use PDO;
use PDOException;

class Connection
{
    public static function handle($config)
    {
        try {
            return new PDO(
                'mysql:dbname='.$config['database'].';host='.$config['host'],
                $config['username'],
                $config['password'],
                $config['options']
            );
        } catch (PDOException $exception) {
            //die($exception);
            die('Sorry something is wrong in infrastructure and will be fix as soon as possible.');
        }
    }
}