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
            <h3 class="mb-0">Tambah Kategori Download</h3>
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

            <form action="<?= base_url('kategori-download/store') ?>" method="post" id="formKategori">
              <?= csrf_field() ?>
              
              <div class="form-group">
                <label for="nama_kategori_download">Nama Kategori Download <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= (session()->getFlashdata('errors.nama_kategori_download')) ? 'is-invalid' : '' ?>" 
                       id="nama_kategori_download" name="nama_kategori_download" 
                       value="<?= old('nama_kategori_download') ?>" 
                       placeholder="Masukkan nama kategori download" required>
                <?php if (session()->getFlashdata('errors.nama_kategori_download')): ?>
                  <div class="invalid-feedback">
                    <?= session()->getFlashdata('errors.nama_kategori_download') ?>
                  </div>
                <?php endif; ?>
                <small class="form-text text-muted">Minimal 3 karakter, maksimal 100 karakter</small>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Simpan
                </button>
                <a href="<?= base_url('kategori-download') ?>" class="btn btn-secondary">
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
  // Trim input saat blur
  $('#nama_kategori_download').on('blur', function() {
    $(this).val($(this).val().trim());
  });

  $('#formKategori').validate({
    rules: {
      nama_kategori_download: {
        required: true,
        minlength: 3,
        maxlength: 100,
        pattern: /^[a-zA-Z0-9\s\-_]+$/
      }
    },
    messages: {
      nama_kategori_download: {
        required: "Nama kategori download harus diisi",
        minlength: "Nama kategori download minimal 3 karakter",
        maxlength: "Nama kategori download maksimal 100 karakter",
        pattern: "Nama kategori download hanya boleh berisi huruf, angka, spasi, tanda hubung, dan underscore"
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
      // Trim input sebelum submit
      $('#nama_kategori_download').val($('#nama_kategori_download').val().trim());
      form.submit();
    }
  });
});
</script> 