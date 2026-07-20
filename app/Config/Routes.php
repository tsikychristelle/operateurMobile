<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'fraisTypeOperationController::index');





// Frais Type Operation Routes
$routes->get('/frais-type-operation', 'fraisTypeOperationController::index');
$routes->post('/frais-type-operation/save', 'fraisTypeOperationController::save');