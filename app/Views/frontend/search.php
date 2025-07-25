<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title">Hasil Pencarian</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pencarian</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Search Results Section -->
<section class="search-results-section py-5">
    <div class="container">
        <!-- Search Info -->
        <div class="search-info mb-5" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="search-title">
                        Hasil pencarian untuk: <span class="search-keyword">"<?= $keyword ?>"</span>
                    </h3>
                    <p class="search-summary text-muted">
                        Ditemukan <?= count($berita_results) + count($halaman_results) + count($download_results) ?> hasil
                    </p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="<?= base_url() ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Search Form -->
        <div class="search-form-wrapper mb-5" data-aos="fade-up">
            <form action="<?= base_url('frontsearch') ?>" method="GET" class="search-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Cari berita, halaman, download..." value="<?= $keyword ?>">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Results Tabs -->
        <div class="results-tabs mb-5" data-aos="fade-up">
            <ul class="nav nav-tabs" id="searchTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                        Semua (<?= count($berita_results) + count($halaman_results) + count($download_results) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="berita-tab" data-bs-toggle="tab" data-bs-target="#berita" type="button" role="tab">
                        Berita (<?= count($berita_results) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="halaman-tab" data-bs-toggle="tab" data-bs-target="#halaman" type="button" role="tab">
                        Halaman (<?= count($halaman_results) ?>)
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="download-tab" data-bs-toggle="tab" data-bs-target="#download" type="button" role="tab">
                        Download (<?= count($download_results) ?>)
                    </button>
                </li>
            </ul>
        </div>
        
        <!-- Tab Content -->
        <div class="tab-content" id="searchTabContent">
            <!-- All Results -->
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <?php if (count($berita_results) + count($halaman_results) + count($download_results) > 0): ?>
                <div class="search-results">
                    <!-- Berita Results -->
                    <?php if (!empty($berita_results)): ?>
                    <div class="result-section mb-5" data-aos="fade-up">
                        <h4 class="section-title">
                            <i class="fas fa-newspaper me-2"></i>Berita
                        </h4>
                        <div class="row">
                            <?php foreach ($berita_results as $berita): ?>
                            <div class="col-lg-6 mb-4">
                                <div class="search-result-card">
                                    <div class="result-icon">
                                        <i class="fas fa-newspaper"></i>
                                    </div>
                                    <div class="result-content">
                                        <h5 class="result-title">
                                            <a href="<?= base_url('frontberita/' . ($berita['slug'] ?? '#')) ?>"><?= $berita['judul'] ?? 'Judul Berita' ?></a>
                                        </h5>
                                        <p class="result-excerpt"><?= substr(strip_tags($berita['isi'] ?? $berita['konten'] ?? ''), 0, 150) ?>...</p>
                                        <div class="result-meta">
                                            <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($berita['created_at'] ?? 'now')) ?></span>
                                            <span><i class="fas fa-user me-1"></i><?= $berita['penulis'] ?? 'Admin' ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Halaman Results -->
                    <?php if (!empty($halaman_results)): ?>
                    <div class="result-section mb-5" data-aos="fade-up">
                        <h4 class="section-title">
                            <i class="fas fa-file-alt me-2"></i>Halaman
                        </h4>
                        <div class="row">
                            <?php foreach ($halaman_results as $halaman): ?>
                            <div class="col-lg-6 mb-4">
                                <div class="search-result-card">
                                    <div class="result-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div class="result-content">
                                        <h5 class="result-title">
                                            <a href="<?= base_url('fronthalaman/' . $halaman['slug']) ?>"><?= $halaman['judul'] ?></a>
                                        </h5>
                                        <p class="result-excerpt"><?= substr(strip_tags($halaman['konten']), 0, 150) ?>...</p>
                                        <div class="result-meta">
                                            <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($halaman['tanggal_publish'])) ?></span>
                                            <span><i class="fas fa-user me-1"></i><?= $halaman['penulis'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Download Results -->
                    <?php if (!empty($download_results)): ?>
                    <div class="result-section mb-5" data-aos="fade-up">
                        <h4 class="section-title">
                            <i class="fas fa-download me-2"></i>Download
                        </h4>
                        <div class="row">
                            <?php foreach ($download_results as $download): ?>
                            <div class="col-lg-6 mb-4">
                                <div class="search-result-card">
                                    <div class="result-icon">
                                        <i class="fas fa-download"></i>
                                    </div>
                                    <div class="result-content">
                                        <h5 class="result-title">
                                            <a href="<?= base_url('frontdownload/file/' . $download['id_download']) ?>"><?= $download['judul'] ?></a>
                                        </h5>
                                        <p class="result-excerpt"><?= $download['deskripsi'] ?></p>
                                        <div class="result-meta">
                                            <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($download['created_at'])) ?></span>
                                            <span><i class="fas fa-download me-1"></i><?= $download['download_count'] ?? 0 ?> downloads</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <!-- No Results -->
                <div class="no-results text-center py-5" data-aos="fade-up">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted mb-3">Tidak ada hasil ditemukan</h4>
                    <p class="text-muted mb-4">
                        Maaf, tidak ada hasil yang cocok dengan pencarian "<?= $keyword ?>". 
                        Coba kata kunci lain atau periksa ejaan Anda.
                    </p>
                    <div class="suggestions">
                        <h6 class="mb-3">Saran pencarian:</h6>
                        <div class="suggestion-tags">
                            <span class="suggestion-tag">Biddokkes</span>
                            <span class="suggestion-tag">POLRI</span>
                            <span class="suggestion-tag">Kesehatan</span>
                            <span class="suggestion-tag">Layanan</span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Berita Results -->
            <div class="tab-pane fade" id="berita" role="tabpanel">
                <?php if (!empty($berita_results)): ?>
                <div class="row">
                    <?php foreach ($berita_results as $berita): ?>
                    <div class="col-lg-6 mb-4" data-aos="fade-up">
                        <div class="search-result-card">
                            <div class="result-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="result-content">
                                <h5 class="result-title">
                                    <a href="<?= base_url('frontberita/' . $berita['slug']) ?>"><?= $berita['judul'] ?></a>
                                </h5>
                                <p class="result-excerpt"><?= substr(strip_tags($berita['konten']), 0, 150) ?>...</p>
                                <div class="result-meta">
                                    <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($berita['created_at'])) ?></span>
                                    <span><i class="fas fa-user me-1"></i><?= $berita['penulis'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="no-results text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada berita yang ditemukan</p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Halaman Results -->
            <div class="tab-pane fade" id="halaman" role="tabpanel">
                <?php if (!empty($halaman_results)): ?>
                <div class="row">
                    <?php foreach ($halaman_results as $halaman): ?>
                    <div class="col-lg-6 mb-4" data-aos="fade-up">
                        <div class="search-result-card">
                            <div class="result-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="result-content">
                                <h5 class="result-title">
                                    <a href="<?= base_url('fronthalaman/' . $halaman['slug']) ?>"><?= $halaman['judul'] ?></a>
                                </h5>
                                <p class="result-excerpt"><?= substr(strip_tags($halaman['konten']), 0, 150) ?>...</p>
                                <div class="result-meta">
                                    <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($halaman['tanggal_publish'])) ?></span>
                                    <span><i class="fas fa-user me-1"></i><?= $halaman['penulis'] ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="no-results text-center py-5">
                    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada halaman yang ditemukan</p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Download Results -->
            <div class="tab-pane fade" id="download" role="tabpanel">
                <?php if (!empty($download_results)): ?>
                <div class="row">
                    <?php foreach ($download_results as $download): ?>
                    <div class="col-lg-6 mb-4" data-aos="fade-up">
                        <div class="search-result-card">
                            <div class="result-icon">
                                <i class="fas fa-download"></i>
                            </div>
                            <div class="result-content">
                                <h5 class="result-title">
                                    <a href="<?= base_url('frontdownload/file/' . $download['id_download']) ?>"><?= $download['judul'] ?></a>
                                </h5>
                                <p class="result-excerpt"><?= $download['deskripsi'] ?></p>
                                <div class="result-meta">
                                    <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($download['created_at'])) ?></span>
                                    <span><i class="fas fa-download me-1"></i><?= $download['download_count'] ?? 0 ?> downloads</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="no-results text-center py-5">
                    <i class="fas fa-download fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada file download yang ditemukan</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Popular Searches -->
