<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title"><?= esc($berita['judul'] ?? 'Detail Berita') ?></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('frontberita') ?>">Berita</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?= esc($berita['judul'] ?? 'Berita') ?></li>
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
            <!-- Sidebar - Berita Terkait -->
            <div class="col-lg-4 mb-4">
                <!-- Related News -->
                <?php if (!empty($berita_terkait)): ?>
                <div class="sidebar-widget mb-4" data-aos="fade-right">
                    <h4 class="widget-title">Berita Terkait</h4>
                    <div class="related-news">
                        <?php foreach ($berita_terkait as $related): ?>
                        <div class="related-news-item">
                            <div class="related-news-image">
                                <?php if ($related['gambar']): ?>
                                <img src="<?= base_url('uploads/artikel/' . $related['gambar']) ?>" 
                                     alt="<?= $related['judul'] ?? 'Gambar Berita Terkait' ?>" 
                                     class="img-fluid">
                                <?php else: ?>
                                <img src="<?= base_url('assets/images/default-news.jpg') ?>" 
                                     alt="<?= $related['judul'] ?? 'Gambar Berita Terkait' ?>" 
                                     class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <div class="related-news-content">
                                <h6 class="related-news-title">
                                    <a href="<?= base_url('frontberita/detail/' . $related['id_berita']) ?>"><?= $related['judul'] ?? 'Judul Berita Terkait' ?></a>
                                </h6>
                                <div class="related-news-meta">
                                    <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($related['created_at'] ?? '')) ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
           
                <?php 
                        $beritaModel = new \App\Models\BeritaModel();
                        $latest_news = $beritaModel->getLatest(5);
                        foreach ($latest_news as $latest): 
                        ?>
                    <div  class="sidebar-widget mb-4" data-aos="fade-right" data-aos-delay="100" >
                    <h4 class="widget-title">Berita Terkait</h4>
                        <div class="related-page-card">
                        <?php if ($latest['gambar']): ?>
                            <div class="related-page-image">
                            <?php if ($latest['gambar']): ?>
                                <img src="<?= base_url('uploads/artikel/' . $latest['gambar']) ?>" 
                                     alt="<?= $latest['judul'] ?? 'Gambar Berita Terbaru' ?>" 
                                     class="img-fluid">
                                <?php else: ?>
                                <img src="<?= base_url('assets/images/default-news.jpg') ?>" 
                                     alt="<?= $latest['judul'] ?? 'Gambar Berita Terbaru' ?>" 
                                     class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <div class="related-page-content">
                                <h5 class="related-page-title">
                                    <a href="<?= base_url('frontberita/detail/' . $latest['id_berita']) ?>"><?= $latest['judul'] ?? 'Judul Berita Terbaru' ?></a>
                                </h5>
                                <p class="related-page-excerpt">
                                    <?= substr(strip_tags($latest['isi']), 0, 100) ?>...
                                </p>
                                <div class="related-page-meta">
                                    <span><i class="fas fa-calendar me-1"></i><?= date('d M Y', strtotime($latest['created_at'] ?? '')) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                 <?php endforeach; ?>
       
                
                <!-- Categories -->
                <div class="sidebar-widget" data-aos="fade-right" data-aos-delay="200">
                
                    <h4 class="widget-title">Kategori</h4>
                    <div class="related-page-card">
                    <div class="related-page-content">
                        <?php 
                        $kategoriModel = new \App\Models\KategoriModel();
                        $kategoris = $kategoriModel->findAll();
                        foreach ($kategoris as $kat): 
                        ?>
                        <a href="<?= base_url('berita?kategori=' . $kat['id_kategori']) ?>" class="category-item">
                            <span class="category-name"><?= $kat['nama_kategori'] ?? 'Nama Kategori' ?></span>
                            <span class="category-count">(<?= $kategoriModel->getBeritaCountByKategori($kat['id_kategori']) ?? 0 ?>)</span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="page-content" data-aos="fade-left">
                    <!-- Page Header -->
                    <div class="page-header-content mb-4">
                        <div class="page-meta">
                            <div class="meta-item">
                                <i class="fas fa-folder me-2"></i>
                                <span>Kategori: <?= esc($berita['nama_kategori'] ?? 'Kategori') ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-user me-2"></i>
                                <span>Penulis: <?= esc($berita['penulis'] ?? 'Admin') ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar me-2"></i>
                                <span>Diterbitkan: <?= date('d F Y', strtotime($berita['created_at'] ?? '')) ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-eye me-2"></i>
                                <span><?= $berita['view_count'] ?? 0 ?> views</span>
                            </div>
                        </div>
                        
                        <?php if ($berita['gambar']): ?>
                        <div class="page-image-wrapper mb-4">
                            <img src="<?= base_url('uploads/artikel/' . $berita['gambar']) ?>" 
                                 alt="<?= esc($berita['judul'] ?? 'Gambar Berita') ?>" 
                                 class="img-fluid rounded">
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Page Content -->
                    <div class="content-body">
                        <?= $berita['konten'] ?? $berita['isi'] ?? 'Tidak ada konten berita.' ?>
                    </div>
                    
                    <!-- Page Footer -->
                    <div class="page-footer mt-5">
                        <div class="page-share">
                            <h6 class="mb-3">Bagikan berita ini:</h6>
                            <div class="share-buttons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" 
                                   target="_blank" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($berita['judul'] ?? 'Berita') ?>" 
                                   target="_blank" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text=<?= urlencode(($berita['judul'] ?? 'Berita') . ' - ' . current_url()) ?>" 
                                   target="_blank" class="share-btn whatsapp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="mailto:?subject=<?= urlencode($berita['judul'] ?? 'Berita') ?>&body=<?= urlencode('Baca berita ini: ' . current_url()) ?>" 
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

<!-- Newsletter Section -->
<section class="cta-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-center">
                <div class="newsletter-content">
                    <h3 class="cta-title">Berlangganan Newsletter</h3>
                    <p class="cta-description">Dapatkan berita terbaru dan informasi penting dari Biddokkes POLRI langsung ke email Anda.</p>
                    
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

<script>
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
    
    // Share button functionality
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Analytics tracking could be added here
            console.log('Share button clicked:', this.className);
        });
    });
    
    // Update view count (simulated)
    document.addEventListener('DOMContentLoaded', function() {
        // In a real application, you would send an AJAX request to update view count
        console.log('News article viewed:', '<?= $berita['judul'] ?? 'Berita' ?>');
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