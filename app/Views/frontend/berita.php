<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title">Berita & Informasi</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Berita</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Page Content Section -->
<section class="page-content-section py-5">
    <div class="container">
        <!-- Search and Filter -->
        <div class="news-controls mb-5" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3">
                    <form action="<?= base_url('frontberita') ?>" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="<?= $search ?? '' ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="d-flex justify-content-lg-end">
                        <select class="form-select w-auto" id="kategoriSelect" onchange="changeKategori(this.value)">
                            <option value="">Semua Kategori</option>
                            <?php foreach ($kategoris as $kat): ?>
                            <option value="<?= $kat['id_kategori'] ?>" <?= ($kategori ?? '') == $kat['id_kategori'] ? 'selected' : '' ?>>
                                <?= $kat['nama_kategori'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- News Grid -->
        <?php if (!empty($berita)): ?>
        <div class="row" id="newsGrid">
            <?php foreach ($berita as $index => $item): ?>
            <div class="col-lg-4 col-md-6 mb-4 news-item-wrapper" data-aos="fade-up" data-aos-delay="<?= ($index % 3 + 1) * 100 ?>">
                <div class="news-card">
                    <div class="news-image">
                        <?php if ($item['gambar']): ?>
                        <img src="<?= base_url('uploads/artikel/' . $item['gambar']) ?>" 
                             alt="<?= $item['judul'] ?>" 
                             class="img-fluid"
                             loading="lazy">
                        <?php else: ?>
                        <img src="<?= base_url('assets/images/default-news.jpg') ?>" 
                             alt="<?= $item['judul'] ?>" 
                             class="img-fluid"
                             loading="lazy">
                        <?php endif; ?>
                        <div class="news-category">
                            <span class="category-badge"><?= $item['nama_kategori'] ?></span>
                        </div>
                        <div class="news-date">
                            <span class="day"><?= date('d', strtotime($item['created_at'])) ?></span>
                            <span class="month"><?= date('M', strtotime($item['created_at'])) ?></span>
                        </div>
                    </div>
                    <div class="news-content">
                        <div class="news-meta">
                            <span><i class="fas fa-user me-1"></i><?= $item['penulis'] ?? 'Admin' ?></span>
                            <span><i class="fas fa-eye me-1"></i><?= $item['view_count'] ?? 0 ?> views</span>
                        </div>
                        <h5 class="news-title">
                            <a href="<?= base_url('frontberita/' . ($item['slug'] ?? '#')) ?>"><?= $item['judul'] ?? 'Judul Berita' ?></a>
                        </h5>
                        <p class="news-excerpt"><?= substr(strip_tags($item['isi'] ?? $item['konten'] ?? ''), 0, 120) ?>...</p>
                        <div class="news-footer">
                            <a href="<?= base_url('frontberita/' . ($item['slug'] ?? '#')) ?>" class="read-more">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <span class="news-time">
                                <i class="fas fa-clock me-1"></i><?= timeAgo($item['created_at'] ?? 'now') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="pagination-wrapper mt-5" data-aos="fade-up">
            <nav aria-label="Berita pagination">
                <?= $pager->links() ?>
            </nav>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-5" data-aos="fade-up">
            <div class="empty-news">
                <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-3">
                    <?= ($search || $kategori) ? 'Tidak ada berita yang ditemukan' : 'Belum ada berita tersedia' ?>
                </h4>
                <p class="text-muted mb-4">
                    <?= ($search || $kategori) ? 'Coba ubah kata kunci pencarian atau filter kategori Anda' : 'Berita akan ditampilkan di sini' ?>
                </p>
                <?php if ($search || $kategori): ?>
                <a href="<?= base_url('frontberita') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Semua Berita
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Featured Categories -->
<?php if (!empty($kategoris)): ?>
<section class="categories-section py-5 bg-light">
    <div class="container">
        <div class="section-header text-center mb-5" data-aos="fade-up">
            <h3 class="section-title">Kategori Berita</h3>
            <div class="title-line mx-auto"></div>
            <p class="text-muted mt-3">Pilih kategori berita yang ingin Anda baca</p>
        </div>
        
        <div class="row">
            <?php foreach ($kategoris as $index => $kat): ?>
            <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?= ($index + 1) * 100 ?>">
                <div class="related-page-card">
                    <div class="category-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h5 class="category-name"><?= $kat['nama_kategori'] ?></h5>
                    <p class="category-description">Berita seputar <?= strtolower($kat['nama_kategori']) ?></p>
                    <a href="<?= base_url('berita?kategori=' . $kat['id_kategori']) ?>" class="category-link">
                        Lihat Berita <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Newsletter Section -->
<section class="newsletter-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center" data-aos="fade-up">
                <div class="newsletter-content">
                    <h3 class="section-title text-white mb-3">Berlangganan Newsletter</h3>
                    <p class="text-light mb-4">Dapatkan berita terbaru dan informasi penting dari Biddokkes POLRI langsung ke email Anda.</p>
                    
                    <form class="newsletter-form" id="newsletterForm">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Masukkan email Anda..." required>
                                    <button class="btn btn-light" type="submit">
                                        <i class="fas fa-paper-plane me-2"></i>Berlangganan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Helper function for time ago
function timeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) {
        return 'Baru saja';
    } elseif ($time < 3600) {
        return floor($time / 60) . ' menit yang lalu';
    } elseif ($time < 86400) {
        return floor($time / 3600) . ' jam yang lalu';
    } elseif ($time < 2592000) {
        return floor($time / 86400) . ' hari yang lalu';
    } elseif ($time < 31536000) {
        return floor($time / 2592000) . ' bulan yang lalu';
    } else {
        return floor($time / 31536000) . ' tahun yang lalu';
    }
}
?>

<script>
    // Category filter functionality
    function changeKategori(value) {
        const currentUrl = new URL(window.location);
        if (value) {
            currentUrl.searchParams.set('kategori', value);
        } else {
            currentUrl.searchParams.delete('kategori');
        }
        currentUrl.searchParams.delete('page'); // Reset to first page
        window.location.href = currentUrl.toString();
    }
    
    // Search form enhancement
    document.querySelector('.search-form').addEventListener('submit', function(e) {
        const searchInput = this.querySelector('input[name="search"]');
        if (searchInput.value.trim() === '') {
            e.preventDefault();
            alert('Mohon masukkan kata kunci pencarian');
        }
    });
    
    // Newsletter form
    document.getElementById('newsletterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        
        // Simple email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Mohon masukkan email yang valid');
            return;
        }
        
        // Simulate subscription
        alert('Terima kasih! Anda telah berlangganan newsletter kami.');
        this.reset();
    });
    
    // News card click tracking
    document.querySelectorAll('.news-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                const link = this.querySelector('.news-title a');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
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
</script>

<?= $this->include('frontend/layout/footer') ?> 