<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Storefront Publik
$routes->get('/', 'Home::index');

// API Publik (Analitik & Newsletter)
$routes->post('api/track', 'ApiController::track');
$routes->post('api/newsletter', 'ApiController::newsletter');

// Autentikasi Admin
$routes->get('admin/login', 'Admin\AuthController::login');
$routes->post('admin/login', 'Admin\AuthController::attempt');
$routes->get('admin/logout', 'Admin\AuthController::logout');

// Dashboard Admin (Terproteksi Filter adminauth)
$routes->group('admin', ['filter' => 'adminauth'], static function (RouteCollection $routes) {
    $routes->get('/', 'Admin\DashboardController::index');

    // Produk
    $routes->get('products', 'Admin\ProductController::index');
    $routes->get('products/create', 'Admin\ProductController::create');
    $routes->post('products/store', 'Admin\ProductController::store');
    $routes->get('products/edit/(:num)', 'Admin\ProductController::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\ProductController::update/$1');
    $routes->post('products/toggle/(:num)', 'Admin\ProductController::toggle/$1');
    $routes->post('products/delete/(:num)', 'Admin\ProductController::delete/$1');

    // Lookbook & Hotspot Editor
    $routes->get('lookbook', 'Admin\LookbookController::index');
    $routes->post('lookbook/store', 'Admin\LookbookController::store');
    $routes->post('lookbook/update/(:num)', 'Admin\LookbookController::update/$1');
    $routes->post('lookbook/delete/(:num)', 'Admin\LookbookController::delete/$1');

    // Ulasan, FAQ & Panduan Ukuran
    $routes->get('content', 'Admin\ContentController::index');
    $routes->post('content/review/store', 'Admin\ContentController::storeReview');
    $routes->post('content/review/delete/(:num)', 'Admin\ContentController::deleteReview/$1');
    $routes->post('content/faq/store', 'Admin\ContentController::storeFaq');
    $routes->post('content/faq/delete/(:num)', 'Admin\ContentController::deleteFaq/$1');
    $routes->post('content/size/update', 'Admin\ContentController::updateSizes');

    // Pengaturan Toko
    $routes->get('settings', 'Admin\SettingsController::index');
    $routes->post('settings/save', 'Admin\SettingsController::save');

    // Newsletter Subscribers
    $routes->get('subscribers', 'Admin\SubscriberController::index');
    $routes->get('subscribers/export', 'Admin\SubscriberController::exportCsv');
    $routes->post('subscribers/delete/(:num)', 'Admin\SubscriberController::delete/$1');
});
