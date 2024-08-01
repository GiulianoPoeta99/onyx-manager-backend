<?php

$routes->group('type_state', ['namespace' => 'Modules\TypeState\Controllers', 'filter' => 'jwt'], function($routes) {
    $routes->get('', 'TypeStateController::index');
    $routes->get('(:num)', 'TypeStateController::show/$1');
    $routes->post('', 'TypeStateController::create');
    $routes->put('(:num)', 'TypeStateController::update/$1');
    $routes->delete('(:num)', 'TypeStateController::delete/$1');
});