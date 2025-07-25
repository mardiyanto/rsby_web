<?= $this->include('frontend/layout/header') ?>

<!-- Hero Section with Slider -->
<section class="hero-section">
    <?php 
    // Debug: Tampilkan jumlah slides aktif
    $slidesCount = !empty($slides) ? count($slides) : 0;
    echo "<!-- Debug: Jumlah slides aktif: $slidesCount -->";
    
    if (!empty($slides)): 
    ?>
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <?php foreach ($slides as $index => $slide): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" 
                    class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                    aria-label="Slide <?= $index + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
        
        <div class="carousel-inner">
            <?php foreach ($slides as $index => $slide): ?>
            <?php 
            // Debug: Tampilkan data slide aktif
            echo "<!-- Debug: Active Slide $index - ID: " . ($slide['id_slide'] ?? 'null') . ", Judul: " . ($slide['judul'] ?? 'null') . ", Status: " . ($slide['status'] ?? 'null') . " -->";
            ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="hero-slide" style="background-image: url('<?= base_url('uploads/slide/' . ($slide['gambar'] ?? 'default.jpg')) ?>');">
                    <div class="hero-overlay">
                        <div class="container">
                            <div class="row align-items-center min-vh-100">
                                <div class="col-lg-6" data-aos="fade-right">
                                    <div class="hero-content">
                                        <h1 class="hero-title"><?= htmlspecialchars($slide['judul'] ?? 'Judul Slide') ?></h1>
                                        <p class="hero-description"><?= htmlspecialchars($slide['deskripsi'] ?? 'Deskripsi slide') ?></p>
                                        <?php if (!empty($slide['link'])): ?>
                                        <a href="<?= htmlspecialchars($slide['link']) ?>" class="btn btn-primary btn-lg">
                                            <i class="fas fa-arrow-right me-2"></i>Selengkapnya
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <?php if (count($slides) > 1): ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <!-- Default Hero if no active slides -->
    <div class="hero-slide default-hero">
        <div class="hero-overlay">
            <div class="container">
                <div class="row align-items-center min-vh-100">
                    <div class="col-lg-6" data-aos="fade-right">
                        <div class="hero-content">
                            <h1 class="hero-title">Selamat Datang di Biddokkes POLRI</h1>
                            <p class="hero-description">Pusat Kesehatan Kepolisian Republik Indonesia yang berkomitmen memberikan layanan kesehatan terbaik.</p>
                            <a href="<?= base_url('fronthalaman/profil') ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-info-circle me-2"></i>Tentang Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</section>

<!-- Quick Stats Section -->
<section class="stats-section py-5">
    <div class="container">
        <div class="row">
            <?php if (!empty($stats)): ?>
                <?php foreach ($stats as $index => $stat): ?>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="<?= esc($stat['ikon']) ?>"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number"><?= esc($stat['angka']) ?></h3>
                            <p class="stat-label"><?= esc($stat['judul']) ?></p>
                            <?php if (!empty($stat['deskripsi'])): ?>
                            <small class="stat-description"><?= esc($stat['deskripsi']) ?></small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback stats jika tidak ada data dari database -->
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">150+</h3>
                            <p class="stat-label">Dokter Spesialis</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">25+</h3>
                            <p class="stat-label">Rumah Sakit</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">50K+</h3>
                            <p class="stat-label">Pasien Dilayani</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">30+</h3>
                            <p class="stat-label">Tahun Pengalaman</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4" data-aos="fade-right">
                <div class="about-image">
                    <?php if (!empty($profilWebsite['logo'])): ?>
                    <img src="<?= base_url('uploads/profil/' . $profilWebsite['logo']) ?>" alt="Logo <?= $profilWebsite['nama_website'] ?? 'Biddokkes' ?>" class="img-fluid rounded shadow">
                    <?php else: ?>
                    <img src="<?= base_url('assets/images/about-biddokkes.jpg') ?>" alt="Profil Biddokkes" class="img-fluid rounded shadow">
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-content">
                    <div class="section-header mb-4">
                        <h6 class="text-primary fw-bold mb-2">TENTANG KAMI</h6>
                        <h2 class="section-title"><?= $profilWebsite['nama_website'] ?? 'Biddokkes POLRI' ?></h2>
                        <div class="title-line"></div>
                    </div>
                    
                    <div class="about-text">
                        <?php if (!empty($profilWebsite['deskripsi'])): ?>
                            <?= $profilWebsite['deskripsi'] ?>
                        <?php else: ?>
                            <p>Biddokkes POLRI adalah Pusat Kesehatan Kepolisian Republik Indonesia yang bertugas memberikan layanan kesehatan terbaik bagi anggota Polri dan masyarakat.</p>
                            <p>Dengan didukung oleh tenaga medis profesional dan fasilitas kesehatan modern, kami berkomitmen untuk memberikan pelayanan kesehatan yang berkualitas dan terjangkau.</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="about-features mt-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-primary me-2"></i>
                                    <span>Layanan 24 Jam</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-primary me-2"></i>
                                    <span>Dokter Spesialis</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-primary me-2"></i>
                                    <span>Fasilitas Modern</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="feature-item">
                                    <i class="fas fa-check-circle text-primary me-2"></i>
                                    <span>Pelayanan Prima</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?= base_url('fronthalaman/profil') ?>" class="btn btn-outline-primary mt-3">
                        <i class="fas fa-arrow-right me-2"></i>Baca Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Checkerboard Carousel Section -->
