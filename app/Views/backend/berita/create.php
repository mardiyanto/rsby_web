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
            <h3 class="mb-0">Tambah Berita</h3>
            <div class="float-right">
              <a href="<?= base_url('berita') ?>" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('berita/store') ?>">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Judul Berita <span class="text-danger">*</span></label>
                <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul') ?>" required maxlength="200" placeholder="Masukkan judul berita">
              </div>
              <div class="form-group">
                <label>Slug <span class="text-danger">*</span></label>
                <input type="text" name="slug" id="slug" class="form-control" value="<?= old('slug') ?>" required maxlength="255" placeholder="Slug akan diisi otomatis" readonly>
                <small class="form-text text-muted">Slug akan diisi otomatis berdasarkan judul berita</small>
              </div>
              <div class="form-group">
                <label>Kategori <span class="text-danger">*</span></label>
                <select name="id_kategori" class="form-control" required>
                  <option value="">-- Pilih Kategori --</option>
                  <?php foreach ($kategori as $kat): ?>
                    <option value="<?= $kat['id_kategori'] ?>" <?= old('id_kategori') == $kat['id_kategori'] ? 'selected' : '' ?>>
                      <?= esc($kat['nama_kategori']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Penulis <span class="text-danger">*</span></label>
                <input type="text" name="penulis" id="penulis" class="form-control" value="<?= old('penulis', $penulis) ?>" required maxlength="100" placeholder="Masukkan nama penulis">
                <small class="form-text text-muted">Penulis diisi otomatis dari nama login Anda</small>
              </div>
              <div class="form-group">
                <label>Tanggal Terbit <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_terbit" class="form-control" value="<?= old('tanggal_terbit', date('Y-m-d')) ?>" required>
              </div>
              <div class="form-group">
                <label>Isi Berita <span class="text-danger">*</span></label>
                <textarea name="isi" class="form-control" rows="10" required placeholder="Masukkan isi berita"><?= old('isi') ?></textarea>
              </div>
              <div class="form-group">
                <label>Gambar</label>
                <div id="dropzone-gambar" class="dropzone-berita" style="border:2px dashed #ccc;padding:20px;text-align:center;cursor:pointer;border-radius:5px;">
                  <span id="dropzone-text">Seret gambar ke sini atau klik untuk memilih file</span>
                  <input type="file" name="gambar" id="input-gambar" class="form-control-file" style="display:none;" accept="image/*">
                  <div id="preview-gambar" style="margin-top:10px;"></div>
                </div>
                <small class="form-text text-muted">Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.</small>
              </div>
              <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Simpan
              </button>
              <a href="<?= base_url('berita') ?>" class="btn btn-secondary">
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

    // Generate slug otomatis saat judul diketik
    $('#judul').on('input', function() {
        var judul = $(this).val();
        if (judul) {
            generateSlug(judul);
        } else {
            $('#slug').val('');
        }
    });

    // Function untuk generate slug
    function generateSlug(judul) {
        // Convert ke lowercase
        var slug = judul.toLowerCase();
        
        // Replace karakter khusus dengan dash
        slug = slug.replace(/[^a-z0-9\s-]/g, '');
        
        // Replace spasi dengan dash
        slug = slug.replace(/[\s-]+/g, '-');
        
        // Remove dash di awal dan akhir
        slug = slug.replace(/^-+|-+$/g, '');
        
        // Jika slug kosong, gunakan 'berita'
        if (!slug) {
            slug = 'berita';
        }
        
        $('#slug').val(slug);
    }

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
    
    // Form validation
    $('form').on('submit', function(e){
        var judul = $('input[name="judul"]').val().trim();
        var slug = $('input[name="slug"]').val().trim();
        var id_kategori = $('select[name="id_kategori"]').val();
        var penulis = $('input[name="penulis"]').val().trim();
        var tanggal_terbit = $('input[name="tanggal_terbit"]').val();
        var isi = $('textarea[name="isi"]').val().trim();
        
        if(!judul || !slug || !id_kategori || !penulis || !tanggal_terbit || !isi){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua field yang bertanda * harus diisi!'
            });
            return false;
        }
    });

    // Generate slug saat halaman dimuat jika judul sudah ada
    if ($('#judul').val()) {
        generateSlug($('#judul').val());
    }
});
</script> 