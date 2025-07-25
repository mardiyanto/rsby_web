<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title">Download</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Download</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Download Section -->
<section class="download-section py-5">
    <div class="container">
        <!-- Search and Filter -->
        <div class="download-controls mb-5" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3">
                    <form action="<?= base_url('frontdownload') ?>" method="GET" class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari file download..." value="<?= htmlspecialchars($search ?? '') ?>">
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
                            <?php if (!empty($kategoris)): ?>
                                <?php 
                                // Debug: Tampilkan jumlah kategori
                                echo "<!-- Debug: Jumlah kategori: " . count($kategoris) . " -->";
                                ?>
                                <?php foreach ($kategoris as $kat): ?>
                                <?php 
                                // Debug: Tampilkan data kategori
                                echo "<!-- Debug: Kategori ID: " . ($kat['id_kategori_download'] ?? 'null') . ", Nama: " . ($kat['nama_kategori_download'] ?? $kat['nama_kategori'] ?? 'null') . " -->";
                                ?>
                                <option value="<?= htmlspecialchars($kat['id_kategori_download'] ?? '') ?>" <?= ($kategori ?? '') == ($kat['id_kategori_download'] ?? '') ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($kat['nama_kategori_download'] ?? $kat['nama_kategori'] ?? 'Kategori') ?>
                                </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>Tidak ada kategori tersedia</option>
                                <?php 
                                // Debug: Tampilkan jika tidak ada kategori
                                echo "<!-- Debug: Tidak ada kategori tersedia -->";
                                ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Download Grid -->
        <?php if (!empty($downloads)): ?>
        <div class="row" id="downloadGrid">
            <?php foreach ($downloads as $index => $item): ?>
            <div class="col-lg-6 col-md-6 mb-4 download-item-wrapper" data-aos="fade-up" data-aos-delay="<?= ($index % 2 + 1) * 100 ?>">
                <div class="download-card">
                    <div class="download-icon">
                        <?php
                        $fileName = $item['nama_file'] ?? $item['file'] ?? '';
                        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                        $iconClass = 'fas fa-file';
                        switch(strtolower($extension)) {
                            case 'pdf':
                                $iconClass = 'fas fa-file-pdf';
                                break;
                            case 'doc':
                            case 'docx':
                                $iconClass = 'fas fa-file-word';
                                break;
                            case 'xls':
                            case 'xlsx':
                                $iconClass = 'fas fa-file-excel';
                                break;
                            case 'ppt':
                            case 'pptx':
                                $iconClass = 'fas fa-file-powerpoint';
                                break;
                            case 'zip':
                            case 'rar':
                                $iconClass = 'fas fa-file-archive';
                                break;
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                            case 'gif':
                                $iconClass = 'fas fa-file-image';
                                break;
                        }
                        ?>
                        <i class="<?= $iconClass ?>"></i>
                    </div>
                    <div class="download-content">
                        <div class="download-category">
                            <span class="category-badge"><?= htmlspecialchars($item['nama_kategori'] ?? 'Umum') ?></span>
                        </div>
                        <h5 class="download-title"><?= htmlspecialchars($item['judul'] ?? 'File Download') ?></h5>
                        <p class="download-description"><?= htmlspecialchars($item['deskripsi'] ?? '') ?></p>
                        
                        <div class="download-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar me-1"></i>
                                <span><?= date('d M Y', strtotime($item['created_at'] ?? $item['tanggal_upload'] ?? 'now')) ?></span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-download me-1"></i>
                                <span><?= number_format($item['download_count'] ?? $item['hits'] ?? 0) ?> downloads</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-file me-1"></i>
                                <span><?= strtoupper($extension ?: 'FILE') ?></span>
                            </div>
                            <?php if (!empty($item['ukuran_file'])): ?>
                            <div class="meta-item">
                                <i class="fas fa-weight-hanging me-1"></i>
                                <span><?= formatFileSize($item['ukuran_file']) ?></span>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="download-actions">
                            <?php if (!empty($fileName) && !empty($item['id_download'])): ?>
                            <?php if (strtolower($extension) === 'pdf'): ?>
                                <a href="<?= base_url('frontdownload/preview/' . intval($item['id_download'])) ?>" 
                                   class="btn btn-warning btn-sm me-1" target="_blank">
                                    <i class="fas fa-eye me-1"></i>Preview
                                </a>
                                <a href="<?= base_url('frontdownload/force/' . intval($item['id_download'])) ?>" 
                                   class="btn btn-primary btn-sm download-btn"
                                   onclick="trackDownload(<?= intval($item['id_download']) ?>, '<?= htmlspecialchars($item['judul'] ?? 'File') ?>')">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('frontdownload/file/' . intval($item['id_download'])) ?>" 
                                   class="btn btn-primary btn-sm download-btn"
                                   onclick="trackDownload(<?= intval($item['id_download']) ?>, '<?= htmlspecialchars($item['judul'] ?? 'File') ?>')">
                                    <i class="fas fa-download me-1"></i>Download
                                </a>
                            <?php endif; ?>
                            <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>
                                <i class="fas fa-exclamation-triangle me-1"></i>File Tidak Tersedia
                            </button>
                            <?php endif; ?>
                            <button class="btn btn-outline-secondary btn-sm" 
                                    onclick="showFileInfo('<?= htmlspecialchars($item['judul'] ?? 'File') ?>', '<?= htmlspecialchars($item['deskripsi'] ?? '') ?>', '<?= $extension ?: 'FILE' ?>', '<?= number_format($item['download_count'] ?? $item['hits'] ?? 0) ?>', '<?= !empty($item['ukuran_file']) ? formatFileSize($item['ukuran_file']) : 'Tidak tersedia' ?>')">
                                <i class="fas fa-info-circle me-1"></i>Info
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
        <div class="pagination-wrapper mt-5" data-aos="fade-up">
            <nav aria-label="Download pagination">
                <?= $pager->links() ?>
            </nav>
        </div>
        <?php endif; ?>
        
        <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-5" data-aos="fade-up">
            <div class="empty-download">
                <i class="fas fa-download fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-3">
                    <?= (!empty($search) || !empty($kategori)) ? 'Tidak ada file yang ditemukan' : 'Belum ada file tersedia' ?>
                </h4>
                <p class="text-muted mb-4">
                    <?= (!empty($search) || !empty($kategori)) ? 'Coba ubah kata kunci pencarian atau filter kategori Anda' : 'File download akan ditampilkan di sini' ?>
                </p>
                <?php if (!empty($search) || !empty($kategori)): ?>
                <a href="<?= base_url('frontdownload') ?>" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Semua Download
                </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Download Stats -->
