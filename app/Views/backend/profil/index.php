<?= $this->include('backend/headeradmin') ?>
<div class="main-content">
  <?= $this->include('backend/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body"></div>
    </div>
  </div>
  <div class="container-fluid mt--7">
    <div class="row">
      <div class="col-xl-12">
        <div class="card shadow">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Profil Website</h3>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
              <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
              </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>

            <form action="<?= base_url('profil/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="nama_website">Nama Website <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_website" name="nama_website" 
                                   value="<?= old('nama_website', $profil['nama_website'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="deskripsi">Deskripsi Website <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= old('deskripsi', $profil['deskripsi'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= old('alamat', $profil['alamat'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telepon">Telepon <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="telepon" name="telepon" 
                                           value="<?= old('telepon', $profil['telepon'] ?? '') ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?= old('email', $profil['email'] ?? '') ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="website">Website <span class="text-danger">*</span></label>
                            <input type="url" class="form-control" id="website" name="website" 
                                   value="<?= old('website', $profil['website'] ?? '') ?>" required>
                        </div>

                        <h5 class="mt-4">Social Media</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="facebook">Facebook</label>
                                    <input type="url" class="form-control" id="facebook" name="facebook" 
                                           value="<?= old('facebook', $profil['facebook'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="twitter">Twitter</label>
                                    <input type="url" class="form-control" id="twitter" name="twitter" 
                                           value="<?= old('twitter', $profil['twitter'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram">Instagram</label>
                                    <input type="url" class="form-control" id="instagram" name="instagram" 
                                           value="<?= old('instagram', $profil['instagram'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube">YouTube</label>
                                    <input type="url" class="form-control" id="youtube" name="youtube" 
                                           value="<?= old('youtube', $profil['youtube'] ?? '') ?>">
                                </div>
                            </div>
                        </div>

                        <h5 class="mt-4">Jam Operasional</h5>
                        <div class="form-group">
                            <label for="jam_operasional">Jam Operasional</label>
                            <textarea class="form-control" id="jam_operasional" name="jam_operasional" rows="4" 
                                      placeholder="Contoh: Senin - Jumat: 08:00 - 16:00&#10;Sabtu: 08:00 - 12:00&#10;Minggu & Hari Libur: Tutup"><?= old('jam_operasional', $profil['jam_operasional'] ?? '') ?></textarea>
                            <small class="form-text text-muted">Masukkan jam operasional dengan format yang jelas</small>
                        </div>

                        <h5 class="mt-4">Informasi Peta</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="map_url">URL Google Maps</label>
                                    <input type="url" class="form-control" id="map_url" name="map_url" 
                                           value="<?= old('map_url', $profil['map_url'] ?? '') ?>" 
                                           placeholder="https://maps.google.com/...">
                                    <small class="form-text text-muted">Link ke Google Maps lokasi kantor</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="map_embed">Embed Code Google Maps</label>
                                    <textarea class="form-control" id="map_embed" name="map_embed" rows="3" 
                                              placeholder="<iframe src='...'></iframe>"><?= old('map_embed', $profil['map_embed'] ?? '') ?></textarea>
                                    <small class="form-text text-muted">Kode embed dari Google Maps untuk ditampilkan di website</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logo">Logo Website</label>
                            <div class="drag-drop-area" id="logo-drop-area">
                                <div class="drag-drop-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="drag-drop-text">Drag & drop logo di sini atau <span class="text-primary">klik untuk pilih file</span></p>
                                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</small>
                                </div>
                                <input type="file" class="form-control-file d-none" id="logo" name="logo" accept="image/*">
                            </div>
                            
                            <?php if (!empty($profil['logo'])) : ?>
                                <div class="mt-3">
                                    <label>Logo Saat Ini:</label>
                                    <img src="<?= base_url('uploads/profil/' . $profil['logo']) ?>" 
                                         alt="Logo" class="img-thumbnail d-block" style="max-width: 200px;">
                                </div>
                            <?php endif; ?>
                            
                            <div id="logo-preview" class="mt-3 d-none">
                                <label>Preview Logo Baru:</label>
                                <img id="logo-preview-img" src="" alt="Preview" class="img-thumbnail d-block" style="max-width: 200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="favicon">Favicon</label>
                            <div class="drag-drop-area" id="favicon-drop-area">
                                <div class="drag-drop-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="drag-drop-text">Drag & drop favicon di sini atau <span class="text-primary">klik untuk pilih file</span></p>
                                    <small class="text-muted">Format: ICO, PNG. Maksimal 1MB.</small>
                                </div>
                                <input type="file" class="form-control-file d-none" id="favicon" name="favicon" accept="image/x-icon,image/png">
                            </div>
                            
                            <?php if (!empty($profil['favicon'])) : ?>
                                <div class="mt-3">
                                    <label>Favicon Saat Ini:</label>
                                    <img src="<?= base_url('uploads/profil/' . $profil['favicon']) ?>" 
                                         alt="Favicon" class="img-thumbnail d-block" style="max-width: 32px;">
                                </div>
                            <?php endif; ?>
                            
                            <div id="favicon-preview" class="mt-3 d-none">
                                <label>Preview Favicon Baru:</label>
                                <img id="favicon-preview-img" src="" alt="Preview" class="img-thumbnail d-block" style="max-width: 32px;">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="<?= base_url('dashboard/admin') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?= $this->include('backend/footeradmin') ?>
  </div>
</div>
<?= $this->include('backend/jsadmin') ?>

<style>
.drag-drop-area {
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.drag-drop-area:hover {
    border-color: #5e72e4;
    background: #f0f2ff;
}

.drag-drop-area.dragover {
    border-color: #5e72e4;
    background: #e8ecff;
    transform: scale(1.02);
}

.drag-drop-area.dragover .drag-drop-content {
    opacity: 0.7;
}

.drag-drop-content {
    transition: opacity 0.3s ease;
}

.drag-drop-text {
    margin-bottom: 10px;
    font-size: 14px;
}

.drag-drop-area input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.error-message {
    color: #dc3545;
    font-size: 12px;
    margin-top: 5px;
}

.success-message {
    color: #28a745;
    font-size: 12px;
    margin-top: 5px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logo drag and drop
    const logoDropArea = document.getElementById('logo-drop-area');
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logo-preview');
    const logoPreviewImg = document.getElementById('logo-preview-img');

    // Favicon drag and drop
    const faviconDropArea = document.getElementById('favicon-drop-area');
    const faviconInput = document.getElementById('favicon');
    const faviconPreview = document.getElementById('favicon-preview');
    const faviconPreviewImg = document.getElementById('favicon-preview-img');

    // Setup drag and drop for logo
    setupDragAndDrop(logoDropArea, logoInput, logoPreview, logoPreviewImg, {
        maxSize: 2 * 1024 * 1024, // 2MB
        allowedTypes: ['image/jpeg', 'image/png', 'image/gif'],
        errorMessage: 'Format file harus JPG, PNG, atau GIF. Maksimal 2MB.'
    });

    // Setup drag and drop for favicon
    setupDragAndDrop(faviconDropArea, faviconInput, faviconPreview, faviconPreviewImg, {
        maxSize: 1 * 1024 * 1024, // 1MB
        allowedTypes: ['image/x-icon', 'image/png'],
        errorMessage: 'Format file harus ICO atau PNG. Maksimal 1MB.'
    });

    function setupDragAndDrop(dropArea, input, preview, previewImg, options) {
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area when item is dragged over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropArea.addEventListener('drop', handleDrop, false);

        // Handle click to select file
        dropArea.addEventListener('click', () => input.click());

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            dropArea.classList.add('dragover');
        }

        function unhighlight(e) {
            dropArea.classList.remove('dragover');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }

        function handleFiles(files) {
            if (files.length > 0) {
                const file = files[0];
                
                // Validate file type
                if (!options.allowedTypes.includes(file.type)) {
                    showError(dropArea, 'Format file tidak didukung. ' + options.errorMessage);
                    return;
                }

                // Validate file size
                if (file.size > options.maxSize) {
                    showError(dropArea, 'Ukuran file terlalu besar. ' + options.errorMessage);
                    return;
                }

                // Set file to input
                input.files = files;
                
                // Show preview
                showPreview(file, preview, previewImg);
                
                // Show success message
                showSuccess(dropArea, 'File berhasil dipilih: ' + file.name);
            }
        }

        // Handle file input change
        input.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                
                // Validate file type
                if (!options.allowedTypes.includes(file.type)) {
                    showError(dropArea, 'Format file tidak didukung. ' + options.errorMessage);
                    this.value = '';
                    return;
                }

                // Validate file size
                if (file.size > options.maxSize) {
                    showError(dropArea, 'Ukuran file terlalu besar. ' + options.errorMessage);
                    this.value = '';
                    return;
                }

                // Show preview
                showPreview(file, preview, previewImg);
                
                // Show success message
                showSuccess(dropArea, 'File berhasil dipilih: ' + file.name);
            }
        });
    }

    function showPreview(file, preview, previewImg) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }

    function showError(element, message) {
        // Remove existing messages
        const existingError = element.querySelector('.error-message');
        const existingSuccess = element.querySelector('.success-message');
        
        if (existingError) existingError.remove();
        if (existingSuccess) existingSuccess.remove();

        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        element.appendChild(errorDiv);

        // Remove error message after 5 seconds
        setTimeout(() => {
            if (errorDiv.parentNode) {
                errorDiv.remove();
            }
        }, 5000);
    }

    function showSuccess(element, message) {
        // Remove existing messages
        const existingError = element.querySelector('.error-message');
        const existingSuccess = element.querySelector('.success-message');
        
        if (existingError) existingError.remove();
        if (existingSuccess) existingSuccess.remove();

        // Add new success message
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.textContent = message;
        element.appendChild(successDiv);

        // Remove success message after 3 seconds
        setTimeout(() => {
            if (successDiv.parentNode) {
                successDiv.remove();
            }
        }, 3000);
    }
});
</script>