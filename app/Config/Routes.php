<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->get('logout', 'Auth::logout');

$routes->group('panel', ['namespace' => 'App\\Controllers\\Panel', 'filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('dashboard', 'DashboardController::index');
    // Komoditas Tambak CRUD
    $routes->get('komoditas', 'KomoditasController::index');
    $routes->get('komoditas/tambah', 'KomoditasController::new');
    $routes->get('komoditas/(:num)/edit', 'KomoditasController::edit/$1');
    $routes->get('komoditas/(:num)', 'KomoditasController::show/$1');
    $routes->post('komoditas', 'KomoditasController::store');
    $routes->put('komoditas/(:num)', 'KomoditasController::update/$1');
    $routes->patch('komoditas/(:num)', 'KomoditasController::update/$1');
    $routes->delete('komoditas/(:num)', 'KomoditasController::delete/$1');

    // Users CRUD
    $routes->get('users', 'UsersController::index');
    $routes->get('users/tambah', 'UsersController::new');
    $routes->get('users/(:num)/edit', 'UsersController::edit/$1');
    $routes->get('users/(:num)', 'UsersController::show/$1');
    $routes->post('users', 'UsersController::store');
    $routes->put('users/(:num)', 'UsersController::update/$1');
    $routes->patch('users/(:num)', 'UsersController::update/$1');
    $routes->delete('users/(:num)', 'UsersController::delete/$1');

    // Kriteria CRUD
    $routes->get('kriteria', 'KriteriaController::index');
    $routes->get('kriteria/tambah', 'KriteriaController::new');
    $routes->get('kriteria/(:num)/edit', 'KriteriaController::edit/$1');
    $routes->get('kriteria/(:num)', 'KriteriaController::show/$1');
    $routes->post('kriteria', 'KriteriaController::store');
    $routes->put('kriteria/(:num)', 'KriteriaController::update/$1');
    $routes->patch('kriteria/(:num)', 'KriteriaController::update/$1');
    $routes->delete('kriteria/(:num)', 'KriteriaController::delete/$1');

    // Nilai Kriteria CRUD
    $routes->get('nilai-kriteria', 'NilaiKriteriaController::index');
    $routes->get('nilai-kriteria/tambah', 'NilaiKriteriaController::new');
    $routes->get('nilai-kriteria/(:num)/edit', 'NilaiKriteriaController::edit/$1');
    $routes->get('nilai-kriteria/(:num)', 'NilaiKriteriaController::show/$1');
    $routes->post('nilai-kriteria', 'NilaiKriteriaController::store');
    $routes->put('nilai-kriteria/(:num)', 'NilaiKriteriaController::update/$1');
    $routes->patch('nilai-kriteria/(:num)', 'NilaiKriteriaController::update/$1');
    $routes->delete('nilai-kriteria/(:num)', 'NilaiKriteriaController::delete/$1');

    // Bobot Kriteria CRUD
    $routes->get('bobot-kriteria', 'BobotKriteriaController::index');
    $routes->get('bobot-kriteria/tambah', 'BobotKriteriaController::new');
    $routes->get('bobot-kriteria/(:num)/edit', 'BobotKriteriaController::edit/$1');
    $routes->get('bobot-kriteria/(:num)', 'BobotKriteriaController::show/$1');
    $routes->post('bobot-kriteria', 'BobotKriteriaController::store');
    $routes->put('bobot-kriteria/(:num)', 'BobotKriteriaController::update/$1');
    $routes->patch('bobot-kriteria/(:num)', 'BobotKriteriaController::update/$1');
    $routes->delete('bobot-kriteria/(:num)', 'BobotKriteriaController::delete/$1');

    $routes->group('spk', static function ($routes) {
        $routes->get('topsis', 'Spk\\ResultsController::topsis');
        $routes->post('topsis', 'Spk\\TopsisSpkController::hitung');

        $routes->get('electre', 'Spk\\ResultsController::electre');
        $routes->post('electre', 'Spk\\ElectreSpkController::hitung');

        $routes->get('bandingkan', 'Spk\\ResultsController::compare');
        $routes->post('bandingkan', 'Spk\\PerbandinganSpkController::bandingkan');
    });
});