<section class="checkerboard-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold mb-2">LAYANAN KAMI</h6>
            <h2 class="section-title">Fasilitas & Layanan Unggulan</h2>
            <div class="title-line mx-auto"></div>
            <p class="text-muted mt-3">Berbagai layanan kesehatan terbaik yang kami sediakan untuk Anda</p>
        </div>
        
        <!-- Checkerboard Carousel -->
        <div id="checkerboardCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php 
                // Calculate number of slides based on data
                $layananData = isset($layanan) ? $layanan : [];
                $totalLayanan = count($layananData);
                $itemsPerSlide = 4;
                $totalSlides = $totalLayanan > 0 ? ceil($totalLayanan / $itemsPerSlide) : 3;
                
                for ($i = 0; $i < $totalSlides; $i++): 
                ?>
                <button type="button" data-bs-target="#checkerboardCarousel" data-bs-slide-to="<?= $i ?>" 
                        class="<?= $i === 0 ? 'active' : '' ?>" aria-current="<?= $i === 0 ? 'true' : 'false' ?>" 
                        aria-label="Slide <?= $i + 1 ?>"></button>
                <?php endfor; ?>
            </div>
            
            <div class="carousel-inner">
                <?php if (!empty($layananData)): ?>
                    <?php 
                    // Group layanan into slides
                    $layananChunks = array_chunk($layananData, $itemsPerSlide);
                    foreach ($layananChunks as $slideIndex => $slideLayanan): 
                    ?>
                    <div class="carousel-item <?= $slideIndex === 0 ? 'active' : '' ?>">
                        <div class="checkerboard-grid">
                            <div class="row g-4">
                                <?php foreach ($slideLayanan as $itemIndex => $layanan): ?>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($itemIndex + 1) * 100 ?>">
                                    <div class="checkerboard-item <?= ($itemIndex % 2 === 0) ? 'primary-item' : 'secondary-item' ?>">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="<?= $layanan['ikon'] ?? 'fas fa-stethoscope' ?>"></i>
                                            </div>
                                            <h4><?= htmlspecialchars($layanan['nama_layanan'] ?? 'Layanan') ?></h4>
                                            <p><?= htmlspecialchars($layanan['deskripsi'] ?? 'Deskripsi layanan') ?></p>
                                            <a href="<?= base_url('layanan/' . ($layanan['slug'] ?? '#')) ?>" class="btn btn-sm <?= ($itemIndex % 2 === 0) ? 'btn-outline-light' : 'btn-outline-primary' ?>">
                                                Selengkapnya
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback: Static Content -->
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="checkerboard-grid">
                            <div class="row g-4">
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                    <div class="checkerboard-item primary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-heartbeat"></i>
                                            </div>
                                            <h4>Poli Jantung</h4>
                                            <p>Layanan spesialis jantung dengan teknologi modern dan dokter berpengalaman</p>
                                            <a href="#" class="btn btn-sm btn-outline-light">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                                    <div class="checkerboard-item secondary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-brain"></i>
                                            </div>
                                            <h4>Poli Saraf</h4>
                                            <p>Spesialisasi neurologi untuk diagnosis dan pengobatan gangguan saraf</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
                                    <div class="checkerboard-item secondary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-bone"></i>
                                            </div>
                                            <h4>Poli Ortopedi</h4>
                                            <p>Layanan spesialis tulang dan sendi dengan perawatan terbaik</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
                                    <div class="checkerboard-item primary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                            <h4>Poli Mata</h4>
                                            <p>Spesialis mata dengan peralatan canggih untuk kesehatan penglihatan</p>
                                            <a href="#" class="btn btn-sm btn-outline-light">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="checkerboard-grid">
                            <div class="row g-4">
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                    <div class="checkerboard-item secondary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-baby"></i>
                                            </div>
                                            <h4>Poli Anak</h4>
                                            <p>Layanan kesehatan khusus anak dengan pendekatan yang ramah</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                                    <div class="checkerboard-item primary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-female"></i>
                                            </div>
                                            <h4>Poli Kebidanan</h4>
                                            <p>Layanan kesehatan ibu hamil dan persalinan yang aman</p>
                                            <a href="#" class="btn btn-sm btn-outline-light">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
                                    <div class="checkerboard-item primary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-tooth"></i>
                                            </div>
                                            <h4>Poli Gigi</h4>
                                            <p>Layanan kesehatan gigi dan mulut dengan teknologi modern</p>
                                            <a href="#" class="btn btn-sm btn-outline-light">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
                                    <div class="checkerboard-item secondary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-microscope"></i>
                                            </div>
                                            <h4>Laboratorium</h4>
                                            <p>Fasilitas laboratorium modern untuk pemeriksaan kesehatan</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <div class="checkerboard-grid">
                            <div class="row g-4">
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                                    <div class="checkerboard-item primary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-x-ray"></i>
                                            </div>
                                            <h4>Radiologi</h4>
                                            <p>Pemeriksaan radiologi dengan peralatan canggih dan akurat</p>
                                            <a href="#" class="btn btn-sm btn-outline-light">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                                    <div class="checkerboard-item secondary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-ambulance"></i>
                                            </div>
                                            <h4>IGD 24 Jam</h4>
                                            <p>Layanan gawat darurat 24 jam dengan tim medis siap siaga</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
                                    <div class="checkerboard-item secondary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-pills"></i>
                                            </div>
                                            <h4>Apotek</h4>
                                            <p>Fasilitas apotek dengan obat-obatan lengkap dan berkualitas</p>
                                            <a href="#" class="btn btn-sm btn-outline-primary">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
                                    <div class="checkerboard-item primary-item">
                                        <div class="item-content">
                                            <div class="item-icon">
                                                <i class="fas fa-hospital-user"></i>
                                            </div>
                                            <h4>Rawat Inap</h4>
                                            <p>Fasilitas rawat inap nyaman dengan perawatan intensif</p>
                                            <a href="#" class="btn btn-sm btn-outline-light">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($totalSlides > 1): ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#checkerboardCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#checkerboardCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold mb-2">GALERI KEGIATAN</h6>
            <h2 class="section-title">Dokumentasi Kegiatan</h2>
            <div class="title-line mx-auto"></div>
            <p class="text-muted mt-3">Lihat berbagai kegiatan dan aktivitas Biddokkes POLRI</p>
        </div>
        
        <?php if (!empty($galeri)): ?>
        <div class="row">
            <?php foreach ($galeri as $index => $item): ?>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                <div class="gallery-item">
                    <a href="<?= base_url('uploads/galeri/' . ($item['nama_file'] ?? $item['gambar'] ?? 'default.jpg')) ?>" data-lightbox="gallery" data-title="<?= $item['judul'] ?? 'Galeri' ?>">
                        <div class="gallery-image">
                            <img src="<?= base_url('uploads/galeri/' . ($item['nama_file'] ?? $item['gambar'] ?? 'default.jpg')) ?>" alt="<?= $item['judul'] ?? 'Galeri' ?>" class="img-fluid">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <i class="fas fa-search-plus"></i>
                                    <h5><?= $item['judul'] ?? 'Galeri' ?></h5>
                                    <p><?= $item['deskripsi'] ?? '' ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="<?= base_url('frontgaleri') ?>" class="btn btn-primary">
                <i class="fas fa-images me-2"></i>Lihat Semua Galeri
            </a>
        </div>
        <?php else: ?>
        <div class="text-center" data-aos="fade-up">
            <div class="empty-gallery">
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada galeri tersedia</h5>
                <p class="text-muted">Galeri akan ditampilkan di sini</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Latest News Section -->
