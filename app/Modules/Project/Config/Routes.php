<?php

$routes->group('users', ['namespace' => 'Modules\Project\Controllers'], function($routes) {
    $routes->get('', 'ProjectController::index');
    $routes->get('(:num)', 'ProjectController::show/$1');
    $routes->post('', 'ProjectController::create');
    $routes->put('(:num)', 'ProjectController::update/$1');
    $routes->delete('(:num)', 'ProjectController::delete/$1');
});