<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Argon Dashboard - Free Dashboard for Bootstrap 4 by Creative Tim
  </title>
  <!-- Favicon -->
  <link href="./assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="<?= base_url('argon/assets/js/plugins/nucleo/css/nucleo.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('argon/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="<?= base_url('argon/assets/css/argon-dashboard.css?v=1.1.2') ?>" rel="stylesheet" />
</head>

<body class="">
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="<?= base_url('dashboard/admin') ?>">
        <img src="<?= base_url('argon/assets/img/brand/blue.png') ?>" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="<?= base_url('argon/assets/img/theme/team-1-800x800.jpg') ?>">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <!-- <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-settings-gear-65"></i>
              <span>Settings</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-calendar-grid-58"></i>
              <span>Activity</span>
            </a>
            <a href="./examples/profile.html" class="dropdown-item">
              <i class="ni ni-support-16"></i>
              <span>Support</span>
            </a> -->
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('login/logout') ?>" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="<?= base_url('dashboard/admin') ?>">
                <img src="<?= base_url('argon/assets/img/brand/blue.png') ?>">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <div class="input-group input-group-rounded input-group-merge">
            <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fa fa-search"></span>
              </div>
            </div>
          </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item <?= (current_url() == base_url('dashboard/admin')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('dashboard/admin')) ? 'active' : '' ?>" href="<?= base_url('dashboard/admin') ?>">
              <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          
          <!-- Konten Website -->
          <li class="nav-item">
            <a class="nav-link" href="#navbar-konten" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-konten">
              <i class="ni ni-collection text-info"></i>
              <span class="nav-link-text">Konten Website</span>
            </a>
            <div class="collapse" id="navbar-konten">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('berita') ?>">
                    <i class="ni ni-pin-3 text-orange"></i> Berita
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('halaman') ?>">
                    <i class="ni ni-collection text-purple"></i> Halaman
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('galeri') ?>">
                    <i class="ni ni-image text-pink"></i> Galeri
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('slide') ?>">
                    <i class="fas fa-images text-blue"></i> Slide
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('checkerboard-carousel') ?>">
                    <i class="fas fa-th-large text-green"></i> Checkerboard Carousel
                  </a>
                </li>
              </ul>
            </div>
          </li>
          
          <!-- Kategori -->
          <li class="nav-item">
            <a class="nav-link" href="#navbar-kategori" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-kategori">
              <i class="ni ni-tag text-warning"></i>
              <span class="nav-link-text">Kategori</span>
            </a>
            <div class="collapse" id="navbar-kategori">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('kategori') ?>">
                    <i class="ni ni-planet text-blue"></i> Kategori Berita
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('kategori-download') ?>">
                    <i class="ni ni-folder-17 text-green"></i> Kategori Download
                  </a>
                </li>
              </ul>
            </div>
          </li>
          
          <!-- Download -->
          <li class="nav-item <?= (current_url() == base_url('download')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('download')) ? 'active' : '' ?>" href="<?= base_url('download') ?>">
              <i class="ni ni-key-25 text-info"></i> Download
            </a>
          </li>
          
          <!-- Pesan Kontak -->
          <li class="nav-item <?= (current_url() == base_url('pesan-kontak')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('pesan-kontak')) ? 'active' : '' ?>" href="<?= base_url('pesan-kontak') ?>">
              <i class="ni ni-email-83 text-orange"></i> Pesan Kontak
            </a>
          </li>
          
          <!-- FAQ -->
          <li class="nav-item <?= (current_url() == base_url('faq')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('faq')) ? 'active' : '' ?>" href="<?= base_url('faq') ?>">
              <i class="ni ni-chat-round text-info"></i> FAQ
            </a>
          </li>
          
          <!-- Quick Stats -->
          <li class="nav-item <?= (current_url() == base_url('stats')) ? 'active' : '' ?>">
            <a class="nav-link <?= (current_url() == base_url('stats')) ? 'active' : '' ?>" href="<?= base_url('stats') ?>">
              <i class="ni ni-chart-bar-32 text-success"></i> Quick Stats
            </a>
          </li>
          
          <!-- Manajemen Sistem -->
          <li class="nav-item">
            <a class="nav-link" href="#navbar-sistem" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-sistem">
              <i class="ni ni-settings-gear-65 text-default"></i>
              <span class="nav-link-text">Manajemen</span>
            </a>
            <div class="collapse" id="navbar-sistem">
              <ul class="nav nav-sm flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('user') ?>">
                    <i class="ni ni-single-02 text-yellow"></i> User
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="<?= base_url('profil') ?>">
                    <i class="ni ni-settings-gear-65 text-default"></i> Profil Website
                  </a>
                </li>
              </ul>
            </div>
          </li>
        </ul>
        <!-- Divider -->
       
      </div>
    </div>
  </nav>
  