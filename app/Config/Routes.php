<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', function() {
    return view('welcome_message');
});

// API Routes untuk Mahasiswa
$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    
    // Mahasiswa Resource Routes
    $routes->get('mahasiswa', 'Mahasiswa::index');              // GET all
    $routes->get('mahasiswa/stats', 'Mahasiswa::stats');        // GET stats
    $routes->get('mahasiswa/(:num)', 'Mahasiswa::show/$1');     // GET by ID
    $routes->post('mahasiswa', 'Mahasiswa::create');            // POST create
    $routes->put('mahasiswa/(:num)', 'Mahasiswa::update/$1');   // PUT update
    $routes->post('mahasiswa/update/(:num)', 'Mahasiswa::updatePost/$1'); // POST update (alternative)
    $routes->delete('mahasiswa/(:num)', 'Mahasiswa::delete/$1');// DELETE
    
});

// Alias routes (tanpa prefix 'api')
$routes->get('mahasiswa', 'Mahasiswa::index');
$routes->get('mahasiswa/stats', 'Mahasiswa::stats');
$routes->get('mahasiswa/(:num)', 'Mahasiswa::show/$1');
$routes->post('mahasiswa', 'Mahasiswa::create');
$routes->put('mahasiswa/(:num)', 'Mahasiswa::update/$1');
$routes->post('mahasiswa/update/(:num)', 'Mahasiswa::updatePost/$1');
$routes->delete('mahasiswa/(:num)', 'Mahasiswa::delete/$1');