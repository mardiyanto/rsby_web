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
            <h3 class="mb-0">Edit Quick Stats</h3>
            <div class="btn-group">
              <a href="<?= base_url('stats') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
          <div class="card-body">
            <form method="POST" action="<?= base_url('stats/edit/' . $stat['id']) ?>" id="statsForm">
              <?= csrf_field() ?>
              
              <div class="form-group">
                <label for="judul">Judul *</label>
                <input type="text" class="form-control <?= session()->getFlashdata('errors.judul') ? 'is-invalid' : '' ?>" 
                       id="judul" name="judul" value="<?= old('judul', $stat['judul']) ?>" 
                       placeholder="Contoh: Dokter Spesialis" required>
                <?php if (session()->getFlashdata('errors.judul')): ?>
                  <div class="invalid-feedback"><?= session()->getFlashdata('errors.judul') ?></div>
                <?php endif; ?>
                <small class="form-text text-muted">Minimal 3 karakter, maksimal 255 karakter</small>
              </div>
              
              <div class="form-group">
                <label for="angka">Angka *</label>
                <input type="text" class="form-control <?= session()->getFlashdata('errors.angka') ? 'is-invalid' : '' ?>" 
                       id="angka" name="angka" value="<?= old('angka', $stat['angka']) ?>" 
                       placeholder="Contoh: 150+" required>
                <?php if (session()->getFlashdata('errors.angka')): ?>
                  <div class="invalid-feedback"><?= session()->getFlashdata('errors.angka') ?></div>
                <?php endif; ?>
                <small class="form-text text-muted">Angka atau teks yang akan ditampilkan (maksimal 50 karakter)</small>
              </div>
              
              <div class="form-group">
                <label for="ikon">Ikon *</label>
                <select class="form-control <?= session()->getFlashdata('errors.ikon') ? 'is-invalid' : '' ?>" 
                        id="ikon" name="ikon" required>
                  <option value="">Pilih Ikon</option>
                  <optgroup label="Kesehatan & Medis">
                    <option value="fas fa-user-md" <?= (old('ikon', $stat['ikon']) == 'fas fa-user-md') ? 'selected' : '' ?>>👨‍⚕️ Dokter</option>
                    <option value="fas fa-user-nurse" <?= (old('ikon', $stat['ikon']) == 'fas fa-user-nurse') ? 'selected' : '' ?>>👩‍⚕️ Perawat</option>
                    <option value="fas fa-hospital" <?= (old('ikon', $stat['ikon']) == 'fas fa-hospital') ? 'selected' : '' ?>>🏥 Rumah Sakit</option>
                    <option value="fas fa-medical-kit" <?= (old('ikon', $stat['ikon']) == 'fas fa-medical-kit') ? 'selected' : '' ?>>💊 Medical Kit</option>
                    <option value="fas fa-heartbeat" <?= (old('ikon', $stat['ikon']) == 'fas fa-heartbeat') ? 'selected' : '' ?>>💓 Heartbeat</option>
                    <option value="fas fa-stethoscope" <?= (old('ikon', $stat['ikon']) == 'fas fa-stethoscope') ? 'selected' : '' ?>>🩺 Stethoscope</option>
                    <option value="fas fa-pills" <?= (old('ikon', $stat['ikon']) == 'fas fa-pills') ? 'selected' : '' ?>>💊 Pills</option>
                    <option value="fas fa-procedures" <?= (old('ikon', $stat['ikon']) == 'fas fa-procedures') ? 'selected' : '' ?>>🩹 Procedures</option>
                  </optgroup>
                  <optgroup label="Statistik & Data">
                    <option value="fas fa-chart-bar" <?= (old('ikon', $stat['ikon']) == 'fas fa-chart-bar') ? 'selected' : '' ?>>📊 Chart Bar</option>
                    <option value="fas fa-chart-line" <?= (old('ikon', $stat['ikon']) == 'fas fa-chart-line') ? 'selected' : '' ?>>📈 Chart Line</option>
                    <option value="fas fa-chart-pie" <?= (old('ikon', $stat['ikon']) == 'fas fa-chart-pie') ? 'selected' : '' ?>>🥧 Chart Pie</option>
                    <option value="fas fa-percentage" <?= (old('ikon', $stat['ikon']) == 'fas fa-percentage') ? 'selected' : '' ?>>% Percentage</option>
                    <option value="fas fa-calculator" <?= (old('ikon', $stat['ikon']) == 'fas fa-calculator') ? 'selected' : '' ?>>🧮 Calculator</option>
                  </optgroup>
                  <optgroup label="Orang & Tim">
                    <option value="fas fa-users" <?= (old('ikon', $stat['ikon']) == 'fas fa-users') ? 'selected' : '' ?>>👥 Users</option>
                    <option value="fas fa-user" <?= (old('ikon', $stat['ikon']) == 'fas fa-user') ? 'selected' : '' ?>>👤 User</option>
                    <option value="fas fa-user-friends" <?= (old('ikon', $stat['ikon']) == 'fas fa-user-friends') ? 'selected' : '' ?>>👫 User Friends</option>
                    <option value="fas fa-user-graduate" <?= (old('ikon', $stat['ikon']) == 'fas fa-user-graduate') ? 'selected' : '' ?>>🎓 Graduate</option>
                    <option value="fas fa-user-tie" <?= (old('ikon', $stat['ikon']) == 'fas fa-user-tie') ? 'selected' : '' ?>>👔 Business User</option>
                  </optgroup>
                  <optgroup label="Bangunan & Lokasi">
                    <option value="fas fa-building" <?= (old('ikon', $stat['ikon']) == 'fas fa-building') ? 'selected' : '' ?>>🏢 Building</option>
                    <option value="fas fa-clinic-medical" <?= (old('ikon', $stat['ikon']) == 'fas fa-clinic-medical') ? 'selected' : '' ?>>🏥 Clinic</option>
                    <option value="fas fa-map-marker-alt" <?= (old('ikon', $stat['ikon']) == 'fas fa-map-marker-alt') ? 'selected' : '' ?>>📍 Map Marker</option>
                    <option value="fas fa-map" <?= (old('ikon', $stat['ikon']) == 'fas fa-map') ? 'selected' : '' ?>>🗺️ Map</option>
                  </optgroup>
                  <optgroup label="Waktu & Pengalaman">
                    <option value="fas fa-clock" <?= (old('ikon', $stat['ikon']) == 'fas fa-clock') ? 'selected' : '' ?>>🕐 Clock</option>
                    <option value="fas fa-calendar-alt" <?= (old('ikon', $stat['ikon']) == 'fas fa-calendar-alt') ? 'selected' : '' ?>>📅 Calendar</option>
                    <option value="fas fa-calendar-check" <?= (old('ikon', $stat['ikon']) == 'fas fa-calendar-check') ? 'selected' : '' ?>>✅ Calendar Check</option>
                    <option value="fas fa-history" <?= (old('ikon', $stat['ikon']) == 'fas fa-history') ? 'selected' : '' ?>>📜 History</option>
                  </optgroup>
                  <optgroup label="Pencapaian & Penghargaan">
                    <option value="fas fa-award" <?= (old('ikon', $stat['ikon']) == 'fas fa-award') ? 'selected' : '' ?>>🏆 Award</option>
                    <option value="fas fa-trophy" <?= (old('ikon', $stat['ikon']) == 'fas fa-trophy') ? 'selected' : '' ?>>🏆 Trophy</option>
                    <option value="fas fa-medal" <?= (old('ikon', $stat['ikon']) == 'fas fa-medal') ? 'selected' : '' ?>>🥇 Medal</option>
                    <option value="fas fa-star" <?= (old('ikon', $stat['ikon']) == 'fas fa-star') ? 'selected' : '' ?>>⭐ Star</option>
                    <option value="fas fa-certificate" <?= (old('ikon', $stat['ikon']) == 'fas fa-certificate') ? 'selected' : '' ?>>📜 Certificate</option>
                  </optgroup>
                  <optgroup label="Lainnya">
                    <option value="fas fa-check-circle" <?= (old('ikon', $stat['ikon']) == 'fas fa-check-circle') ? 'selected' : '' ?>>✅ Check Circle</option>
                    <option value="fas fa-thumbs-up" <?= (old('ikon', $stat['ikon']) == 'fas fa-thumbs-up') ? 'selected' : '' ?>>👍 Thumbs Up</option>
                    <option value="fas fa-handshake" <?= (old('ikon', $stat['ikon']) == 'fas fa-handshake') ? 'selected' : '' ?>>🤝 Handshake</option>
                    <option value="fas fa-shield-alt" <?= (old('ikon', $stat['ikon']) == 'fas fa-shield-alt') ? 'selected' : '' ?>>🛡️ Shield</option>
                    <option value="fas fa-lightbulb" <?= (old('ikon', $stat['ikon']) == 'fas fa-lightbulb') ? 'selected' : '' ?>>💡 Lightbulb</option>
                  </optgroup>
                </select>
                <?php if (session()->getFlashdata('errors.ikon')): ?>
                  <div class="invalid-feedback"><?= session()->getFlashdata('errors.ikon') ?></div>
                <?php endif; ?>
                <small class="form-text text-muted">Pilih ikon yang sesuai dengan statistik</small>
                <div id="iconPreview" class="mt-2"></div>
              </div>
              
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control <?= session()->getFlashdata('errors.deskripsi') ? 'is-invalid' : '' ?>" 
                          id="deskripsi" name="deskripsi" rows="3" 
                          placeholder="Deskripsi singkat tentang statistik ini..."><?= old('deskripsi', $stat['deskripsi']) ?></textarea>
                <?php if (session()->getFlashdata('errors.deskripsi')): ?>
                  <div class="invalid-feedback"><?= session()->getFlashdata('errors.deskripsi') ?></div>
                <?php endif; ?>
                <small class="form-text text-muted">Deskripsi opsional (maksimal 255 karakter)</small>
              </div>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="urutan">Urutan *</label>
                    <input type="number" class="form-control <?= session()->getFlashdata('errors.urutan') ? 'is-invalid' : '' ?>" 
                           id="urutan" name="urutan" value="<?= old('urutan', $stat['urutan']) ?>" min="1" required>
                    <?php if (session()->getFlashdata('errors.urutan')): ?>
                      <div class="invalid-feedback"><?= session()->getFlashdata('errors.urutan') ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Urutan tampilan (1, 2, 3, dst)</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="status">Status *</label>
                    <select class="form-control <?= session()->getFlashdata('errors.status') ? 'is-invalid' : '' ?>" 
                            id="status" name="status" required>
                      <option value="">Pilih Status</option>
                      <option value="aktif" <?= (old('status', $stat['status']) == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                      <option value="nonaktif" <?= (old('status', $stat['status']) == 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                    <?php if (session()->getFlashdata('errors.status')): ?>
                      <div class="invalid-feedback"><?= session()->getFlashdata('errors.status') ?></div>
                    <?php endif; ?>
                    <small class="form-text text-muted">Status tampilan di frontend</small>
                  </div>
                </div>
              </div>
              
              <div class="d-flex justify-content-between">
                <a href="<?= base_url('stats') ?>" class="btn btn-secondary">
                  <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Update Stats
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
  // Character counter for judul
  $('#judul').on('input', function() {
    var maxLength = 255;
    var currentLength = this.value.length;
    var remaining = maxLength - currentLength;
    
    if (remaining < 0) {
      this.value = this.value.substring(0, maxLength);
      remaining = 0;
    }
    
    // Update counter
    var counter = $('#judulCounter');
    if (counter.length === 0) {
      $(this).after('<small id="judulCounter" class="form-text text-muted"></small>');
    }
    $('#judulCounter').text(remaining + ' karakter tersisa');
  });
  
  // Character counter for angka
  $('#angka').on('input', function() {
    var maxLength = 50;
    var currentLength = this.value.length;
    var remaining = maxLength - currentLength;
    
    if (remaining < 0) {
      this.value = this.value.substring(0, maxLength);
      remaining = 0;
    }
    
    // Update counter
    var counter = $('#angkaCounter');
    if (counter.length === 0) {
      $(this).after('<small id="angkaCounter" class="form-text text-muted"></small>');
    }
    $('#angkaCounter').text(remaining + ' karakter tersisa');
  });
  
  // Character counter for deskripsi
  $('#deskripsi').on('input', function() {
    var maxLength = 255;
    var currentLength = this.value.length;
    var remaining = maxLength - currentLength;
    
    if (remaining < 0) {
      this.value = this.value.substring(0, maxLength);
      remaining = 0;
    }
    
    // Update counter
    var counter = $('#deskripsiCounter');
    if (counter.length === 0) {
      $(this).after('<small id="deskripsiCounter" class="form-text text-muted"></small>');
    }
    $('#deskripsiCounter').text(remaining + ' karakter tersisa');
  });
  
  // Icon preview
  $('#ikon').change(function() {
    var selectedIcon = $(this).val();
    if (selectedIcon) {
      $('#iconPreview').html('<i class="' + selectedIcon + ' fa-3x text-primary"></i>');
    } else {
      $('#iconPreview').html('');
    }
  });
  
  // Show initial icon preview
  var initialIcon = $('#ikon').val();
  if (initialIcon) {
    $('#iconPreview').html('<i class="' + initialIcon + ' fa-3x text-primary"></i>');
  }
  
  // Form validation
  $('#statsForm').submit(function(e) {
    var judul = $('#judul').val().trim();
    var angka = $('#angka').val().trim();
    var ikon = $('#ikon').val();
    var urutan = $('#urutan').val();
    var status = $('#status').val();
    
    if (!judul || judul.length < 3) {
      Swal.fire('Error', 'Judul harus diisi minimal 3 karakter.', 'error');
      e.preventDefault();
      return false;
    }
    
    if (!angka) {
      Swal.fire('Error', 'Angka harus diisi.', 'error');
      e.preventDefault();
      return false;
    }
    
    if (!ikon) {
      Swal.fire('Error', 'Ikon harus dipilih.', 'error');
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
      text: 'Yakin ingin memperbarui Quick Stats ini?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Update',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (!result.isConfirmed) {
        e.preventDefault();
        return false;
      }
    });
  });
});
</script> 