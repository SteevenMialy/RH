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
$routes->post('/employe/profil', 'EmployeDashboard::updateProfil', ['as' => 'employe_update_profil']);

// ──────────────────────────────────────────────────
// DASHBOARD RH
// ──────────────────────────────────────────────────
$routes->get('/rh', 'RhDashboard::dashboard', ['as' => 'rh_dashboard']);
$routes->get('/rh/demandes', 'RhDashboard::demandes', ['as' => 'rh_demandes']);
$routes->get('/rh/soldes', 'RhDashboard::soldes', ['as' => 'rh_soldes']);
$routes->post('/rh/confirmationconger', 'RhController::confirmationconger', ['as' => 'rh_confirmationconger']);

// ──────────────────────────────────────────────────
// DASHBOARD ADMIN
// ──────────────────────────────────────────────────
$routes->get('/admin', 'AdminDashboard::dashboard', ['as' => 'admin_dashboard']);
$routes->get('/admin/employes', 'AdminDashboard::employes', ['as' => 'admin_employes']);
$routes->post('/admin/employes', 'AdminDashboard::storeEmploye', ['as' => 'admin_store_employe']);
$routes->post('/admin/rh', 'AdminDashboard::storeRh', ['as' => 'admin_store_rh']);
$routes->post('/admin/employes/(:num)/toggle', 'AdminDashboard::toggleEmploye/$1', ['as' => 'admin_toggle_employe']);
$routes->post('/admin/employes/(:num)/delete', 'AdminDashboard::deleteEmploye/$1', ['as' => 'admin_delete_employe']);
// Permanent remove (if no dependent requests)
$routes->post('/admin/employes/(:num)/remove', 'AdminDashboard::removeEmploye/$1', ['as' => 'admin_remove_employe']);
$routes->get('/admin/departements', 'AdminDashboard::departements', ['as' => 'admin_departements']);
$routes->post('/admin/departements', 'AdminDashboard::storeDepartement', ['as' => 'admin_store_departement']);
$routes->post('/admin/departements/(:num)/delete', 'AdminDashboard::deleteDepartement/$1', ['as' => 'admin_delete_departement']);
$routes->get('/admin/types-conge', 'AdminDashboard::typesConge', ['as' => 'admin_types_conge']);
$routes->post('/admin/types-conge', 'AdminDashboard::storeTypeConge', ['as' => 'admin_store_type_conge']);
$routes->post('/admin/types-conge/(:num)/delete', 'AdminDashboard::deleteTypeConge/$1', ['as' => 'admin_delete_type_conge']);
$routes->get('/admin/demandes', 'AdminDashboard::demandesAll', ['as' => 'admin_demandes']);
// Delete RH account
$routes->post('/admin/rh/(:num)/delete', 'AdminDashboard::deleteRh/$1', ['as' => 'admin_delete_rh']);

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
