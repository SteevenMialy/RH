<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Etudiant::saisieNote');

$routes->get('/notes', 'Etudiant::saisieNote');
$routes->post('/notes/enregistrer', 'Etudiant::enregistrerNote');
$routes->get('/list_Etudiant', 'Etudiant::listEtudiants');
$routes->get('/notes/etudiant', 'Etudiant::getNotes');
$routes->get('/notes/modifier/(:num)', 'Etudiant::modifierNote/$1');
$routes->post('/notes/modifier/(:num)', 'Etudiant::mettreAJourNote/$1');
$routes->post('/notes/supprimer/(:num)', 'Etudiant::supprimerNote/$1');
