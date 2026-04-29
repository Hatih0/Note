<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
<<<<<<< HEAD
$routes->get('/', 'UserController::login');
$routes->post('/login', 'UserController::checkUser');
=======
$routes->get('/', 'Home::index');

>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679
// Routes pour la gestion des notes
$routes->get('/notes', 'Notes::index');
$routes->get('/notes/get-matieres', 'Notes::getMatieresBySemestre');
$routes->get('/notes/get-notes', 'Notes::getNotesByEtudiant');
$routes->post('/notes/inserer', 'Notes::insererNote');
<<<<<<< HEAD
$routes->post('/notes/modifier', 'Notes::modifierNote');
=======
>>>>>>> 7ec1c4798172e4a891eb25b69eba843db9aca679