<section class="news-section py-5">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h6 class="text-primary fw-bold mb-2">BERITA TERKINI</h6>
            <h2 class="section-title">Berita & Informasi</h2>
            <div class="title-line mx-auto"></div>
            <p class="text-muted mt-3">Dapatkan informasi terbaru seputar kesehatan dan kegiatan Biddokkes POLRI</p>
        </div>
        
        <?php if (!empty($berita_terbaru)): ?>
        <div class="row">
            <?php foreach ($berita_terbaru as $index => $berita): ?>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                <div class="news-card">
                    <div class="news-image">
                        <?php if (!empty($berita['gambar'])): ?>
                        <img src="<?= base_url('uploads/artikel/' . $berita['gambar']) ?>" alt="<?= $berita['judul'] ?? 'Berita' ?>" class="img-fluid">
                        <?php else: ?>
                        <img src="<?= base_url('assets/images/default-news.jpg') ?>" alt="<?= $berita['judul'] ?? 'Berita' ?>" class="img-fluid">
                        <?php endif; ?>
                        <div class="news-date">
                            <span class="day"><?= date('d', strtotime($berita['created_at'] ?? 'now')) ?></span>
                            <span class="month"><?= date('M', strtotime($berita['created_at'] ?? 'now')) ?></span>
                        </div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span><i class="fas fa-user me-1"></i><?= $berita['penulis'] ?? 'Admin' ?></span>
                            <span><i class="fas fa-folder me-1"></i><?= $berita['nama_kategori'] ?? 'Umum' ?></span>
                        </div>
                        <h5 class="news-title">
                            <a href="<?= base_url('frontberita/' . ($berita['slug'] ?? '#')) ?>"><?= $berita['judul'] ?? 'Judul Berita' ?></a>
                        </h5>
                        <p class="news-excerpt"><?= substr(strip_tags($berita['isi'] ?? $berita['konten'] ?? ''), 0, 120) ?>...</p>
                        <a href="<?= base_url('frontberita/' . ($berita['slug'] ?? '#')) ?>" class="read-more">
                            Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4" data-aos="fade-up">
            <a href="<?= base_url('frontberita') ?>" class="btn btn-outline-primary">
                <i class="fas fa-newspaper me-2"></i>Lihat Semua Berita
            </a>
        </div>
        <?php else: ?>
        <div class="text-center" data-aos="fade-up">
            <div class="empty-news">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada berita tersedia</h5>
                <p class="text-muted">Berita akan ditampilkan di sini</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Contact CTA Section -->
