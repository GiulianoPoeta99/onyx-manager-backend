<?php

$routes->group('roles', ['namespace' => 'Modules\Role\Controllers'], function ($routes) {
    $routes->get('', 'RoleController::index');
    $routes->get('(:num)', 'RoleController::show/$1');
    $routes->post('', 'RoleController::create');
    $routes->put('(:num)', 'RoleController::update/$1');
    $routes->delete('(:num)', 'RoleController::delete/$1');
});
