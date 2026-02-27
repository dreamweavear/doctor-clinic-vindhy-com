<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// ROOT -> redirect to login
// ============================================================
$routes->get('/', function () {
    return redirect()->to(base_url('auth/login'));
});

// ============================================================
// PUBLIC ROUTES (no auth needed)
// Auth controller is in default namespace App\Controllers
// ============================================================
$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
    $routes->get('forgot-password', 'Auth::forgotPassword');
    $routes->post('forgot-password', 'Auth::forgotPassword');
    $routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
    $routes->post('reset-password/(:segment)', 'Auth::resetPassword/$1');
});

// ============================================================
// SHARED AUTHENTICATED ROUTES
// ============================================================
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

// ============================================================
// ADMIN ROUTES
// ============================================================
$routes->group('admin', [
    'namespace' => 'App\Controllers\Admin',
    'filter' => ['auth', 'role:admin'],
], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users/store', 'Users::store');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update/(:num)', 'Users::update/$1');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');
    $routes->post('users/toggle/(:num)', 'Users::toggleStatus/$1');
    $routes->get('mapping', 'Mapping::index');
    $routes->post('mapping/store', 'Mapping::store');
    $routes->get('mapping/delete/(:num)/(:num)', 'Mapping::delete/$1/$2');
    $routes->get('patients', 'Patients::index');
    $routes->get('patients/view/(:num)', 'Patients::view/$1');
    $routes->get('reports', 'Reports::index');
});

// ============================================================
// DOCTOR ROUTES
// ============================================================
$routes->group('doctor', [
    'namespace' => 'App\Controllers\Doctor',
    'filter' => ['auth', 'role:doctor'],
], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('patients', 'Patients::index');
    $routes->get('patients/view/(:num)', 'Patients::view/$1');
    $routes->get('prescriptions/create/(:num)', 'Prescriptions::create/$1');
    $routes->post('prescriptions/store', 'Prescriptions::store');
    $routes->get('prescriptions/view/(:num)', 'Prescriptions::view/$1');
    $routes->get('prescriptions/print/(:num)', 'Prescriptions::printView/$1');
    // Satisfaction tracker
    $routes->post('satisfaction/save', 'Satisfaction::save');
    $routes->get('satisfaction/report', 'Satisfaction::report');
});

// ============================================================
// RECEPTIONIST ROUTES
// ============================================================
$routes->group('receptionist', [
    'namespace' => 'App\Controllers\Receptionist',
    'filter' => ['auth', 'role:receptionist'],
], function ($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('patients', 'Patients::index');
    $routes->get('patients/create', 'Patients::create');
    $routes->post('patients/store', 'Patients::store');
    $routes->get('patients/view/(:num)', 'Patients::view/$1');
    $routes->get('visits/create/(:num)', 'Visits::create/$1');
    $routes->post('visits/store', 'Visits::store');
    $routes->get('visits/slip/(:num)', 'Visits::slip/$1');
});