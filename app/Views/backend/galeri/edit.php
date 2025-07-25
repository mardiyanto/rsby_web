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
            <h3 class="mb-0"><?= $title ?></h3>
            <a href="<?= base_url('galeri') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
              <div class="alert alert-danger">
                <strong>Terdapat kesalahan pada form:</strong>
                <ul class="mb-0 mt-2">
                  <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('galeri/update/' . $galeri['id_galeri']) ?>" enctype="multipart/form-data" id="galeriForm">
              <?= csrf_field() ?>
              
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group mb-3">
                    <label for="judul" class="form-label">Judul Galeri <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control <?= (session('errors.judul')) ? 'is-invalid' : '' ?>" 
                           id="judul" 
                           name="judul" 
                           value="<?= old('judul', $galeri['judul']) ?>" 
                           required>
                    <?php if (session('errors.judul')): ?>
                      <div class="invalid-feedback"><?= session('errors.judul') ?></div>
                    <?php endif; ?>
                  </div>

                  <div class="form-group mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control <?= (session('errors.deskripsi')) ? 'is-invalid' : '' ?>" 
                              id="deskripsi" 
                              name="deskripsi" 
                              rows="4"><?= old('deskripsi', $galeri['deskripsi']) ?></textarea>
                    <?php if (session('errors.deskripsi')): ?>
                      <div class="invalid-feedback"><?= session('errors.deskripsi') ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Maksimal 1000 karakter</small>
                  </div>

                  <div class="form-group mb-3">
                    <label for="tanggal_upload" class="form-label">Tanggal Upload <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control <?= (session('errors.tanggal_upload')) ? 'is-invalid' : '' ?>" 
                           id="tanggal_upload" 
                           name="tanggal_upload" 
                           value="<?= old('tanggal_upload', $galeri['tanggal_upload']) ?>" 
                           required>
                    <?php if (session('errors.tanggal_upload')): ?>
                      <div class="invalid-feedback"><?= session('errors.tanggal_upload') ?></div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    
                    <!-- Current Image Preview -->
                    <div class="card mb-3">
                      <div class="card-body text-center">
                        <img src="<?= base_url('uploads/galeri/' . $galeri['nama_file']) ?>" 
                             alt="<?= $galeri['judul'] ?>" 
                             class="img-fluid rounded" 
                             style="max-height: 200px;">
                        <div class="mt-2">
                          <span class="badge bg-primary"><?= $galeri['nama_file'] ?></span>
                        </div>
                        <div class="mt-2">
                          <a href="<?= base_url('uploads/galeri/' . $galeri['nama_file']) ?>" 
                             target="_blank" 
                             class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Lihat
                          </a>
                          <a href="<?= base_url('galeri/download/' . $galeri['id_galeri']) ?>" 
                             class="btn btn-sm btn-success">
                            <i class="fas fa-download"></i> Download
                          </a>
                        </div>
                      </div>
                    </div>

                    <label class="form-label">Upload Gambar Baru (Opsional)</label>
                    
                    <!-- Dropzone Area -->
                    <div class="dropzone-area" id="dropzoneArea">
                      <div class="dropzone-content">
                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                        <h5>Drag & Drop Gambar Baru</h5>
                        <p class="text-muted">atau klik untuk memilih file</p>
                        <p class="text-muted small">Format: JPG, JPEG, PNG, GIF (Max: 2MB)</p>
                        <p class="text-muted small">Kosongkan jika tidak ingin mengubah gambar</p>
                      </div>
                      <input type="file" 
                             id="gambar" 
                             name="gambar" 
                             accept="image/*" 
                             class="dropzone-input">
                    </div>

                    <!-- New File Preview -->
                    <div id="filePreview" class="mt-3" style="display: none;">
                      <div class="card">
                        <div class="card-body text-center">
                          <img id="previewImage" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                          <div class="mt-2">
                            <span id="fileName" class="badge bg-primary"></span>
                            <span id="fileSize" class="badge bg-secondary ms-1"></span>
                          </div>
                          <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeFile()">
                            <i class="fas fa-trash"></i> Hapus
                          </button>
                        </div>
                      </div>
                    </div>

                    <?php if (session('errors.gambar')): ?>
                      <div class="text-danger small mt-1"><?= session('errors.gambar') ?></div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>

              <!-- Progress Bar -->
              <div class="progress mb-3" id="uploadProgress" style="display: none;">
                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                     role="progressbar" 
                     style="width: 0%" 
                     id="progressBar">0%</div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                  <i class="fas fa-save"></i> Update Galeri
                </button>
                <a href="<?= base_url('galeri') ?>" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Batal
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Notifikasi SweetAlert2 dari flashdata
<?php if (session()->getFlashdata('success')): ?>
Swal.fire({
  icon: 'success',
  title: 'Sukses',
  text: '<?= session()->getFlashdata('success') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
Swal.fire({
  icon: 'error',
  title: 'Gagal',
  text: '<?= session()->getFlashdata('error') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>
</script>

<style>
.dropzone-area {
  border: 2px dashed #dee2e6;
  border-radius: 10px;
  padding: 40px 20px;
  text-align: center;
  background: #f8f9fa;
  transition: all 0.3s ease;
  cursor: pointer;
  position: relative;
}

.dropzone-area:hover {
  border-color: #1e3c72;
  background: #e3f2fd;
}

.dropzone-area.dragover {
  border-color: #1e3c72;
  background: #e3f2fd;
  transform: scale(1.02);
}

.dropzone-input {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
}

.dropzone-content {
  pointer-events: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const dropzoneArea = document.getElementById('dropzoneArea');
  const fileInput = document.getElementById('gambar');
  const filePreview = document.getElementById('filePreview');
  const previewImage = document.getElementById('previewImage');
  const fileName = document.getElementById('fileName');
  const fileSize = document.getElementById('fileSize');
  const form = document.getElementById('galeriForm');
  const submitBtn = document.getElementById('submitBtn');
  const uploadProgress = document.getElementById('uploadProgress');
  const progressBar = document.getElementById('progressBar');

  // Drag and drop events
  dropzoneArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropzoneArea.classList.add('dragover');
  });

  dropzoneArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    dropzoneArea.classList.remove('dragover');
  });

  dropzoneArea.addEventListener('drop', function(e) {
    e.preventDefault();
    dropzoneArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
      handleFile(files[0]);
    }
  });

  // File input change
  fileInput.addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
      handleFile(e.target.files[0]);
    }
  });

  // Handle file selection
  function handleFile(file) {
    // Validate file type
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    if (!allowedTypes.includes(file.type)) {
      Swal.fire('Error', 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.', 'error');
      return;
    }

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
      Swal.fire('Error', 'Ukuran file maksimal 2MB.', 'error');
      return;
    }

    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
      previewImage.src = e.target.result;
      fileName.textContent = file.name;
      fileSize.textContent = formatFileSize(file.size);
      filePreview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  }

  // Remove file
  window.removeFile = function() {
    fileInput.value = '';
    filePreview.style.display = 'none';
    previewImage.src = '';
    fileName.textContent = '';
    fileSize.textContent = '';
  };

  // Format file size
  function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }

  // Form submission with progress
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validate required fields
    const judul = document.getElementById('judul').value.trim();
    const tanggalUpload = document.getElementById('tanggal_upload').value;

    if (!judul) {
      Swal.fire('Error', 'Judul galeri harus diisi.', 'error');
      return;
    }

    if (!tanggalUpload) {
      Swal.fire('Error', 'Tanggal upload harus diisi.', 'error');
      return;
    }

    // Show progress bar
    uploadProgress.style.display = 'block';
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

    // Simulate progress
    let progress = 0;
    const progressInterval = setInterval(() => {
      progress += Math.random() * 30;
      if (progress > 90) progress = 90;
      progressBar.style.width = progress + '%';
      progressBar.textContent = Math.round(progress) + '%';
    }, 200);

    // Submit form
    setTimeout(() => {
      clearInterval(progressInterval);
      progressBar.style.width = '100%';
      progressBar.textContent = '100%';
      
      setTimeout(() => {
        form.submit();
      }, 500);
    }, 1500);
  });
});
</script> 