<section class="cta-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h2 class="cta-title">Butuh Bantuan atau Informasi?</h2>
                <p class="cta-description">Tim kami siap membantu Anda dengan layanan kesehatan terbaik. Hubungi kami sekarang!</p>
            </div>
            <div class="col-lg-4 text-end" data-aos="fade-left">
                <a href="<?= base_url('frontcontact') ?>" class="btn btn-light btn-lg">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<?= $this->include('frontend/layout/footer') ?>

<script>
// Hero Carousel Initialization
document.addEventListener('DOMContentLoaded', function() {
    console.log('Home page loaded');
    
    // Check if hero carousel exists
    const heroCarousel = document.getElementById('heroCarousel');
    if (heroCarousel) {
        console.log('Hero carousel found, initializing...');
        
        // Initialize Bootstrap carousel
        const bsHeroCarousel = new bootstrap.Carousel(heroCarousel, {
            interval: 5000, // 5 seconds
            wrap: true,
            keyboard: true,
            pause: 'hover'
        });
        
        // Add event listeners
        heroCarousel.addEventListener('slide.bs.carousel', function (event) {
            console.log('Hero slide changing to:', event.to);
        });
        
        heroCarousel.addEventListener('slid.bs.carousel', function (event) {
            console.log('Hero slide changed to:', event.to);
        });
        
        console.log('Hero carousel initialized successfully');
    } else {
        console.log('No hero carousel found, showing default hero');
    }
    
    // Checkerboard Carousel Initialization
    const checkerboardCarousel = document.getElementById('checkerboardCarousel');
    if (checkerboardCarousel) {
        console.log('Checkerboard carousel found, initializing...');
        
        // Initialize Bootstrap carousel for checkerboard
        const bsCheckerboardCarousel = new bootstrap.Carousel(checkerboardCarousel, {
            interval: 6000, // 6 seconds
            wrap: true,
            keyboard: true,
            pause: 'hover'
        });
        
        // Add event listeners for checkerboard carousel
        checkerboardCarousel.addEventListener('slide.bs.carousel', function (event) {
            console.log('Checkerboard slide changing to:', event.to);
        });
        
        checkerboardCarousel.addEventListener('slid.bs.carousel', function (event) {
            console.log('Checkerboard slide changed to:', event.to);
        });
        
        console.log('Checkerboard carousel initialized successfully');
    } else {
        console.log('No checkerboard carousel found');
    }
    
    // Debug: Log slides data
    <?php if (!empty($slides)): ?>
    console.log('Slides data:', <?= json_encode($slides) ?>);
    <?php else: ?>
    console.log('No slides data available');
    <?php endif; ?>
});

// AOS Animation Initialization
if (typeof AOS !== 'undefined') {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });
}
</script> 