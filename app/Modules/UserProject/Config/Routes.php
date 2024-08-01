<?php

$routes->group('users_projects', ['namespace' => 'Modules\UserProject\Controllers', 'filter' => 'jwt'], function ($routes) {
    $routes->get('', 'UserProjectController::index');
    $routes->get('(:num)', 'UserProjectController::show/$1');
    $routes->post('', 'UserProjectController::create');
    $routes->put('(:num)', 'UserProjectController::update/$1');
    $routes->delete('(:num)', 'UserProjectController::delete/$1');
});
