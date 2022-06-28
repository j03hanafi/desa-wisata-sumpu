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

// App
$routes->group('web', ['namespace' => 'App\Controllers\Web'], function($routes) {
    $routes->resource('rumahGadang');
    $routes->get('/', 'RumahGadang::recommendation');
    $routes->match(['get','post'], 'rumahGadang/findByName', 'RumahGadang::findByName');
});

// API
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->resource('rumahGadang');
    $routes->get('recommendation', 'RumahGadang::recommendation');
    $routes->post('recommendationOwner', 'RumahGadang::recommendationByOwner');
    $routes->post('recommendation', 'RumahGadang::updateRecommendation');
    $routes->post('rumahGadangOwner', 'RumahGadang::listByOwner');
    $routes->post('rumahGadang/findByName', 'RumahGadang::findByName');
    $routes->resource('event');
    $routes->post('eventOwner', 'Event::listByOwner');
    $routes->post('event/findByName', 'Event::findByName');
    $routes->resource('culinaryPlace');
    $routes->post('culinaryPlaceOwner', 'CulinaryPlace::listByOwner');
    $routes->post('culinaryPlace/findByName', 'CulinaryPlace::findByName');
    $routes->post('culinaryPlace/findByMenu', 'CulinaryPlace::findByMenu');
    $routes->post('culinaryPlace/findByPrice', 'CulinaryPlace::findByPrice');
    $routes->resource('worshipPlace');
    $routes->post('worshipPlaceOwner', 'WorshipPlace::listByOwner');
    $routes->post('worshipPlace/findByName', 'WorshipPlace::findByName');
    $routes->post('worshipPlace/findByCategory', 'WorshipPlace::findByCategory');
    $routes->resource('souvenirPlace');
    $routes->post('souvenirPlaceOwner', 'SouvenirPlace::listByOwner');
    $routes->post('souvenirPlace/findByName', 'SouvenirPlace::findByName');
    $routes->post('souvenirPlace/findByProduct', 'SouvenirPlace::findByProduct');
    $routes->resource('account');
    $routes->post('account/changePassword', 'Account::changePassword');
    $routes->post('account/visitHistory', 'Account::visitHistory');
    $routes->post('account/newVisitHistory', 'Account::newVisitHistory');
    $routes->resource('review');
    $routes->resource('admin/owner');
    $routes->resource('admin/user');
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
