<?php
use CodeIgniter\Router\RouteCollection;

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

// Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');

// Admin Routes
$routes->group('admin', ['filter' => 'auth:admin'], function ($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');

    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/create', 'Admin\Users::create');
    $routes->post('users/store', 'Admin\Users::store');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    $routes->get('kas_masuk', 'Admin\KasMasuk::index');
    $routes->get('kas_masuk/create', 'Admin\KasMasuk::create');
    $routes->post('kas_masuk/store', 'Admin\KasMasuk::store');
    $routes->get('kas_masuk/edit/(:num)', 'Admin\KasMasuk::edit/$1');
    $routes->post('kas_masuk/update/(:num)', 'Admin\KasMasuk::update/$1');
    $routes->get('kas_masuk/delete/(:num)', 'Admin\KasMasuk::delete/$1');

    $routes->get('pengajuan', 'Admin\Pengajuan::index');
    $routes->get('pengajuan/approve/(:num)', 'Admin\Pengajuan::approve/$1');
    $routes->get('pengajuan/reject/(:num)', 'Admin\Pengajuan::reject/$1');
    $routes->post('pengajuan/process/(:num)', 'Admin\Pengajuan::process/$1');

    $routes->get('kas_keluar', 'Admin\KasKeluar::index');
    $routes->get('kas_keluar/edit/(:num)', 'Admin\KasKeluar::edit/$1');
    $routes->post('kas_keluar/update/(:num)', 'Admin\KasKeluar::update/$1');
    $routes->get('kas_keluar/delete/(:num)', 'Admin\KasKeluar::delete/$1');

    $routes->get('laporan', 'Admin\Laporan::index');

    // ✅ PERBAIKAN: Pindahkan routes profile ke sini (tidak nested)
    $routes->get('profile', 'Admin\Profile::index');
    $routes->post('profile/update', 'Admin\Profile::update');
    $routes->post('profile/update-password', 'Admin\Profile::updatePassword');
    $routes->post('profile/update-photo', 'Admin\Profile::updatePhoto');
    $routes->post('profile/remove-photo', 'Admin\Profile::removePhoto');
});

// User Routes
$routes->group('user', ['filter' => 'auth:teknisi,penagih'], function ($routes) {
    $routes->get('dashboard', 'User\Dashboard::index');
    $routes->get('pengajuan', 'User\Pengajuan::index');
    $routes->get('pengajuan/create', 'User\Pengajuan::create');
    $routes->post('pengajuan/store', 'User\Pengajuan::store');
    $routes->get('pengajuan/index', 'User\Pengajuan::index');
    $routes->get('pengajuan/history', 'User\Pengajuan::history');

    // ✅ PERBAIKAN: Pindahkan routes profile user ke sini
    $routes->get('profile', 'User\Profile::index');
    $routes->post('profile/update', 'User\Profile::update');
    $routes->post('profile/update-password', 'User\Profile::updatePassword');
    $routes->post('profile/update-photo', 'User\Profile::updatePhoto');
    $routes->post('profile/remove-photo', 'User\Profile::removePhoto');
});