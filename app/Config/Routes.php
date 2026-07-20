<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'fraisTypeOperationController::index');


    // Dans app/Config/Routes.php

$routes->get('/operateur', 'OperateurController::index');
$routes->post('/operateur/save', 'OperateurController::save');
$routes->get('/operateur/delete/(:num)', 'OperateurController::delete/$1');

$routes->get('/operateur-prefix', 'OperateurPrefixController::index');
$routes->post('/operateur-prefix/save', 'OperateurPrefixController::save');
$routes->get('/operateur-prefix/delete/(:num)', 'OperateurPrefixController::delete/$1');


$routes->get('/type-operation', 'TypeOperationController::index');
$routes->post('/type-operation/save', 'TypeOperationController::save');
$routes->get('/type-operation/delete/(:num)', 'TypeOperationController::delete/$1');

$routes->get('/interval-montant', 'IntervalMontantController::index');
$routes->post('/interval-montant/save', 'IntervalMontantController::save');
$routes->get('/interval-montant/delete/(:num)', 'IntervalMontantController::delete/$1');

$routes->get('/status', 'StatusController::index');
$routes->post('/status/save', 'StatusController::save');
$routes->get('/status/delete/(:num)', 'StatusController::delete/$1');

// Frais Type Operation Routes
$routes->get('/frais-type-operation', 'fraisTypeOperationController::index');
$routes->post('/frais-type-operation/save', 'fraisTypeOperationController::save');



// Clients 
$routes->get('/client-numero', 'clientNumeroController::index');
$routes->post('/client-numero/login', 'clientNumeroController::login');

