<?php

$routes->group('users', ['namespace' => 'Modules\User\Controllers'], function ($routes) {
    $routes->get('', 'UserController::index');
    $routes->get('(:num)', 'UserController::show/$1');
    $routes->post('', 'UserController::create');
    $routes->put('(:num)', 'UserController::update/$1');
    $routes->delete('(:num)', 'UserController::delete/$1');

    $routes->post('register', 'UserController::register');
    $routes->post('login', 'UserController::login');
    $routes->resource('users', ['controller' => 'UserController']);
});
