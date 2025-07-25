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
            <h3 class="mb-0">Balas Pesan Kontak</h3>
            <div class="btn-group">
              <a href="<?= base_url('pesan-kontak/show/' . $pesan['id']) ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8">
                <!-- Reply Form -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Balasan</h6>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="<?= base_url('pesan-kontak/mark-as-replied/' . $pesan['id']) ?>" id="replyForm">
                      <div class="form-group">
                        <label for="catatan_admin">Catatan Admin / Balasan *</label>
                        <textarea class="form-control" id="catatan_admin" name="catatan_admin" rows="8" 
                                  placeholder="Tulis catatan admin atau balasan untuk pesan ini..." required></textarea>
                        <small class="form-text text-muted">Catatan ini akan disimpan sebagai record balasan admin.</small>
                      </div>
                      
                      <div class="form-group">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="send_email" name="send_email">
                          <label class="custom-control-label" for="send_email">
                            Kirim balasan via email ke <?= esc($pesan['email']) ?>
                          </label>
                        </div>
                      </div>
                      
                      <div class="d-flex justify-content-between">
                        <a href="<?= base_url('pesan-kontak/show/' . $pesan['id']) ?>" class="btn btn-secondary">
                          <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                          <i class="fas fa-reply"></i> Tandai Dibalas
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-4">
                <!-- Original Message -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pesan Asli</h6>
                  </div>
                  <div class="card-body">
                    <div class="mb-3">
                      <strong>Dari:</strong><br>
                      <?= esc($pesan['nama']) ?> (<?= esc($pesan['email']) ?>)
                      <?php if ($pesan['telepon']): ?>
                        <br><small class="text-muted"><?= esc($pesan['telepon']) ?></small>
                      <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                      <strong>Subjek:</strong><br>
                      <span class="badge badge-secondary"><?= esc($pesan['subjek']) ?></span>
                    </div>
                    
                    <div class="mb-3">
                      <strong>Tanggal Kirim:</strong><br>
                      <?= date('d/m/Y H:i', strtotime($pesan['tanggal_kirim'])) ?>
                    </div>
                    
                    <div class="mb-3">
                      <strong>Pesan:</strong><br>
                      <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                        <?= nl2br(esc($pesan['pesan'])) ?>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="card shadow">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                  </div>
                  <div class="card-body">
                    <div class="d-grid gap-2">
                      <a href="mailto:<?= esc($pesan['email']) ?>?subject=Re: <?= urlencode($pesan['subjek']) ?>" 
                         class="btn btn-info btn-sm">
                        <i class="fas fa-envelope"></i> Buka Email Client
                      </a>
                      
                      <?php if ($pesan['telepon']): ?>
                        <a href="tel:<?= esc($pesan['telepon']) ?>" 
                           class="btn btn-secondary btn-sm">
                          <i class="fas fa-phone"></i> Telepon
                        </a>
                      <?php endif; ?>
                      
                      <button type="button" class="btn btn-outline-primary btn-sm" onclick="loadTemplate()">
                        <i class="fas fa-file-alt"></i> Load Template
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
  // Form validation
  $('#replyForm').submit(function(e) {
    var catatan = $('#catatan_admin').val().trim();
    
    if (!catatan) {
      Swal.fire('Error', 'Catatan admin harus diisi.', 'error');
      e.preventDefault();
      return false;
    }
    
    if (catatan.length < 10) {
      Swal.fire('Error', 'Catatan admin minimal 10 karakter.', 'error');
      e.preventDefault();
      return false;
    }
    
    // Confirm before submit
    Swal.fire({
      title: 'Konfirmasi',
      text: 'Yakin ingin menandai pesan ini sebagai dibalas?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#28a745',
      cancelButtonColor: '#6c757d',
      confirmButtonText: 'Ya, Tandai Dibalas',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (!result.isConfirmed) {
        e.preventDefault();
        return false;
      }
    });
  });
  
  // Character counter
  $('#catatan_admin').on('input', function() {
    var maxLength = 2000;
    var currentLength = this.value.length;
    var remaining = maxLength - currentLength;
    
    if (remaining < 0) {
      this.value = this.value.substring(0, maxLength);
      remaining = 0;
    }
    
    // Update counter if exists
    var counter = $('#charCounter');
    if (counter.length === 0) {
      $(this).after('<small id="charCounter" class="form-text text-muted"></small>');
    }
    $('#charCounter').text(remaining + ' karakter tersisa');
  });
});

