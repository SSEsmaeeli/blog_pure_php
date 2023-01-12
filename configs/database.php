<?php

return [
    'connection' => [
        'host' => env('DB_HOST', 'mysql'),
        'database' => env('DB_DATABASE', '1234'),
        'username' => env('DB_USERNAME', 'user'),
        'password' => env('DB_PASSWORD', 'password'),
        'username_root' => env('DB_ROOT_USERNAME', 'root'),
        'password_root' => env('DB_ROOT_PASSWORD', 'password'),
        'options' => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    ],
];