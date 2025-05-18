<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::attemptRegister');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/risorse/filtra', 'HomeController::filtraRisorse');

// Filtro 'auth' per verificare che l'utente abbia effettuato il login
$routes->get('/risorse/(:segment)', 'HomeController::categoria/$1', ['filter' => 'auth']);
$routes->get('/home', 'HomeController::index', ['filter' => 'auth']);
$routes->get('/prenotazioni', 'PrenotazioniController::miePrenotazioni', ['filter' => 'auth']);
$routes->get('/prenota/(:num)', 'PrenotazioniController::crea/$1', ['filter' => 'auth']);
$routes->get('/prenotazioni/annulla/(:num)', 'PrenotazioniController::annulla/$1', ['filter' => 'auth']);
$routes->post('/prenota', 'PrenotazioniController::salva', ['filter' => 'auth']);

// Routes per Admin
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('risorse', 'AdminController::indexRisorse');
    $routes->get('risorse/nuova', 'AdminController::nuovaRisorsa');
    $routes->post('risorse/crea', 'AdminController::creaRisorsa');
    $routes->get('risorse/elimina/(:num)', 'AdminController::eliminaRisorsa/$1');

    $routes->get('prenotazioni', 'AdminController::listaPrenotazioni');
    $routes->get('prenotazioni/elimina/(:num)', 'AdminController::eliminaPrenotazione/$1');
});
