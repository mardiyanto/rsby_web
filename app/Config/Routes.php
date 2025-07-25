<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Frontend::index');
//$routes->get('/', 'Auth::login'); 
$routes->get('login', 'Auth::login');
$routes->get('login/logout', 'Auth::logout');
$routes->post('login/doLogin', 'Auth::doLogin');

//admin
$routes->get('dashboard/admin', 'Dashboard::admin');
$routes->get('dashboard/user', 'Dashboard::user'); 
//user

$routes->get('user', 'User::index');
// $routes->get('user/index', 'User::index');

// Admin routes (kategori)
$routes->get('kategori', 'Kategori::index');
$routes->post('kategori/store', 'Kategori::store');
$routes->get('kategori/edit/(:num)', 'Kategori::edit/$1');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->get('kategori/delete/(:num)', 'Kategori::delete/$1');

// Admin routes (berita)
$routes->get('berita', 'Berita::index');
$routes->get('berita/create', 'Berita::create');
$routes->post('berita/store', 'Berita::store');
$routes->get('berita/edit/(:num)', 'Berita::edit/$1');
$routes->post('berita/update/(:num)', 'Berita::update/$1');
$routes->get('berita/delete/(:num)', 'Berita::delete/$1');
$routes->post('berita/generate-slug', 'Berita::generateSlugAjax');

// Admin routes (kategori download)
$routes->get('kategori-download', 'KategoriDownload::index');
$routes->get('kategori-download/create', 'KategoriDownload::create');
$routes->post('kategori-download/store', 'KategoriDownload::store');
$routes->get('kategori-download/edit/(:num)', 'KategoriDownload::edit/$1');
$routes->post('kategori-download/update/(:num)', 'KategoriDownload::update/$1');
$routes->get('kategori-download/delete/(:num)', 'KategoriDownload::delete/$1');

// Admin routes (download)
$routes->get('download', 'Download::index');
$routes->get('download/create', 'Download::create');
$routes->post('download/store', 'Download::store');
$routes->get('download/edit/(:num)', 'Download::edit/$1');
$routes->post('download/update/(:num)', 'Download::update/$1');
$routes->get('download/delete/(:num)', 'Download::delete/$1');
$routes->get('download/download/(:num)', 'Download::download/$1');

// Admin routes (halaman)
$routes->get('halaman', 'Halaman::index');
$routes->get('halaman/create', 'Halaman::create');
$routes->post('halaman/store', 'Halaman::store');
$routes->get('halaman/edit/(:num)', 'Halaman::edit/$1');
$routes->post('halaman/update/(:num)', 'Halaman::update/$1');
$routes->get('halaman/delete/(:num)', 'Halaman::delete/$1');

// Admin routes (slide)
$routes->get('slide', 'Slide::index');
$routes->get('slide/create', 'Slide::create');
$routes->post('slide/store', 'Slide::store');
$routes->get('slide/edit/(:num)', 'Slide::edit/$1');
$routes->post('slide/update/(:num)', 'Slide::update/$1');
$routes->get('slide/delete/(:num)', 'Slide::delete/$1');
$routes->get('slide/toggle-status/(:num)', 'Slide::toggleStatus/$1');

// Admin routes (user)
$routes->get('user', 'User::index');
$routes->get('user/create', 'User::create');
$routes->post('user/store', 'User::store');
$routes->get('user/edit/(:num)', 'User::edit/$1');
$routes->post('user/update/(:num)', 'User::update/$1');
$routes->get('user/delete/(:num)', 'User::delete/$1');

// User profile routes
$routes->get('user/profile', 'User::profile');
$routes->post('user/update-profile', 'User::updateProfile');
$routes->get('user/change-password', 'User::changePassword');
$routes->post('user/update-password', 'User::updatePassword');

// Admin routes (galeri)
$routes->get('galeri', 'Galeri::index');
$routes->get('galeri/create', 'Galeri::create');
$routes->post('galeri/store', 'Galeri::store');
$routes->get('galeri/edit/(:num)', 'Galeri::edit/$1');
$routes->post('galeri/update/(:num)', 'Galeri::update/$1');
$routes->get('galeri/delete/(:num)', 'Galeri::delete/$1');
$routes->get('galeri/download/(:num)', 'Galeri::download/$1');

