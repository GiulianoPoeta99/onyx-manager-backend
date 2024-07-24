<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', function(RouteCollection $routes) {
    require ROOTPATH . 'app/Modules/User/Config/Routes.php';
    require ROOTPATH . 'app/Modules/Project/Config/Routes.php';
});
