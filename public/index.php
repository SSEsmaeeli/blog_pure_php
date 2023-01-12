<?php

use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();

echo 'Autoload is loaded successfully with env variables.';