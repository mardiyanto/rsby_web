<?= $this->include('frontend/layout/header') ?>

<?php if (!empty($halaman)): ?>
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title"><?= esc($halaman['judul']) ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= esc($halaman['judul']) ?></li>
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
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8 mx-auto">
                <article class="page-content" data-aos="fade-up">
                    <!-- Page Header -->
                    <div class="page-header-content mb-4">
                        <?php if (!empty($halaman['gambar'])): ?>
                        <div class="page-image-wrapper mb-4">
                            <img src="<?= base_url('uploads/halaman/' . $halaman['gambar']) ?>" 
                                 alt="<?= esc($halaman['judul']) ?>" 
                                 class="img-fluid rounded">
                        </div>
                        <?php endif; ?>
                        
                        <div class="page-meta">
                            <div class="meta-item">
                                <i class="fas fa-user me-2"></i>
                                <span>Penulis: <?= esc($halaman['penulis'] ?? 'Admin') ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar me-2"></i>
                                <span>Diterbitkan: <?= date('d F Y', strtotime($halaman['tanggal_publish'] ?? $halaman['created_at'] ?? 'now')) ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock me-2"></i>
                                <span>Terakhir diperbarui: <?= date('d F Y', strtotime($halaman['updated_at'] ?? 'now')) ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Page Content -->
                    <div class="content-body">
                        <?= $halaman['konten'] ?? '' ?>
                    </div>
                    
                    <!-- Page Footer -->
                    <div class="page-footer mt-5">
                        <div class="page-share">
                            <h6 class="mb-3">Bagikan halaman ini:</h6>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                                   target="_blank" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($halaman['judul'] ?? 'Halaman') ?>" 
                                   target="_blank" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text=<?= urlencode(($halaman['judul'] ?? 'Halaman') . ' - ' . current_url()) ?>" 
                                   target="_blank" class="share-btn whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="mailto:?subject=<?= urlencode($halaman['judul'] ?? 'Halaman') ?>&body=<?= urlencode('Baca halaman ini: ' . current_url()) ?>" 
                                   class="share-btn email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>

<!-- Related Pages -->
<section class="related-pages-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-5" data-aos="fade-up">
                    <h3 class="section-title">Halaman Terkait</h3>
                    <div class="title-line mx-auto"></div>
                    <p class="text-muted mt-3">Halaman lain yang mungkin menarik untuk Anda</p>
                </div>
                
                <div class="row">
                    <?php 
                    $halamanModel = new \App\Models\HalamanModel();
                    $related_pages = $halamanModel->getPublishedHalaman();
                    $count = 0;
                    foreach ($related_pages as $related): 
                        if ($related['id_halaman'] != $halaman['id_halaman'] && $count < 3):
                    ?>
                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?= ($count + 1) * 100 ?>">
                        <div class="related-page-card">
                            <?php if (!empty($related['gambar'])): ?>
                            <div class="related-page-image">
                                <img src="<?= base_url('uploads/halaman/' . $related['gambar']) ?>" 
                                     alt="<?= esc($related['judul']) ?>" 
                                     class="img-fluid">
                            </div>
                            <?php endif; ?>
                            <div class="related-page-content">
                                <h5 class="related-page-title">
                                    <a href="<?= base_url('fronthalaman/' . $related['slug']) ?>"><?= esc($related['judul']) ?></a>
                                </h5>
                                <p class="related-page-excerpt">
                                    <?= substr(strip_tags($related['konten']), 0, 100) ?>...
                                </p>
                                <div class="related-page-meta">
                                    <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($related['tanggal_publish'])) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php 
                        $count++;
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="cta-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h2 class="cta-title">Butuh Informasi Lebih Lanjut?</h2>
                <p class="cta-description">Tim kami siap membantu Anda dengan informasi yang Anda butuhkan. Hubungi kami sekarang!</p>
            </div>
            <div class="col-lg-4 text-end" data-aos="fade-left">
                <a href="<?= base_url('frontcontact') ?>" class="btn btn-light btn-lg">
                    <i class="fas fa-phone me-2"></i>Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<?php else: ?>
<!-- Error Section -->
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
                        Maaf, halaman yang Anda cari tidak ditemukan atau belum tersedia.
                    </p>
                    
                    <div class="error-actions mb-5">
                        <a href="<?= base_url() ?>" class="btn btn-primary me-3">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="<?= base_url('frontcontact') ?>" class="btn btn-outline-primary">
                            <i class="fas fa-phone me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
    // Share button functionality
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Analytics tracking could be added here
            console.log('Share button clicked:', this.className);
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add table of contents functionality
    document.addEventListener('DOMContentLoaded', function() {
        const headings = document.querySelectorAll('.content-body h1, .content-body h2, .content-body h3');
        
        if (headings.length > 3) {
            // Create table of contents
            const toc = document.createElement('div');
            toc.className = 'table-of-contents mb-4';
            toc.innerHTML = '<h4>Daftar Isi</h4><ul></ul>';
            
            const tocList = toc.querySelector('ul');
            
            headings.forEach((heading, index) => {
                const id = 'heading-' + index;
                heading.id = id;
                
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = '#' + id;
                a.textContent = heading.textContent;
                a.className = 'toc-link';
                
                li.appendChild(a);
                tocList.appendChild(li);
            });
            
            // Insert TOC after first paragraph
            const firstP = document.querySelector('.content-body p');
            if (firstP) {
                firstP.parentNode.insertBefore(toc, firstP.nextSibling);
            }
        }
    });
    
    // Add reading progress indicator
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset;
        const docHeight = document.body.offsetHeight - window.innerHeight;
        const scrollPercent = (scrollTop / docHeight) * 100;
        
        // Create progress bar if it doesn't exist
        let progressBar = document.getElementById('reading-progress');
        if (!progressBar) {
            progressBar = document.createElement('div');
            progressBar.id = 'reading-progress';
            progressBar.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 0%;
                height: 3px;
                background: linear-gradient(135deg, var(--primary-navy), var(--accent-blue));
                z-index: 9999;
                transition: width 0.3s ease;
            `;
            document.body.appendChild(progressBar);
        }
        
        progressBar.style.width = scrollPercent + '%';
    });
</script>

<?= $this->include('frontend/layout/footer') ?> 