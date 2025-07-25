<?= $this->include('frontend/layout/header') ?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header-content text-center">
                    <h1 class="page-title">Hubungi Kami</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kontak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-5" data-aos="fade-right">
                <div class="contact-info">
                    <h3 class="section-title mb-4">Informasi Kontak</h3>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Alamat</h5>
                            <p><?= $profilWebsite['alamat'] ?? 'Jl. Trunojoyo No.3, Jakarta Pusat<br>DKI Jakarta 10310' ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Telepon</h5>
                            <p><?= $profilWebsite['telepon'] ?? '(021) 721-1234' ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Email</h5>
                            <p><?= $profilWebsite['email'] ?? 'info@biddokkes.polri.go.id' ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item mb-4">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h5>Jam Operasional</h5>
                            <p><?= nl2br($profilWebsite['jam_operasional'] ?? 'Senin - Jumat: 08:00 - 16:00<br>Sabtu: 08:00 - 12:00<br>Minggu & Hari Libur: Tutup') ?></p>
                        </div>
                    </div>
                    
                    <div class="social-links mt-4">
                        <h5 class="mb-3">Ikuti Kami</h5>
                        <div class="social-buttons">
                            <?php if (!empty($profilWebsite['facebook'])): ?>
                            <a href="<?= $profilWebsite['facebook'] ?>" target="_blank" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($profilWebsite['twitter'])): ?>
                            <a href="<?= $profilWebsite['twitter'] ?>" target="_blank" class="social-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($profilWebsite['instagram'])): ?>
                            <a href="<?= $profilWebsite['instagram'] ?>" target="_blank" class="social-btn instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <?php endif; ?>
                            <?php if (!empty($profilWebsite['youtube'])): ?>
                            <a href="<?= $profilWebsite['youtube'] ?>" target="_blank" class="social-btn youtube">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="contact-form">
                    <h3 class="section-title mb-4">Kirim Pesan</h3>
                    <p class="text-muted mb-4">Silakan isi form di bawah ini untuk menghubungi kami. Tim kami akan segera merespons pesan Anda.</p>
                    
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form id="contactForm" action="<?= base_url('send-contact') ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control <?= session()->getFlashdata('errors.nama') ? 'is-invalid' : '' ?>" 
                                       id="nama" name="nama" value="<?= old('nama') ?>" required>
                                <?php if (session()->getFlashdata('errors.nama')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.nama') ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control <?= session()->getFlashdata('errors.email') ? 'is-invalid' : '' ?>" 
                                       id="email" name="email" value="<?= old('email') ?>" required>
                                <?php if (session()->getFlashdata('errors.email')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.email') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="tel" class="form-control <?= session()->getFlashdata('errors.telepon') ? 'is-invalid' : '' ?>" 
                                       id="telepon" name="telepon" value="<?= old('telepon') ?>">
                                <?php if (session()->getFlashdata('errors.telepon')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.telepon') ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subjek" class="form-label">Subjek *</label>
                                <select class="form-select <?= session()->getFlashdata('errors.subjek') ? 'is-invalid' : '' ?>" 
                                        id="subjek" name="subjek" required>
                                    <option value="">Pilih Subjek</option>
                                    <option value="Informasi Umum" <?= old('subjek') == 'Informasi Umum' ? 'selected' : '' ?>>Informasi Umum</option>
                                    <option value="Layanan Kesehatan" <?= old('subjek') == 'Layanan Kesehatan' ? 'selected' : '' ?>>Layanan Kesehatan</option>
                                    <option value="Pendaftaran" <?= old('subjek') == 'Pendaftaran' ? 'selected' : '' ?>>Pendaftaran</option>
                                    <option value="Keluhan" <?= old('subjek') == 'Keluhan' ? 'selected' : '' ?>>Keluhan</option>
                                    <option value="Saran" <?= old('subjek') == 'Saran' ? 'selected' : '' ?>>Saran</option>
                                    <option value="Lainnya" <?= old('subjek') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                                <?php if (session()->getFlashdata('errors.subjek')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.subjek') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan *</label>
                            <textarea class="form-control <?= session()->getFlashdata('errors.pesan') ? 'is-invalid' : '' ?>" 
                                      id="pesan" name="pesan" rows="5" required placeholder="Tulis pesan Anda di sini..."><?= old('pesan') ?></textarea>
                            <?php if (session()->getFlashdata('errors.pesan')): ?>
                                <div class="invalid-feedback"><?= session()->getFlashdata('errors.pesan') ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input <?= session()->getFlashdata('errors.setuju') ? 'is-invalid' : '' ?>" 
                                       type="checkbox" id="setuju" name="setuju" required>
                                <label class="form-check-label" for="setuju">
                                    Saya setuju dengan <a href="#" class="text-primary">kebijakan privasi</a> dan <a href="#" class="text-primary">syarat penggunaan</a>
                                </label>
                                <?php if (session()->getFlashdata('errors.setuju')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('errors.setuju') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-5" data-aos="fade-up">
                    <h3 class="section-title">Lokasi Kami</h3>
                    <div class="title-line mx-auto"></div>
                    <p class="text-muted mt-3">Kunjungi kantor pusat Biddokkes POLRI</p>
                </div>
                
                <div class="map-container" data-aos="fade-up">
                    <?php if (!empty($profilWebsite['map_embed'])): ?>
                        <div class="map-embed">
                            <?= $profilWebsite['map_embed'] ?>
                        </div>
                    <?php else: ?>
                        <div class="map-placeholder">
                            <div class="map-content">
                                <i class="fas fa-map-marked-alt fa-3x text-primary mb-3"></i>
                                <h5>Peta Lokasi</h5>
                                <p class="text-muted">Peta akan ditampilkan di sini</p>
                                <?php if (!empty($profilWebsite['map_url'])): ?>
                                <a href="<?= $profilWebsite['map_url'] ?>" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-external-link-alt me-2"></i>Buka di Google Maps
                                </a>
                                <?php else: ?>
                                <a href="https://maps.google.com" target="_blank" class="btn btn-outline-primary">
                                    <i class="fas fa-external-link-alt me-2"></i>Buka di Google Maps
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header text-center mb-5" data-aos="fade-up">
                    <h3 class="section-title">Pertanyaan Umum</h3>
                    <div class="title-line mx-auto"></div>
                    <p class="text-muted mt-3">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
                </div>
                
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="accordion" id="faqAccordion" data-aos="fade-up">
                            <?php if (!empty($faqs)): ?>
                                <?php foreach ($faqs as $index => $faq): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="faq<?= $faq['id'] ?>">
                                            <button class="accordion-button <?= $index > 0 ? 'collapsed' : '' ?>" 
                                                    type="button" data-bs-toggle="collapse" 
                                                    data-bs-target="#collapse<?= $faq['id'] ?>">
                                                <?= esc($faq['pertanyaan']) ?>
                                            </button>
                                        </h2>
                                        <div id="collapse<?= $faq['id'] ?>" 
                                             class="accordion-collapse collapse <?= $index == 0 ? 'show' : '' ?>" 
                                             data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                                <?= nl2br(esc($faq['jawaban'])) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback FAQ jika tidak ada data -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                            Bagaimana cara mendaftar untuk layanan kesehatan di Biddokkes POLRI?
                                        </button>
                                    </h2>
                                    <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Untuk mendaftar layanan kesehatan, Anda dapat menghubungi kami melalui telepon atau datang langsung ke kantor kami. Tim kami akan membantu proses pendaftaran dan memberikan informasi lengkap tentang layanan yang tersedia.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                            Apakah layanan kesehatan tersedia 24 jam?
                                        </button>
                                    </h2>
                                    <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Layanan darurat tersedia 24 jam untuk kasus-kasus tertentu. Namun untuk layanan umum, kami beroperasi sesuai jam kerja yang telah ditentukan. Silakan hubungi kami untuk informasi lebih lanjut.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                            Dokter spesialis apa saja yang tersedia?
                                        </button>
                                    </h2>
                                    <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Kami memiliki berbagai dokter spesialis termasuk dokter umum, spesialis penyakit dalam, spesialis bedah, spesialis jantung, spesialis mata, dan lainnya. Silakan hubungi kami untuk jadwal konsultasi.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                            Bagaimana cara mengajukan keluhan atau saran?
                                        </button>
                                    </h2>
                                    <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            Anda dapat mengajukan keluhan atau saran melalui form kontak di halaman ini, email, atau datang langsung ke kantor kami. Tim kami akan merespons dan menindaklanjuti setiap keluhan atau saran yang masuk.
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Character counter for message
    document.getElementById('pesan').addEventListener('input', function() {
        const maxLength = 1000;
        const currentLength = this.value.length;
        const remaining = maxLength - currentLength;
        
        if (remaining < 0) {
            this.value = this.value.substring(0, maxLength);
        }
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>

<?= $this->include('frontend/layout/footer') ?> 