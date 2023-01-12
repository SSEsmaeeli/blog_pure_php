<?php

use Core\App;
use Core\Connection;
use Core\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$app = new App();
$app->set('config_database', require '../configs/database.php');

$app->set('PDO', Connection::handle(
    $app->get('config_database')['connection']
));

$router = Router::load('../routes/web.php')
    ->resolve(
        $_SERVER['REQUEST_URI'],
        $_SERVER['REQUEST_METHOD']
    );