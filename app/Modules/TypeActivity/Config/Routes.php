<?php

$routes->group('type_activity', ['namespace' => 'Modules\TypeActivity\Controllers', 'filter' => 'jwt'], function($routes) {
    $routes->get('', 'TypeActivityController::index');
    $routes->get('(:num)', 'TypeActivityController::show/$1');
    $routes->post('', 'TypeActivityController::create');
    $routes->put('(:num)', 'TypeActivityController::update/$1');
    $routes->delete('(:num)', 'TypeActivityController::delete/$1');
});