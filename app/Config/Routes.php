<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], '/add_book', 'Book::addBook');
$routes->match(['get', 'post'], '/register', 'Login::register');
$routes->match(['get', 'post'], '/login', 'Login::login');
$routes->match(['get', 'post'], '/update/(:segment)', 'User::update/$1',['filter' => 'authGuard']);
$routes->match(['get', 'post'], '/search', 'Home::search');

$routes->get('/home', 'Home::home');
$routes->get('/profile/(:segment)', 'User::profile/$1',['filter' => 'authGuard']);
$routes->get('/delete-book/(:segment)', 'Book::deleteBook/$1');
$routes->get('/book/(:segment)/(:segment)', 'Book::view/$1/$2');
$routes->get('/browse/(:segment)', 'Home::category/$1');
$routes->get('/search=(:segment)/opt=(:segment)', 'Home::search/$1/$2');
$routes->get('/logout', 'Login::logout');
$routes->get('/find-bookstore', 'Location::view');

$routes->post('save-review/(:segment)','Book::postReview/$1');
$routes->post('update-review/(:segment)','Book::updateReview/$1');

$routes->get('/ajax/getlists/(:segment)/(:segment)', 'Ajax::getLists/$1/$2');
$routes->get('/ajax/updatelist/(:segment)/(:segment)/(:segment)', 'Ajax::updateList/$1/$2/$3');
$routes->get('/ajax/bookinlists/(:segment)/(:segment)', 'Ajax::getBookInLists/$1/$2');
$routes->get('/ajax/search/(:segment)', 'AjaxSearch::fetch/$1');
$routes->get('/ajax/sortby/(:segment)/(:segment)', 'Ajax::sortCategory/$1/$2');


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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