<?php if (!empty($downloads)): ?>
<section class="stats-section py-5 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-item">
                    <i class="fas fa-download fa-2x text-primary mb-3"></i>
                    <h3 class="stat-number"><?= count($downloads) ?></h3>
                    <p class="stat-label">Total File</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-item">
                    <i class="fas fa-users fa-2x text-primary mb-3"></i>
                    <h3 class="stat-number"><?= number_format(array_sum(array_column($downloads, 'download_count'))) ?></h3>
                    <p class="stat-label">Total Download</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-item">
                    <i class="fas fa-folder fa-2x text-primary mb-3"></i>
                    <h3 class="stat-number"><?= count($kategoris) ?></h3>
                    <p class="stat-label">Kategori</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- File Info Modal -->
<div class="modal fade" id="fileInfoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="fileInfoContent">
                    <!-- Content will be populated by JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php
// Helper function untuk format ukuran file
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
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
    
    // Track download
    function trackDownload(id, title) {
        console.log('Download started:', title, 'ID:', id);
        // Here you can add analytics tracking
        // For now, we'll just show a loading state
        const btn = event.target.closest('.download-btn');
        if (!btn) return;
        
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Downloading...';
        btn.disabled = true;
        
        // Simulate download delay
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-check me-1"></i>Downloaded';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('btn-success');
                btn.classList.add('btn-primary');
            }, 2000);
        }, 1500);
    }
    
    // Show file info modal
    function showFileInfo(title, description, extension, downloads, fileSize) {
        const modal = new bootstrap.Modal(document.getElementById('fileInfoModal'));
        const content = document.getElementById('fileInfoContent');
        
        content.innerHTML = `
            <div class="file-info">
                <h6 class="mb-3">${title}</h6>
                <p class="text-muted mb-3">${description || 'Tidak ada deskripsi'}</p>
                <div class="file-details">
                    <div class="detail-item mb-2">
                        <strong>Format:</strong> ${extension.toUpperCase()}
                    </div>
                    <div class="detail-item mb-2">
                        <strong>Total Download:</strong> ${downloads}
                    </div>
                    <div class="detail-item">
                        <strong>Ukuran:</strong> <span class="text-muted">${fileSize}</span>
                    </div>
                </div>
            </div>
        `;
        
        modal.show();
    }
    
    // Download card click tracking
    document.querySelectorAll('.download-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a, button')) {
                const downloadBtn = this.querySelector('.download-btn');
                if (downloadBtn && !downloadBtn.disabled) {
                    downloadBtn.click();
                }
            }
        });
    });
    
    // File type icons and hover effects
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects for download cards
        document.querySelectorAll('.download-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'transform 0.3s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Add loading state for search form
        const searchForm = document.querySelector('.search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitBtn.disabled = true;
                }
            });
        }
    });
</script>

<?= $this->include('frontend/layout/footer') ?> 