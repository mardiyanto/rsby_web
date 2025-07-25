
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? ($profilWebsite['nama_website'] ?? 'Biddokkes - Pusat Kesehatan Kepolisian') ?></title>
    <meta name="description" content="<?= $description ?? ($profilWebsite['deskripsi'] ?? 'Website resmi Pusat Kesehatan Kepolisian Republik Indonesia') ?>">
    <meta name="keywords" content="biddokkes, kesehatan, kepolisian, polri, medis">
    
    <?php if (!empty($profilWebsite['favicon'])): ?>
    <link rel="icon" type="image/x-icon" href="<?= base_url('uploads/profil/' . $profilWebsite['favicon']) ?>">
    <?php endif; ?>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Frontend CSS -->
    <link rel="stylesheet" href="<?= base_url('css/frontend.css') ?>">
</head>
<body>
    <!-- Top Header -->
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-info">
                        <?php if (!empty($profilWebsite['telepon'])): ?>
                        <span><i class="fas fa-phone"></i> <?= $profilWebsite['telepon'] ?></span>
                        <?php endif; ?>
                        <?php if (!empty($profilWebsite['email'])): ?>
                        <span><i class="fas fa-envelope"></i> <?= $profilWebsite['email'] ?></span>
                        <?php endif; ?>
                        <?php if (!empty($profilWebsite['alamat'])): ?>
                        <span><i class="fas fa-map-marker-alt"></i> <?= $profilWebsite['alamat'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="social-links text-end">
                        <?php if (!empty($profilWebsite['facebook'])): ?>
                        <a href="<?= $profilWebsite['facebook'] ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($profilWebsite['twitter'])): ?>
                        <a href="<?= $profilWebsite['twitter'] ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($profilWebsite['instagram'])): ?>
                        <a href="<?= $profilWebsite['instagram'] ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($profilWebsite['youtube'])): ?>
                        <a href="<?= $profilWebsite['youtube'] ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Header -->
    <header class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="logo-section d-flex align-items-center">
                        <?php if (!empty($profilWebsite['logo'])): ?>
                        <img src="<?= base_url('uploads/profil/' . $profilWebsite['logo']) ?>" alt="Logo" class="me-3" style="max-height: 60px;">
                        <?php else: ?>
                        <img src="<?= base_url('assets/images/logo-polri.png') ?>" alt="Logo Polri" class="me-3">
                        <?php endif; ?>
                        <div class="logo-text">
                            <h1><?= $profilWebsite['nama_website'] ?? 'BIDDOKKES POLRI' ?></h1>
                            <p><?= $profilWebsite['deskripsi'] ?? 'Pusat Kesehatan Kepolisian Republik Indonesia' ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <form class="search-box" action="<?= base_url('frontsearch') ?>" method="GET">
                        <input type="text" name="q" class="form-control" placeholder="Cari berita, halaman, download...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= current_url() == base_url() ? 'active' : '' ?>" href="<?= base_url() ?>">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'fronthalaman') !== false ? 'active' : '' ?>" href="<?= base_url('fronthalaman/profil') ?>">
                            <i class="fas fa-info-circle me-1"></i>Tentang Kami
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'frontberita') !== false ? 'active' : '' ?>" href="<?= base_url('frontberita') ?>">
                            <i class="fas fa-newspaper me-1"></i>Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'frontgaleri') !== false ? 'active' : '' ?>" href="<?= base_url('frontgaleri') ?>">
                            <i class="fas fa-images me-1"></i>Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'frontdownload') !== false ? 'active' : '' ?>" href="<?= base_url('frontdownload') ?>">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link <?= strpos(current_url(), 'frontcontact') !== false ? 'active' : '' ?>" href="<?= base_url('frontcontact') ?>">
                            <i class="fas fa-phone me-1"></i>Kontak
                        </a>
                    </li>
                </ul>
                        
                        <!-- Search Form -->
                        <form class="d-flex ms-3" action="<?= base_url('frontsearch') ?>" method="GET">
                            <div class="input-group">
                                <input class="form-control" type="search" name="q" placeholder="Cari..." aria-label="Search">
                                <button class="btn btn-outline-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
    </nav> 