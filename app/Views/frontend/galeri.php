<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title">Galeri Kegiatan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Galeri</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="gallery-section py-5">
    <div class="container">
        <!-- Search and Filter -->
        <div class="gallery-controls mb-5" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3">
                    <form action="<?= base_url('frontgaleri') ?>" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari galeri..." value="<?= $search ?? '' ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="d-flex justify-content-lg-end">
                        <select class="form-select w-auto" id="sortSelect" onchange="changeSort(this.value)">
                            <option value="latest" <?= ($sort ?? 'latest') == 'latest' ? 'selected' : '' ?>>Terbaru</option>
                            <option value="oldest" <?= ($sort ?? 'latest') == 'oldest' ? 'selected' : '' ?>>Terlama</option>
                            <option value="az" <?= ($sort ?? 'latest') == 'az' ? 'selected' : '' ?>>A-Z</option>
                            <option value="za" <?= ($sort ?? 'latest') == 'za' ? 'selected' : '' ?>>Z-A</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gallery Grid -->
        <?php if (!empty($galeri)): ?>
        <div class="row" id="galleryGrid">
            <?php foreach ($galeri as $index => $item): ?>
            <div class="col-lg-4 col-md-6 mb-4 gallery-item-wrapper" data-aos="fade-up" data-aos-delay="<?= ($index % 3 + 1) * 100 ?>">
                <div class="gallery-item">
                    <a href="<?= base_url('uploads/galeri/' . ($item['nama_file'] ?? $item['gambar'] ?? 'default.jpg')) ?>" 
                       data-lightbox="gallery" 
                       data-title="<?= $item['judul'] ?? 'Galeri' ?>"
                       data-alt="<?= $item['deskripsi'] ?? '' ?>">
                        <div class="gallery-image">
                            <img src="<?= base_url('uploads/galeri/' . ($item['nama_file'] ?? $item['gambar'] ?? 'default.jpg')) ?>" 
                                 alt="<?= $item['judul'] ?? 'Galeri' ?>" 
                                 class="img-fluid"
                                 loading="lazy">
                            <div class="gallery-overlay">
                                <div class="gallery-content">
                                    <i class="fas fa-search-plus"></i>
                                    <h5><?= $item['judul'] ?? 'Galeri' ?></h5>
                                    <p><?= $item['deskripsi'] ?? '' ?></p>
                                    <div class="gallery-meta">
                                        <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($item['created_at'] ?? 'now')) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <div class="gallery-info">
                        <h5 class="gallery-title"><?= $item['judul'] ?? 'Galeri' ?></h5>
                        <p class="gallery-description"><?= $item['deskripsi'] ?? '' ?></p>
                        <div class="gallery-meta-info">
                            <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($item['created_at'] ?? 'now')) ?></span>
                            <span><i class="fas fa-user me-1"></i><?= $item['penulis'] ?? 'Admin' ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-5" data-aos="fade-up">
            <button class="btn btn-outline-primary btn-lg" id="loadMoreBtn">
                <i class="fas fa-plus me-2"></i>Muat Lebih Banyak
            </button>
        </div>
        
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-5" data-aos="fade-up">
            <div class="empty-gallery">
                <i class="fas fa-images fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-3">
                    <?= $search ? 'Tidak ada galeri yang ditemukan' : 'Belum ada galeri tersedia' ?>
                </h4>
                <p class="text-muted mb-4">
                    <?= $search ? 'Coba ubah kata kunci pencarian Anda' : 'Galeri akan ditampilkan di sini' ?>
                </p>
                <?php if ($search): ?>
                <a href="<?= base_url('galeri') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Semua Galeri
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Gallery Stats -->
<?php if (!empty($galeri)): ?>
<section class="stats-section py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <i class="fas fa-images fa-2x text-primary mb-3"></i>
                    <h3 class="stat-number"><?= count($galeri) ?></h3>
                    <p class="stat-label">Total Foto</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <i class="fas fa-calendar-alt fa-2x text-primary mb-3"></i>
                    <h3 class="stat-number"><?= date('Y') ?></h3>
                    <p class="stat-label">Tahun Aktif</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <i class="fas fa-eye fa-2x text-primary mb-3"></i>
                    <h3 class="stat-number">1000+</h3>
                    <p class="stat-label">Pengunjung</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
    // Sort functionality
    function changeSort(value) {
        const currentUrl = new URL(window.location);
        currentUrl.searchParams.set('sort', value);
        window.location.href = currentUrl.toString();
    }
    
    // Load more functionality (simulated)
    document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';
        this.disabled = true;
        
        // Simulate loading
        setTimeout(() => {
            this.innerHTML = '<i class="fas fa-check me-2"></i>Semua Galeri Dimuat';
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-success');
        }, 2000);
    });
    
    // Lightbox configuration
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Gambar %1 dari %2',
        'fadeDuration': 300,
        'imageFadeDuration': 300
    });
    
    // Lazy loading for images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            images.forEach(img => imageObserver.observe(img));
        }
    });
    
    // Search form enhancement
    document.querySelector('.search-form').addEventListener('submit', function(e) {
        const searchInput = this.querySelector('input[name="search"]');
        if (searchInput.value.trim() === '') {
            e.preventDefault();
            alert('Mohon masukkan kata kunci pencarian');
        }
    });
    
    // Gallery item click tracking
    document.querySelectorAll('.gallery-item a').forEach(link => {
        link.addEventListener('click', function() {
            const title = this.getAttribute('data-title');
            console.log('Gallery item clicked:', title);
            // Here you can add analytics tracking
        });
    });
</script>

<?= $this->include('frontend/layout/footer') ?> 