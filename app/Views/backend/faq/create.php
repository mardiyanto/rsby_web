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
            <h3 class="mb-0">Tambah FAQ</h3>
            <div class="btn-group">
              <a href="<?= base_url('faq') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
          <div class="card-body">
            <form method="POST" action="<?= base_url('faq/create') ?>" id="faqForm">
              <?= csrf_field() ?>
              
              <div class="form-group">
                <label for="pertanyaan">Pertanyaan *</label>
                <textarea class="form-control <?= session()->getFlashdata('errors.pertanyaan') ? 'is-invalid' : '' ?>" 
                          id="pertanyaan" name="pertanyaan" rows="3" 
                          placeholder="Masukkan pertanyaan FAQ..." required><?= old('pertanyaan') ?></textarea>
                <?php if (session()->getFlashdata('errors.pertanyaan')): ?>
                  <div class="invalid-feedback"><?= session()->getFlashdata('errors.pertanyaan') ?></div>
                <?php endif; ?>
                <small class="form-text text-muted">Minimal 10 karakter</small>
              </div>
              
              <div class="form-group">
                <label for="jawaban">Jawaban *</label>
                <textarea class="form-control <?= session()->getFlashdata('errors.jawaban') ? 'is-invalid' : '' ?>" 
                          id="jawaban" name="jawaban" rows="6" 
                          placeholder="Masukkan jawaban FAQ..." required><?= old('jawaban') ?></textarea>
                <?php if (session()->getFlashdata('errors.jawaban')): ?>
                  <div class="invalid-feedback"><?= session()->getFlashdata('errors.jawaban') ?></div>
                <?php endif; ?>
                <small class="form-text text-muted">Minimal 20 karakter</small>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="urutan">Urutan *</label>
                    <input type="number" class="form-control <?= session()->getFlashdata('errors.urutan') ? 'is-invalid' : '' ?>" 
                           id="urutan" name="urutan" value="<?= old('urutan') ?>" min="1" required>
                    <?php if (session()->getFlashdata('errors.urutan')): ?>
                      <div class="invalid-feedback"><?= session()->getFlashdata('errors.urutan') ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Urutan tampilan FAQ (1, 2, 3, dst)</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="status">Status *</label>
                    <select class="form-control <?= session()->getFlashdata('errors.status') ? 'is-invalid' : '' ?>" 
                            id="status" name="status" required>
                      <option value="">Pilih Status</option>
                      <option value="aktif" <?= old('status') == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                      <option value="nonaktif" <?= old('status') == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <?php if (session()->getFlashdata('errors.status')): ?>
                      <div class="invalid-feedback"><?= session()->getFlashdata('errors.status') ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Status tampilan FAQ</small>
                  </div>
                </div>
              </div>
              
              <div class="d-flex justify-content-between">
                <a href="<?= base_url('faq') ?>" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Simpan FAQ
                </button>
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

<script>
$(document).ready(function() {
  // Character counter for pertanyaan
  $('#pertanyaan').on('input', function() {
    var maxLength = 500;
    var currentLength = this.value.length;
    var remaining = maxLength - currentLength;
    
    if (remaining < 0) {
      this.value = this.value.substring(0, maxLength);
      remaining = 0;
    }
    
    // Update counter
    var counter = $('#pertanyaanCounter');
    if (counter.length === 0) {
      $(this).after('<small id="pertanyaanCounter" class="form-text text-muted"></small>');
    }
    $('#pertanyaanCounter').text(remaining + ' karakter tersisa');
  });
  
  // Character counter for jawaban
  $('#jawaban').on('input', function() {
    var maxLength = 2000;
    var currentLength = this.value.length;
    var remaining = maxLength - currentLength;
    
    if (remaining < 0) {
      this.value = this.value.substring(0, maxLength);
      remaining = 0;
    }
    
    // Update counter
    var counter = $('#jawabanCounter');
    if (counter.length === 0) {
      $(this).after('<small id="jawabanCounter" class="form-text text-muted"></small>');
    }
    $('#jawabanCounter').text(remaining + ' karakter tersisa');
  });
  
  // Form validation
  $('#faqForm').submit(function(e) {
    var pertanyaan = $('#pertanyaan').val().trim();
    var jawaban = $('#jawaban').val().trim();
    var urutan = $('#urutan').val();
    var status = $('#status').val();
    
    if (!pertanyaan || pertanyaan.length < 10) {
      Swal.fire('Error', 'Pertanyaan harus diisi minimal 10 karakter.', 'error');
      e.preventDefault();
      return false;
    }
    
    if (!jawaban || jawaban.length < 20) {
      Swal.fire('Error', 'Jawaban harus diisi minimal 20 karakter.', 'error');
      e.preventDefault();
      return false;
    }
    
    if (!urutan || urutan < 1) {
      Swal.fire('Error', 'Urutan harus diisi dan minimal 1.', 'error');
      e.preventDefault();
      return false;
    }
    
    if (!status) {
      Swal.fire('Error', 'Status harus dipilih.', 'error');
      e.preventDefault();
      return false;
    }
    
    // Confirm before submit
    Swal.fire({
      title: 'Konfirmasi',
      text: 'Yakin ingin menyimpan FAQ ini?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Simpan',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (!result.isConfirmed) {
        e.preventDefault();
        return false;
      }
    });
  });
  
  // Auto-set urutan if empty
  $('#urutan').on('blur', function() {
    if (!$(this).val()) {
      // Get next urutan from server
      $.get('<?= base_url('faq/next-urutan') ?>', function(data) {
        $('#urutan').val(data.next_urutan);
      });
    }
  });
});
</script> 