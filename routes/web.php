<?php

/** @var Core\Router $router */

$router->get('', 'PagesController@index');
$router->get('login', 'PagesController@login');

$router->post('login', 'LoginController@submitLogin');
$router->post('logout', 'LogoutController@logout');

$router->get('migration', 'MigrationController@run')->middleware('auth');