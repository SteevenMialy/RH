<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ──────────────────────────────────────────────────
// AUTHENTIFICATION
// ──────────────────────────────────────────────────
$routes->get('/login', 'Auth::login', ['as' => 'auth_login']);
$routes->post('/login', 'Auth::doLogin', ['as' => 'do_login']);
$routes->get('/logout', 'Auth::logout', ['as' => 'auth_logout']);

// ──────────────────────────────────────────────────
// DASHBOARD EMPLOYE
// ──────────────────────────────────────────────────
$routes->get('/employe', 'EmployeDashboard::dashboard', ['as' => 'employe_dashboard']);
$routes->get('/employe/demande', 'EmployeDashboard::formCongé', ['as' => 'employe_form_conge']);
$routes->post('/employe/demande', 'EmployeDashboard::storeConge', ['as' => 'employe_store_conge']);
$routes->get('/employe/mes-conges', 'EmployeDashboard::mesCongés', ['as' => 'employe_mes_conges']);
$routes->post('/employe/conge/(:num)/cancel', 'EmployeDashboard::cancelConge/$1', ['as' => 'employe_cancel_conge']);
$routes->get('/employe/profil', 'EmployeDashboard::profil', ['as' => 'employe_profil']);

// ──────────────────────────────────────────────────
// ROUTE PAR DÉFAUT → Redirection vers login
// ──────────────────────────────────────────────────
$routes->get('/', 'Auth::login');

// ──────────────────────────────────────────────────
// ANCIEN MODULE ÉTUDIANT (optionnel)
// ──────────────────────────────────────────────────
$routes->get('/notes', 'Etudiant::saisieNote');
$routes->post('/notes/enregistrer', 'Etudiant::enregistrerNote');
$routes->get('/list_Etudiant', 'Etudiant::listEtudiants');
$routes->get('/notes/etudiant', 'Etudiant::getNotes');
$routes->get('/notes/modifier/(:num)', 'Etudiant::modifierNote/$1');
$routes->post('/notes/modifier/(:num)', 'Etudiant::mettreAJourNote/$1');
$routes->post('/notes/supprimer/(:num)', 'Etudiant::supprimerNote/$1');
