<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Home::login');

$routes->group('panel', ['namespace' => 'App\\Controllers\\Panel'], static function ($routes) {
    // Komoditas Tambak CRUD
    $routes->get('komoditas', 'KomoditasController::index');
    $routes->get('komoditas/(:num)', 'KomoditasController::show/$1');
    $routes->post('komoditas', 'KomoditasController::store');
    $routes->put('komoditas/(:num)', 'KomoditasController::update/$1');
    $routes->patch('komoditas/(:num)', 'KomoditasController::update/$1');
    $routes->delete('komoditas/(:num)', 'KomoditasController::delete/$1');

    // Users CRUD
    $routes->get('users', 'UsersController::index');
    $routes->get('users/(:num)', 'UsersController::show/$1');
    $routes->post('users', 'UsersController::store');
    $routes->put('users/(:num)', 'UsersController::update/$1');
    $routes->patch('users/(:num)', 'UsersController::update/$1');
    $routes->delete('users/(:num)', 'UsersController::delete/$1');

    // Kriteria CRUD
    $routes->get('kriteria', 'KriteriaController::index');
    $routes->get('kriteria/(:num)', 'KriteriaController::show/$1');
    $routes->post('kriteria', 'KriteriaController::store');
    $routes->put('kriteria/(:num)', 'KriteriaController::update/$1');
    $routes->patch('kriteria/(:num)', 'KriteriaController::update/$1');
    $routes->delete('kriteria/(:num)', 'KriteriaController::delete/$1');

    // Nilai Kriteria CRUD
    $routes->get('nilai-kriteria', 'NilaiKriteriaController::index');
    $routes->get('nilai-kriteria/(:num)', 'NilaiKriteriaController::show/$1');
    $routes->post('nilai-kriteria', 'NilaiKriteriaController::store');
    $routes->put('nilai-kriteria/(:num)', 'NilaiKriteriaController::update/$1');
    $routes->patch('nilai-kriteria/(:num)', 'NilaiKriteriaController::update/$1');
    $routes->delete('nilai-kriteria/(:num)', 'NilaiKriteriaController::delete/$1');

    // Bobot Kriteria CRUD
    $routes->get('bobot-kriteria', 'BobotKriteriaController::index');
    $routes->get('bobot-kriteria/(:num)', 'BobotKriteriaController::show/$1');
    $routes->post('bobot-kriteria', 'BobotKriteriaController::store');
    $routes->put('bobot-kriteria/(:num)', 'BobotKriteriaController::update/$1');
    $routes->patch('bobot-kriteria/(:num)', 'BobotKriteriaController::update/$1');
    $routes->delete('bobot-kriteria/(:num)', 'BobotKriteriaController::delete/$1');

    // Hasil TOPSIS CRUD
    $routes->get('topsis', 'TopsisController::index');
    $routes->get('topsis/(:num)', 'TopsisController::show/$1');
    $routes->post('topsis', 'TopsisController::store');
    $routes->put('topsis/(:num)', 'TopsisController::update/$1');
    $routes->patch('topsis/(:num)', 'TopsisController::update/$1');
    $routes->delete('topsis/(:num)', 'TopsisController::delete/$1');

    // Hasil ELECTRE CRUD
    $routes->get('electre', 'ElectreController::index');
    $routes->get('electre/(:num)', 'ElectreController::show/$1');
    $routes->post('electre', 'ElectreController::store');
    $routes->put('electre/(:num)', 'ElectreController::update/$1');
    $routes->patch('electre/(:num)', 'ElectreController::update/$1');
    $routes->delete('electre/(:num)', 'ElectreController::delete/$1');

    // Perbandingan Metode CRUD
    $routes->get('perbandingan-metode', 'PerbandinganMetodeController::index');
    $routes->get('perbandingan-metode/(:num)', 'PerbandinganMetodeController::show/$1');
    $routes->post('perbandingan-metode', 'PerbandinganMetodeController::store');
    $routes->put('perbandingan-metode/(:num)', 'PerbandinganMetodeController::update/$1');
    $routes->patch('perbandingan-metode/(:num)', 'PerbandinganMetodeController::update/$1');
    $routes->delete('perbandingan-metode/(:num)', 'PerbandinganMetodeController::delete/$1');

    $routes->group('spk', static function ($routes) {
        $routes->post('topsis', 'Spk\\TopsisSpkController::hitung');
        $routes->post('electre', 'Spk\\ElectreSpkController::hitung');
        $routes->post('bandingkan', 'Spk\\PerbandinganSpkController::bandingkan');
    });
});
