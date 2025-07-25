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
          <div class="card-header border-0">
            <h3 class="mb-0">Edit File Download</h3>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
              <div class="alert alert-danger">
                <ul class="mb-0">
                  <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <form action="<?= base_url('download/update/' . $download['id_download']) ?>" method="post" enctype="multipart/form-data" id="formDownload">
              <?= csrf_field() ?>
              
              <div class="form-group">
                <label for="judul">Judul File <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (session()->getFlashdata('errors.judul')) ? 'is-invalid' : '' ?>" 
                       id="judul" name="judul" 
                       value="<?= old('judul', $download['judul']) ?>" 
                       placeholder="Masukkan judul file download" required>
                <?php if (session()->getFlashdata('errors.judul')): ?>
                  <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors.judul') ?>
                  </div>
                <?php endif; ?>
                <small class="form-text text-muted">Minimal 3 karakter, maksimal 255 karakter</small>
              </div>

              <div class="form-group">
                <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control <?= (session()->getFlashdata('errors.deskripsi')) ? 'is-invalid' : '' ?>" 
                          id="deskripsi" name="deskripsi" rows="4" 
                          placeholder="Masukkan deskripsi file download" required><?= old('deskripsi', $download['deskripsi']) ?></textarea>
                <?php if (session()->getFlashdata('errors.deskripsi')): ?>
                  <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors.deskripsi') ?>
                  </div>
                <?php endif; ?>
                <small class="form-text text-muted">Minimal 10 karakter</small>
              </div>

              <div class="form-group">
                <label for="id_kategori_download">Kategori <span class="text-danger">*</span></label>
                <select class="form-control <?= (session()->getFlashdata('errors.id_kategori_download')) ? 'is-invalid' : '' ?>" 
                        id="id_kategori_download" name="id_kategori_download" required>
                  <option value="">Pilih Kategori</option>
                  <?php foreach ($kategori_download as $kategori): ?>
                    <option value="<?= $kategori['id_kategori_download'] ?>" 
                            <?= (old('id_kategori_download', $download['id_kategori_download']) == $kategori['id_kategori_download']) ? 'selected' : '' ?>>
                      <?= esc($kategori['nama_kategori_download']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <?php if (session()->getFlashdata('errors.id_kategori_download')): ?>
                  <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors.id_kategori_download') ?>
                  </div>
                <?php endif; ?>
              </div>

              <div class="form-group">
                <label>File Saat Ini</label>
                <div class="alert alert-info">
                  <i class="fas fa-file-<?= getFileIcon($download['tipe_file']) ?> text-primary"></i>
                  <strong><?= esc($download['nama_file']) ?></strong>
                  <br>
                  <small>Ukuran: <?= formatFileSize($download['ukuran_file']) ?> | 
                         Tipe: <?= strtoupper($download['tipe_file']) ?> | 
                         Download: <?= $download['hits'] ?> kali</small>
                </div>
              </div>

              <div class="form-group">
                <label for="file">Upload File Baru (Opsional)</label>
                <div id="dropzone-file" class="dropzone-download <?= (session()->getFlashdata('errors.file')) ? 'is-invalid' : '' ?>" 
                     style="border:2px dashed #ccc;padding:30px;text-align:center;cursor:pointer;border-radius:8px;background:#f8f9fa;transition:all 0.3s ease;">
                  <div id="dropzone-text">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <h5>Seret file baru ke sini atau klik untuk memilih file</h5>
                    <p class="text-muted">Format yang diizinkan: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP, RAR</p>
                    <p class="text-muted">Maksimal 10MB</p>
                  </div>
                  <input type="file" name="file" id="input-file" class="form-control-file" style="display:none;" 
                         accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar">
                  <div id="preview-file" style="margin-top:15px;"></div>
                  <div id="progress-container" style="display:none;margin-top:15px;">
                    <div class="progress">
                      <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" 
                           role="progressbar" style="width: 0%">0%</div>
                    </div>
                    <small id="progress-text" class="text-muted">Mempersiapkan upload...</small>
                  </div>
                </div>
                <?php if (session()->getFlashdata('errors.file')): ?>
                  <div class="invalid-feedback d-block">
                    <?= session()->getFlashdata('errors.file') ?>
                  </div>
                <?php endif; ?>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Update
                </button>
                <a href="<?= base_url('download') ?>" class="btn btn-secondary">
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
<?php if (session()->getFlashdata('error')): ?>
Swal.fire({
  icon: 'error',
  title: 'Gagal',
  text: '<?= session('error') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>

$(document).ready(function() {
  var dropzone = $('#dropzone-file');
  var input = $('#input-file');
  var preview = $('#preview-file');
  var dropText = $('#dropzone-text');
  var progressContainer = $('#progress-container');
  var progressBar = $('#progress-bar');
  var progressText = $('#progress-text');

  // Klik area dropzone = klik input file
  dropzone.on('click', function(e) {
    if (e.target.id !== 'input-file') input.trigger('click');
  });

  // Drag over
  dropzone.on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    dropzone.css('background', '#e3f2fd');
    dropzone.css('border-color', '#2196f3');
    dropzone.css('transform', 'scale(1.02)');
  });
  
  dropzone.on('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    dropzone.css('background', '#f8f9fa');
    dropzone.css('border-color', '#ccc');
    dropzone.css('transform', 'scale(1)');
  });
  
  // Drop file
  dropzone.on('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
    dropzone.css('background', '#f8f9fa');
    dropzone.css('border-color', '#ccc');
    dropzone.css('transform', 'scale(1)');
    
    var files = e.originalEvent.dataTransfer.files;
    if (files.length > 0) {
      input[0].files = files;
      showPreview(files[0]);
    }
  });
  
  // Change input file
  input.on('change', function() {
    if (this.files && this.files[0]) {
      showPreview(this.files[0]);
    }
  });
  
  function showPreview(file) {
    // Validasi ukuran file (10MB)
    if (file.size > 10 * 1024 * 1024) {
      preview.html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Ukuran file terlalu besar! Maksimal 10MB.</div>');
      input.val('');
      return;
    }
    
    // Validasi tipe file
    var allowedTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'zip', 'rar'];
    var fileExtension = file.name.split('.').pop().toLowerCase();
    
    if (!allowedTypes.includes(fileExtension)) {
      preview.html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Format file tidak diizinkan! Pilih file PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP, atau RAR.</div>');
      input.val('');
      return;
    }
    
    // Tampilkan preview file baru
    var fileIcon = getFileIcon(fileExtension);
    var fileSize = formatFileSize(file.size);
    
    preview.html(`
      <div class="alert alert-warning">
        <div class="d-flex align-items-center">
          <i class="fas fa-file-${fileIcon} fa-2x text-warning mr-3"></i>
          <div>
            <strong>File Baru: ${file.name}</strong><br>
            <small class="text-muted">Ukuran: ${fileSize} | Tipe: ${fileExtension.toUpperCase()}</small><br>
            <small class="text-info"><i class="fas fa-info-circle"></i> File lama akan diganti dengan file ini</small>
          </div>
        </div>
      </div>
    `);
    
    // Sembunyikan dropzone text
    dropText.hide();
  }
  
  function getFileIcon(extension) {
    var icons = {
      'pdf': 'pdf',
      'doc': 'word',
      'docx': 'word',
      'xls': 'excel',
      'xlsx': 'excel',
      'ppt': 'powerpoint',
      'pptx': 'powerpoint',
      'txt': 'alt',
      'zip': 'archive',
      'rar': 'archive'
    };
    return icons[extension] || 'alt';
  }
  
  function formatFileSize(bytes) {
    if (bytes >= 1073741824) {
      return (bytes / 1073741824).toFixed(2) + ' GB';
    } else if (bytes >= 1048576) {
      return (bytes / 1048576).toFixed(2) + ' MB';
    } else if (bytes >= 1024) {
      return (bytes / 1024).toFixed(2) + ' KB';
    } else {
      return bytes + ' bytes';
    }
  }

  // Form validation
  $('#formDownload').validate({
    rules: {
      judul: {
        required: true,
        minlength: 3,
        maxlength: 255
      },
      deskripsi: {
        required: true,
        minlength: 10
      },
      id_kategori_download: {
        required: true
      },
      file: {
        extension: "pdf|doc|docx|xls|xlsx|ppt|pptx|txt|zip|rar"
      }
    },
    messages: {
      judul: {
        required: "Judul harus diisi",
        minlength: "Judul minimal 3 karakter",
        maxlength: "Judul maksimal 255 karakter"
      },
      deskripsi: {
        required: "Deskripsi harus diisi",
        minlength: "Deskripsi minimal 10 karakter"
      },
      id_kategori_download: {
        required: "Kategori download harus dipilih"
      },
      file: {
        extension: "Format file tidak diizinkan"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },
    submitHandler: function(form) {
      // Cek apakah ada file baru yang dipilih
      if (input[0].files && input[0].files[0]) {
        // Tampilkan progress bar saat submit
        progressContainer.show();
        progressText.text('Mengupload file baru...');
        
        // Simulasi progress bar
        var progress = 0;
        var progressInterval = setInterval(function() {
          progress += Math.random() * 15;
          if (progress > 90) progress = 90;
          progressBar.css('width', progress + '%').text(Math.round(progress) + '%');
        }, 200);
        
        // Submit form
        form.submit();
        
        // Clear interval setelah 3 detik
        setTimeout(function() {
          clearInterval(progressInterval);
          progressBar.css('width', '100%').text('100%');
          progressText.text('Upload selesai!');
        }, 3000);
      } else {
        // Jika tidak ada file baru, submit langsung
        form.submit();
      }
    }
  });
});
</script>

<?php
// Helper function untuk icon file
function getFileIcon($extension) {
    $icons = [
        'pdf' => 'pdf',
        'doc' => 'word',
        'docx' => 'word',
        'xls' => 'excel',
        'xlsx' => 'excel',
        'ppt' => 'powerpoint',
        'pptx' => 'powerpoint',
        'txt' => 'alt',
        'zip' => 'archive',
        'rar' => 'archive'
    ];
    
    return isset($icons[strtolower($extension)]) ? $icons[strtolower($extension)] : 'alt';
}

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