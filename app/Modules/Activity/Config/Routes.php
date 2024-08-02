<?php

$routes->group('activity', ['namespace' => 'Modules\Activity\Controllers', 'filter' => 'jwt'], function($routes) {
    $routes->get('', 'ActivityController::index');
    $routes->get('(:num)', 'ActivityController::show/$1');
    $routes->post('', 'ActivityController::create');
    $routes->put('(:num)', 'ActivityController::update/$1');
    $routes->delete('(:num)', 'ActivityController::delete/$1');
});