<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Routes pour la gestion des notes
$routes->get('/notes', 'Notes::index');
$routes->get('/notes/get-matieres', 'Notes::getMatieresBySemestre');
$routes->get('/notes/get-notes', 'Notes::getNotesByEtudiant');
$routes->post('/notes/inserer', 'Notes::insererNote');
