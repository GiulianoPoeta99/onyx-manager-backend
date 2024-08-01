<?php

$routes->group('users_roles', ['namespace' => 'Modules\UserRole\Controllers', 'filter' => 'jwt'], function ($routes) {
    $routes->get('', 'UserRoleController::index');
    $routes->get('(:num)', 'UserRoleController::show/$1');
    $routes->post('', 'UserRoleController::create');
    $routes->put('(:num)', 'UserRoleController::update/$1');
    $routes->delete('(:num)', 'UserRoleController::delete/$1');
});