<section class="popular-searches-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-5" data-aos="fade-up">
                    <h3 class="section-title">Pencarian Populer</h3>
                    <div class="title-line mx-auto"></div>
                    <p class="text-muted mt-3">Kata kunci yang sering dicari pengunjung</p>
                </div>
                
                <div class="popular-searches" data-aos="fade-up">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="search-tags">
                                <a href="<?= base_url('search?q=biddokkes') ?>" class="search-tag">Biddokkes</a>
                                <a href="<?= base_url('search?q=polri') ?>" class="search-tag">POLRI</a>
                                <a href="<?= base_url('search?q=kesehatan') ?>" class="search-tag">Kesehatan</a>
                                <a href="<?= base_url('search?q=layanan') ?>" class="search-tag">Layanan</a>
                                <a href="<?= base_url('search?q=dokter') ?>" class="search-tag">Dokter</a>
                                <a href="<?= base_url('search?q=rumah+sakit') ?>" class="search-tag">Rumah Sakit</a>
                                <a href="<?= base_url('search?q=berita') ?>" class="search-tag">Berita</a>
                                <a href="<?= base_url('search?q=galeri') ?>" class="search-tag">Galeri</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Search form enhancement
    document.querySelector('.search-form').addEventListener('submit', function(e) {
        const searchInput = this.querySelector('input[name="q"]');
        if (searchInput.value.trim() === '') {
            e.preventDefault();
            alert('Mohon masukkan kata kunci pencarian');
        }
    });
    
    // Highlight search terms
    document.addEventListener('DOMContentLoaded', function() {
        const keyword = '<?= $keyword ?>';
        const resultTitles = document.querySelectorAll('.result-title a');
        const resultExcerpts = document.querySelectorAll('.result-excerpt');
        
        function highlightText(text, keyword) {
            if (!keyword) return text;
            const regex = new RegExp(`(${keyword})`, 'gi');
            return text.replace(regex, '<mark>$1</mark>');
        }
        
        resultTitles.forEach(title => {
            title.innerHTML = highlightText(title.textContent, keyword);
        });
        
        resultExcerpts.forEach(excerpt => {
            excerpt.innerHTML = highlightText(excerpt.textContent, keyword);
        });
    });
    
    // Tab functionality
    document.querySelectorAll('#searchTabs button').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all tabs
            document.querySelectorAll('#searchTabs .nav-link').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Add active class to clicked tab
            this.classList.add('active');
        });
    });
    
    // Search result click tracking
    document.querySelectorAll('.search-result-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                const link = this.querySelector('a');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });
    
    // Popular search tags
    document.querySelectorAll('.search-tag').forEach(tag => {
        tag.addEventListener('click', function() {
            console.log('Popular search clicked:', this.textContent);
        });
    });
</script>

<?= $this->include('frontend/layout/footer') ?> 