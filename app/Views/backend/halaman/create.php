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
            <h3 class="mb-0">Tambah Halaman</h3>
            <div class="float-right">
              <a href="<?= base_url('halaman') ?>" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('halaman/store') ?>" id="form-halaman">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Judul Halaman <span class="text-danger">*</span></label>
                <input type="text" name="judul" class="form-control" value="<?= old('judul') ?>" required maxlength="200" placeholder="Masukkan judul halaman">
              </div>
              <div class="form-group">
                <label>Penulis <span class="text-danger">*</span></label>
                <input type="text" name="penulis" class="form-control" value="<?= old('penulis') ?>" required maxlength="100" placeholder="Masukkan nama penulis">
              </div>
              <div class="form-group">
                <label>Tanggal Publish <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_publish" class="form-control" value="<?= old('tanggal_publish', date('Y-m-d')) ?>" required>
              </div>
              <div class="form-group">
                <label>Konten Halaman <span class="text-danger">*</span></label>
                <textarea name="konten" class="form-control" rows="15" required placeholder="Masukkan konten halaman"><?= old('konten') ?></textarea>
              </div>
              <div class="form-group">
                <label>Gambar</label>
                <div id="dropzone-gambar" class="dropzone-halaman" style="border:2px dashed #ccc;padding:20px;text-align:center;cursor:pointer;border-radius:5px;">
                  <span id="dropzone-text">Seret gambar ke sini atau klik untuk memilih file</span>
                  <input type="file" name="gambar" id="input-gambar" class="form-control-file" style="display:none;" accept="image/*">
                  <div id="preview-gambar" style="margin-top:10px;"></div>
                </div>
                <small class="form-text text-muted">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</small>
              </div>
              
              <!-- Progress Bar -->
              <div id="progress-container" style="display:none;">
                <div class="progress mb-3">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="text-muted">Menyimpan halaman...</small>
              </div>
              
              <button type="submit" class="btn btn-success" id="btn-submit">
                <i class="fas fa-save"></i> Simpan
              </button>
              <a href="<?= base_url('halaman') ?>" class="btn btn-secondary">
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
            preview.html('<img src="'+e.target.result+'" alt="Preview" width="120" class="img-thumbnail">');
        }
        reader.readAsDataURL(file);
    }
    
    // Form submission dengan progress bar
    $('#form-halaman').on('submit', function(e){
        var judul = $('input[name="judul"]').val().trim();
        var penulis = $('input[name="penulis"]').val().trim();
        var tanggal_publish = $('input[name="tanggal_publish"]').val();
        var konten = $('textarea[name="konten"]').val().trim();
        
        if(!judul || !penulis || !tanggal_publish || !konten){
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