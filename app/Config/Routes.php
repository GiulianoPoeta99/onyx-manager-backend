<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', function(RouteCollection $routes) {
    require ROOTPATH . 'app/Modules/User/Config/Routes.php';
});
