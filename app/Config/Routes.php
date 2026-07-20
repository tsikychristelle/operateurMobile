<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


    // Dans app/Config/Routes.php

$routes->get('/operateur', 'OperateurController::index');
$routes->post('/operateur/save', 'OperateurController::save');
$routes->get('/operateur/delete/(:num)', 'OperateurController::delete/$1');

$routes->get('/operateur-prefix', 'OperateurPrefixController::index');
$routes->post('/operateur-prefix/save', 'OperateurPrefixController::save');
$routes->get('/operateur-prefix/delete/(:num)', 'OperateurPrefixController::delete/$1');
