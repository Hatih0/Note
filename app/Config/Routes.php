<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController::login');
$routes->post('/login', 'UserController::checkUser');
// Routes pour la gestion des notes
$routes->get('/notes', 'Notes::index');
$routes->get('/notes/get-matieres', 'Notes::getMatieresBySemestre');
$routes->get('/notes/get-notes', 'Notes::getNotesByEtudiant');
$routes->post('/notes/inserer', 'Notes::insererNote');
$routes->post('/notes/modifier', 'Notes::modifierNote');
