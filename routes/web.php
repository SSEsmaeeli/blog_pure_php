<?php

/** @var Core\Router $router */

$router->get('', 'PagesController@index');
$router->get('login', 'PagesController@login');

$router->post('login', 'LoginController@submitLogin');