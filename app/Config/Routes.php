<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::welcome');
$routes->get('/tasks', 'Tasks::index');
$routes->get('/profile', 'Profile::index');
$routes->get('/about', 'Pages::about');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->post('/logout', 'Auth::logout', ['filter' => 'auth']);

$routes->group('tasks', ['filter' => 'auth'], static function ($routes): void {
    $routes->get('new', 'Tasks::new');
    $routes->post('', 'Tasks::create');
    $routes->get('(:num)/edit', 'Tasks::edit/$1');
    $routes->post('(:num)', 'Tasks::update/$1');
    $routes->post('(:num)/delete', 'Tasks::delete/$1');
});