// Admin routes (profil website)
$routes->get('profil', 'Profil::index');
$routes->post('profil/update', 'Profil::update');

// Frontend routes (dengan prefix 'front' untuk menghindari konflik)
$routes->get('frontberita', 'Frontend::berita');
$routes->get('frontberita/(:segment)', 'Frontend::beritaDetail/$1');
$routes->get('frontberita/detail/(:num)', 'Frontend::beritaDetailById/$1');
$routes->get('frontgaleri', 'Frontend::galeri');
$routes->get('fronthalaman/(:segment)', 'Frontend::halaman/$1');
$routes->get('frontdownload', 'Frontend::download');
$routes->get('frontdownload/file/(:num)', 'Frontend::downloadFile/$1');
$routes->get('frontdownload/preview/(:num)', 'Frontend::previewPdf/$1');
$routes->get('frontdownload/force/(:num)', 'Frontend::forceDownload/$1');
$routes->get('frontcontact', 'Frontend::contact');
$routes->get('frontsearch', 'Frontend::search');


$routes->get('frontgaleri', 'Galeri::frontend');

// Pesan Kontak Routes
$routes->get('pesan-kontak', 'PesanKontak::index');
$routes->get('pesan-kontak/show/(:num)', 'PesanKontak::show/$1');
$routes->get('pesan-kontak/reply/(:num)', 'PesanKontak::reply/$1');
$routes->post('pesan-kontak/reply/(:num)', 'PesanKontak::reply/$1');
$routes->get('pesan-kontak/delete/(:num)', 'PesanKontak::delete/$1');
$routes->get('pesan-kontak/mark-as-read/(:num)', 'PesanKontak::markAsRead/$1');
$routes->post('pesan-kontak/mark-as-replied/(:num)', 'PesanKontak::markAsReplied/$1');
$routes->post('pesan-kontak/bulk-action', 'PesanKontak::bulkAction');
$routes->get('pesan-kontak/export', 'PesanKontak::export');

// Frontend Contact
$routes->post('send-contact', 'Frontend::sendContact');

// FAQ Routes
$routes->get('faq', 'Faq::index');
$routes->get('faq/create', 'Faq::create');
$routes->post('faq/create', 'Faq::create');
$routes->get('faq/edit/(:num)', 'Faq::edit/$1');
$routes->post('faq/edit/(:num)', 'Faq::edit/$1');
$routes->get('faq/delete/(:num)', 'Faq::delete/$1');
$routes->get('faq/toggle-status/(:num)', 'Faq::toggleStatus/$1');
$routes->post('faq/bulk-action', 'Faq::bulkAction');
$routes->post('faq/reorder', 'Faq::reorder');
$routes->get('faq/export', 'Faq::export');
$routes->get('faq/next-urutan', 'Faq::getNextUrutan');

// Stats Routes
$routes->get('stats', 'Stats::index');
$routes->get('stats/create', 'Stats::create');
$routes->post('stats/create', 'Stats::create');
$routes->get('stats/edit/(:num)', 'Stats::edit/$1');
$routes->post('stats/edit/(:num)', 'Stats::edit/$1');
$routes->get('stats/delete/(:num)', 'Stats::delete/$1');
$routes->get('stats/toggle-status/(:num)', 'Stats::toggleStatus/$1');
$routes->post('stats/bulk-action', 'Stats::bulkAction');
$routes->post('stats/reorder', 'Stats::reorder');
$routes->get('stats/export', 'Stats::export');
$routes->get('stats/next-urutan', 'Stats::getNextUrutan');

// Checkerboard Carousel Routes
$routes->get('checkerboard-carousel', 'CheckerboardCarousel::index');
$routes->get('checkerboard-carousel/create', 'CheckerboardCarousel::create');
$routes->post('checkerboard-carousel/store', 'CheckerboardCarousel::store');
$routes->get('checkerboard-carousel/edit/(:num)', 'CheckerboardCarousel::edit/$1');
$routes->post('checkerboard-carousel/update/(:num)', 'CheckerboardCarousel::update/$1');
$routes->get('checkerboard-carousel/delete/(:num)', 'CheckerboardCarousel::delete/$1');
$routes->get('checkerboard-carousel/toggle-status/(:num)', 'CheckerboardCarousel::toggleStatus/$1');
$routes->post('checkerboard-carousel/reorder', 'CheckerboardCarousel::reorder');


