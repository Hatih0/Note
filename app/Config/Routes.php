<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/etudiants/list', 'EtudiantController::findAll');
$routes->get('/etudiants/(:num)/notes', 'EtudiantController::viewNotes/$1');
$routes->get('/etudiants/(:num)/notes/semester/(:alphanum)', 'EtudiantController::notesBySemester/$1/$2');
$routes->get('/etudiants/(:num)/notes/year/(:alphanum)', 'EtudiantController::notesByYear/$1/$2');
