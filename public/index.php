<?php

use Core\App;
use Core\Connection;
use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();

$app = new App();
$app->set('config_database', require '../configs/database.php');

$app->set('PDO', Connection::handle(
    $app->get('config_database')['connection']
));


echo 'Database is loaded successfully!';