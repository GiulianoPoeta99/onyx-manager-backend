<?php

$routes->group('state', ['namespace' => 'Modules\State\Controllers', 'filter' => 'jwt'], function($routes) {
    $routes->get('', 'StateController::index');
    $routes->get('(:num)', 'StateController::show/$1');
    $routes->post('', 'StateController::create');
    $routes->put('(:num)', 'StateController::update/$1');
    $routes->delete('(:num)', 'StateController::delete/$1');
});