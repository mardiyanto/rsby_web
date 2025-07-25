<?= $this->include('frontend/layout/header') ?>

<!-- 404 Error Section -->
<section class="error-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="error-content" data-aos="fade-up">
                    <div class="error-icon mb-4">
                        <i class="fas fa-exclamation-triangle fa-5x text-warning"></i>
                    </div>
                    
                    <h1 class="error-title mb-3">404</h1>
                    <h2 class="error-subtitle mb-4">Halaman Tidak Ditemukan</h2>
                    
                    <p class="error-message mb-4">
                        <?= $message ?? 'Maaf, halaman yang Anda cari tidak ditemukan.' ?>
                        <?php if (isset($slug)): ?>
                        <br><small class="text-muted">Slug: <?= esc($slug) ?></small>
                        <?php endif; ?>
                    </p>
                    
                    <div class="error-actions mb-5">
                        <a href="<?= base_url() ?>" class="btn btn-primary me-3">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="<?= base_url('frontcontact') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                    
                    <?php if (!empty($suggestions)): ?>
                    <div class="suggestions-section">
                        <h4 class="mb-3">Mungkin yang Anda cari:</h4>
                        <div class="row">
                            <?php foreach ($suggestions as $suggestion): ?>
                            <div class="col-md-6 mb-3">
                                <div class="suggestion-card">
                                    <h5>
                                        <a href="<?= base_url('fronthalaman/' . $suggestion['slug']) ?>">
                                            <?= esc($suggestion['judul']) ?>
                                        </a>
                                    </h5>
                                    <p class="text-muted">
                                        <?= substr(strip_tags($suggestion['konten']), 0, 100) ?>...
                                    </p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Section -->
<section class="search-section py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="search-content text-center" data-aos="fade-up">
                    <h3 class="mb-3">Cari Halaman Lain</h3>
                    <form action="<?= base_url('frontsearch') ?>" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" 
                                   placeholder="Cari berita, halaman, download..." 
                                   value="<?= isset($slug) ? esc($slug) : '' ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Links Section -->
<section class="quick-links-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-5" data-aos="fade-up">
                    <h3 class="section-title">Halaman Populer</h3>
                    <div class="title-line mx-auto"></div>
                </div>
                
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="quick-link-card text-center">
                            <div class="quick-link-icon mb-3">
                                <i class="fas fa-info-circle fa-3x text-primary"></i>
                            </div>
                            <h5>Profil</h5>
                            <p class="text-muted">Tentang Biddokkes POLRI</p>
                            <a href="<?= base_url('fronthalaman/profil') ?>" class="btn btn-outline-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="quick-link-card text-center">
                            <div class="quick-link-icon mb-3">
                                <i class="fas fa-history fa-3x text-primary"></i>
                            </div>
                            <h5>Sejarah</h5>
                            <p class="text-muted">Sejarah Biddokkes POLRI</p>
                            <a href="<?= base_url('fronthalaman/sejarah') ?>" class="btn btn-outline-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="quick-link-card text-center">
                            <div class="quick-link-icon mb-3">
                                <i class="fas fa-sitemap fa-3x text-primary"></i>
                            </div>
                            <h5>Struktur</h5>
                            <p class="text-muted">Struktur Organisasi</p>
                            <a href="<?= base_url('fronthalaman/struktur') ?>" class="btn btn-outline-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="400">
                        <div class="quick-link-card text-center">
                            <div class="quick-link-icon mb-3">
                                <i class="fas fa-hospital fa-3x text-primary"></i>
                            </div>
                            <h5>Fasilitas</h5>
                            <p class="text-muted">Fasilitas Kesehatan</p>
                            <a href="<?= base_url('fronthalaman/fasilitas') ?>" class="btn btn-outline-primary btn-sm">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.error-section {
    min-height: 60vh;
    display: flex;
    align-items: center;
}

.error-title {
    font-size: 6rem;
    font-weight: bold;
    color: var(--primary-navy);
}

.error-subtitle {
    color: var(--accent-blue);
}

.suggestion-card {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    border-left: 4px solid var(--primary-navy);
}

.quick-link-card {
    background: white;
    padding: 2rem 1rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.quick-link-card:hover {
    transform: translateY(-5px);
}

.search-form .input-group {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 25px;
    overflow: hidden;
}

.search-form .form-control {
    border: none;
    padding: 12px 20px;
}

.search-form .btn {
    border: none;
    padding: 12px 20px;
    border-radius: 0 25px 25px 0;
}
</style>

<?= $this->include('frontend/layout/footer') ?> 