function loadTemplate() {
  var templates = {
    'informasi_umum': 'Terima kasih telah menghubungi Biddokkes POLRI.\n\nKami telah menerima pertanyaan Anda dan akan segera memberikan informasi yang diperlukan.\n\nUntuk informasi lebih lanjut, silakan hubungi kami di:\nTelepon: (021) 721-1234\nEmail: info@biddokkes.polri.go.id\n\nHormat kami,\nTim Layanan Biddokkes POLRI',
    
    'layanan_kesehatan': 'Terima kasih atas pertanyaan Anda mengenai layanan kesehatan di Biddokkes POLRI.\n\nKami menyediakan berbagai layanan kesehatan termasuk:\n- Pemeriksaan kesehatan umum\n- Konsultasi dokter spesialis\n- Pemeriksaan laboratorium\n- Layanan farmasi\n\nUntuk jadwal dan pendaftaran, silakan hubungi kami di:\nTelepon: (021) 721-1234\nEmail: info@biddokkes.polri.go.id\n\nHormat kami,\nTim Layanan Kesehatan Biddokkes POLRI',
    
    'pendaftaran': 'Terima kasih atas minat Anda untuk mendaftar layanan di Biddokkes POLRI.\n\nUntuk proses pendaftaran, silakan:\n1. Siapkan dokumen yang diperlukan\n2. Hubungi kami untuk konfirmasi jadwal\n3. Datang ke kantor kami sesuai jadwal yang ditentukan\n\nInformasi pendaftaran:\nTelepon: (021) 721-1234\nEmail: pendaftaran@biddokkes.polri.go.id\n\nHormat kami,\nTim Pendaftaran Biddokkes POLRI',
    
    'keluhan': 'Terima kasih telah menyampaikan keluhan Anda kepada Biddokkes POLRI.\n\nKami sangat menyesalkan ketidaknyamanan yang Anda alami dan akan segera menindaklanjuti keluhan tersebut.\n\nTim kami akan menghubungi Anda dalam waktu 1-2 hari kerja untuk memberikan penjelasan dan solusi.\n\nUntuk informasi lebih lanjut:\nTelepon: (021) 721-1234\nEmail: keluhan@biddokkes.polri.go.id\n\nHormat kami,\nTim Penanganan Keluhan Biddokkes POLRI',
    
    'saran': 'Terima kasih atas saran yang Anda berikan kepada Biddokkes POLRI.\n\nSaran Anda sangat berharga bagi kami untuk meningkatkan kualitas pelayanan.\n\nKami akan mempertimbangkan saran tersebut dan mengimplementasikannya sesuai dengan kebijakan dan prosedur yang berlaku.\n\nUntuk informasi lebih lanjut:\nTelepon: (021) 721-1234\nEmail: saran@biddokkes.polri.go.id\n\nHormat kami,\nTim Pengembangan Biddokkes POLRI'
  };
  
  var subjek = '<?= strtolower($pesan['subjek']) ?>';
  var template = '';
  
  if (subjek.includes('informasi')) {
    template = templates.informasi_umum;
  } else if (subjek.includes('layanan') || subjek.includes('kesehatan')) {
    template = templates.layanan_kesehatan;
  } else if (subjek.includes('pendaftaran')) {
    template = templates.pendaftaran;
  } else if (subjek.includes('keluhan')) {
    template = templates.keluhan;
  } else if (subjek.includes('saran')) {
    template = templates.saran;
  } else {
    template = templates.informasi_umum;
  }
  
  $('#catatan_admin').val(template);
  $('#catatan_admin').trigger('input');
  
  Swal.fire({
    icon: 'success',
    title: 'Template Loaded',
    text: 'Template balasan telah dimuat berdasarkan subjek pesan.',
    timer: 2000,
    showConfirmButton: false
  });
}
</script>

<style>
.d-grid.gap-2 {
  display: grid;
  gap: 0.5rem;
}
</style> 