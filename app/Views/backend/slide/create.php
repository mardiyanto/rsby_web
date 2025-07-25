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
            <h3 class="mb-0">Tambah Slide</h3>
            <div class="float-right">
              <a href="<?= base_url('slide') ?>" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('slide/store') ?>" id="form-slide">
              <?= csrf_field() ?>
              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Judul Slide <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="<?= old('judul') ?>" required maxlength="200" placeholder="Masukkan judul slide">
                  </div>
                  <div class="form-group">
                    <label>Deskripsi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" class="form-control" rows="4" required placeholder="Masukkan deskripsi slide"><?= old('deskripsi') ?></textarea>
                  </div>
                  <div class="form-group">
                    <label>Link (Opsional)</label>
                    <input type="url" name="link" class="form-control" value="<?= old('link') ?>" placeholder="https://example.com">
                    <small class="form-text text-muted">URL yang akan dituju saat slide diklik</small>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Urutan <span class="text-danger">*</span></label>
                    <input type="number" name="urutan" class="form-control" value="<?= old('urutan', 1) ?>" required min="1" placeholder="1">
                    <small class="form-text text-muted">Urutan tampilan slide (1 = pertama)</small>
                  </div>
                  <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control" required>
                      <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                      <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Gambar Slide <span class="text-danger">*</span></label>
                    <div id="dropzone-gambar" class="dropzone-slide" style="border:2px dashed #ccc;padding:20px;text-align:center;cursor:pointer;border-radius:5px;min-height:150px;">
                      <span id="dropzone-text">Seret gambar ke sini atau klik untuk memilih file</span>
                      <input type="file" name="gambar" id="input-gambar" class="form-control-file" style="display:none;" accept="image/*" required>
                      <div id="preview-gambar" style="margin-top:10px;"></div>
                    </div>
                    <small class="form-text text-muted">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB. Ukuran yang disarankan: 1920x600px</small>
                  </div>
                </div>
              </div>
              
              <!-- Progress Bar -->
              <div id="progress-container" style="display:none;">
                <div class="progress mb-3">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="text-muted">Menyimpan slide...</small>
              </div>
              
              <button type="submit" class="btn btn-success" id="btn-submit">
                <i class="fas fa-save"></i> Simpan
              </button>
              <a href="<?= base_url('slide') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
              </a>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?= $this->include('backend/footeradmin') ?>
  </div>
</div>
<?= $this->include('backend/jsadmin') ?>

<script>
$(function(){
    var dropzone = $('#dropzone-gambar');
    var input = $('#input-gambar');
    var preview = $('#preview-gambar');
    var dropText = $('#dropzone-text');
    var progressContainer = $('#progress-container');
    var progressBar = $('.progress-bar');
    var btnSubmit = $('#btn-submit');

    // Klik area dropzone = klik input file
    dropzone.on('click', function(e){
        if(e.target.id !== 'input-gambar') input.trigger('click');
    });

    // Drag over
    dropzone.on('dragover', function(e){
        e.preventDefault();
        e.stopPropagation();
        dropzone.css('background','#f0f8ff');
        dropzone.css('border-color','#007bff');
    });
    
    dropzone.on('dragleave', function(e){
        e.preventDefault();
        e.stopPropagation();
        dropzone.css('background','');
        dropzone.css('border-color','#ccc');
    });
    
    // Drop file
    dropzone.on('drop', function(e){
        e.preventDefault();
        e.stopPropagation();
        dropzone.css('background','');
        dropzone.css('border-color','#ccc');
        var files = e.originalEvent.dataTransfer.files;
        if(files.length > 0){
            input[0].files = files;
            showPreview(files[0]);
        }
    });
    
    // Change input file
    input.on('change', function(){
        if(this.files && this.files[0]){
            showPreview(this.files[0]);
        }
    });
    
    function showPreview(file){
        // Validasi ukuran file (2MB)
        if(file.size > 2 * 1024 * 1024){
            preview.html('<span class="text-danger">Ukuran file terlalu besar! Maksimal 2MB.</span>');
            return;
        }
        
        if(!file.type.match('image.*')){
            preview.html('<span class="text-danger">File bukan gambar! Pilih file JPG, PNG, atau GIF.</span>');
            return;
        }
        
        var reader = new FileReader();
        reader.onload = function(e){
            preview.html('<img src="'+e.target.result+'" alt="Preview" width="100%" class="img-thumbnail">');
        }
        reader.readAsDataURL(file);
    }
    
    // Form submission dengan progress bar
    $('#form-slide').on('submit', function(e){
        var judul = $('input[name="judul"]').val().trim();
        var deskripsi = $('textarea[name="deskripsi"]').val().trim();
        var urutan = $('input[name="urutan"]').val();
        var status = $('select[name="status"]').val();
        var gambar = $('input[name="gambar"]').val();
        
        if(!judul || !deskripsi || !urutan || !status || !gambar){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua field yang bertanda * harus diisi!'
            });
            return false;
        }
        
        // Tampilkan progress bar
        progressContainer.show();
        btnSubmit.prop('disabled', true);
        
        // Simulasi progress bar
        var progress = 0;
        var interval = setInterval(function(){
            progress += Math.random() * 30;
            if(progress > 90) progress = 90;
            progressBar.css('width', progress + '%');
        }, 200);
        
        // Reset progress saat form berhasil disubmit
        $(this).on('submit', function(){
            clearInterval(interval);
            progressBar.css('width', '100%');
        });
    });
});
</script> 