<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
//$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'LandingPage::index');
$routes->get('/403', 'Home::error403');
$routes->get('/login', 'Web\Profile::login');
$routes->get('/register', 'Web\Profile::register');

// App
$routes->group('web', ['namespace' => 'App\Controllers\Web'], function($routes) {
    $routes->resource('rumahGadang');
    $routes->get('/', 'RumahGadang::recommendation');
    $routes->resource('event');
    $routes->get('visitHistory', 'Profile::visitHistory', ['filter' => 'role:user']);
    
    
    // Profile
    $routes->group('profile', function ($routes) {
        $routes->get('/', 'Profile::profile', ['filter' => 'login']);
        $routes->get('changePassword', 'Profile::changePassword', ['filter' => 'login']);
        $routes->post('changePassword', 'Profile::changePassword', ['filter' => 'login']);
        $routes->get('update', 'Profile::updateProfile', ['filter' => 'login']);
        $routes->post('update', 'Profile::update', ['filter' => 'login']);
    });
});

// API
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->resource('rumahGadang');
    $routes->get('recommendation', 'RumahGadang::recommendation');
    $routes->post('recommendationOwner', 'RumahGadang::recommendationByOwner');
    $routes->post('recommendation', 'RumahGadang::updateRecommendation');
    $routes->post('rumahGadangOwner', 'RumahGadang::listByOwner');
    $routes->post('rumahGadang/findByName', 'RumahGadang::findByName');
    $routes->post('rumahGadang/findByRadius', 'RumahGadang::findByRadius');
    $routes->post('rumahGadang/findByFacility', 'RumahGadang::findByFacility');
    $routes->post('rumahGadang/findByRating', 'RumahGadang::findByRating');
    $routes->post('rumahGadang/findByCategory', 'RumahGadang::findByCategory');
    $routes->get('event/category', 'Event::category');
    $routes->resource('event');
    $routes->post('eventOwner', 'Event::listByOwner');
    $routes->post('event/findByName', 'Event::findByName');
    $routes->post('event/findByRadius', 'Event::findByRadius');
    $routes->post('event/findByRating', 'Event::findByRating');
    $routes->post('event/findByCategory', 'Event::findByCategory');
    $routes->post('event/findByDate', 'Event::findByDate');
    $routes->resource('culinaryPlace');
    $routes->post('culinaryPlaceOwner', 'CulinaryPlace::listByOwner');
    $routes->post('culinaryPlace/findByRadius', 'CulinaryPlace::findByRadius');
    $routes->resource('worshipPlace');
    $routes->post('worshipPlaceOwner', 'WorshipPlace::listByOwner');
    $routes->post('worshipPlace/findByRadius', 'WorshipPlace::findByRadius');
    $routes->resource('souvenirPlace');
    $routes->post('souvenirPlaceOwner', 'SouvenirPlace::listByOwner');
    $routes->post('souvenirPlace/findByRadius', 'SouvenirPlace::findByRadius');
    $routes->resource('account');
    $routes->post('account/profile', 'Account::profile');
    $routes->post('account/changePassword', 'Account::changePassword');
    $routes->post('account/visitHistory', 'Account::visitHistory');
    $routes->post('account/newVisitHistory', 'Account::newVisitHistory');
    $routes->post('account/(:num)', 'Account::update/$1');
    $routes->resource('review');
    $routes->resource('user');
    $routes->resource('facility');
    $routes->post('village', 'Village::getData');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
