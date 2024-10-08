<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('api', function (RouteCollection $routes) {
    require ROOTPATH . 'app/Modules/User/Config/Routes.php';
    require ROOTPATH . 'app/Modules/Project/Config/Routes.php';
    require ROOTPATH . 'app/Modules/UserProject/Config/Routes.php';
    require ROOTPATH . 'app/Modules/Role/Config/Routes.php';
    require ROOTPATH . 'app/Modules/UserRole/Config/Routes.php';
    require ROOTPATH . 'app/Modules/TypeActivity/Config/Routes.php';
    require ROOTPATH . 'app/Modules/TypeState/Config/Routes.php';
    require ROOTPATH . 'app/Modules/Activity/Config/Routes.php';
    require ROOTPATH . 'app/Modules/Task/Config/Routes.php';
    require ROOTPATH . 'app/Modules/State/Config/Routes.php';
});
