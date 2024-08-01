<?php

$routes->group('projects', ['namespace' => 'Modules\Project\Controllers', 'filter' => 'jwt'], function ($routes) {
    $routes->get('', 'ProjectController::index');
    $routes->get('(:num)', 'ProjectController::show/$1');
    $routes->post('', 'ProjectController::create');
    $routes->put('(:num)', 'ProjectController::update/$1');
    $routes->delete('(:num)', 'ProjectController::delete/$1');
});
