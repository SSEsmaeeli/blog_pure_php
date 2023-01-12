<?php

use Core\App;
use Core\Connection;
use Core\Router;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$app = App::instance();

$app->set('config_database', require '../configs/database.php');

$app->set('PDO', Connection::handle(
    $app->get('config_database')['connection']
));

return $app;