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
            <div class="row align-items-center">
              <div class="col">
                <h3 class="mb-0">Edit Layanan Checkerboard Carousel</h3>
              </div>
              <div class="col text-right">
                <a href="<?= base_url('checkerboard-carousel') ?>" class="btn btn-secondary">
                  <i class="fas fa-arrow-left"></i> Kembali
                </a>
              </div>
            </div>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>
            
            <form action="<?= base_url('checkerboard-carousel/update/'.$layanan['id']) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama_layanan">Nama Layanan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" value="<?= old('nama_layanan', $layanan['nama_layanan']) ?>" required>
                    <small class="form-text text-muted">Contoh: Poli Jantung, Laboratorium, dll.</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="ikon">Ikon Font Awesome <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="ikon" name="ikon" value="<?= old('ikon', $layanan['ikon']) ?>" placeholder="fas fa-heartbeat" required>
                      <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#iconModal">
                          <i class="fas fa-search"></i> Pilih Ikon
                        </button>
                      </div>
                    </div>
                    <small class="form-text text-muted">Contoh: fas fa-heartbeat, fas fa-tooth, dll.</small>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="deskripsi">Deskripsi <span class="text-danger">*</span></label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= old('deskripsi', $layanan['deskripsi']) ?></textarea>
                <small class="form-text text-muted">Deskripsi singkat tentang layanan (maksimal 200 karakter).</small>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="link">Link (Opsional)</label>
                    <input type="url" class="form-control" id="link" name="link" value="<?= old('link', $layanan['link']) ?>" placeholder="https://example.com">
                    <small class="form-text text-muted">Link ke halaman detail layanan atau eksternal.</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="urutan">Urutan <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="urutan" name="urutan" value="<?= old('urutan', $layanan['urutan']) ?>" min="1" required>
                    <small class="form-text text-muted">Urutan tampilan dalam carousel.</small>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select class="form-control" id="status" name="status" required>
                      <option value="aktif" <?= old('status', $layanan['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                      <option value="nonaktif" <?= old('status', $layanan['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Preview Ikon</label>
                <div class="text-center p-3 border rounded">
                  <i id="preview-icon" class="<?= esc($layanan['ikon']) ?> fa-3x text-primary"></i>
                  <p class="mt-2 mb-0" id="preview-text"><?= esc($layanan['nama_layanan']) ?></p>
                </div>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Update Layanan
                </button>
                <a href="<?= base_url('checkerboard-carousel') ?>" class="btn btn-secondary">
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

<!-- Modal Pilih Ikon -->
<div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="iconModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="iconModalLabel">Pilih Ikon Font Awesome</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" class="form-control" id="searchIcon" placeholder="Cari ikon...">
        </div>
        <div class="row" id="iconList">
          <!-- Ikon akan dimuat di sini -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?= $this->include('backend/jsadmin') ?>

<script>
// Daftar ikon Font Awesome yang umum digunakan
const icons = [
  'fas fa-heartbeat', 'fas fa-tooth', 'fas fa-baby', 'fas fa-user-md', 'fas fa-flask',
  'fas fa-x-ray', 'fas fa-pills', 'fas fa-ambulance', 'fas fa-bed', 'fas fa-laptop-medical',
  'fas fa-syringe', 'fas fa-eye', 'fas fa-stethoscope', 'fas fa-brain', 'fas fa-lungs',
  'fas fa-bone', 'fas fa-dna', 'fas fa-microscope', 'fas fa-thermometer-half', 'fas fa-band-aid',
  'fas fa-first-aid', 'fas fa-hospital', 'fas fa-clinic-medical', 'fas fa-user-nurse', 'fas fa-procedures',
  'fas fa-heart', 'fas fa-lungs-virus', 'fas fa-virus', 'fas fa-shield-virus', 'fas fa-hand-holding-medical',
  'fas fa-notes-medical', 'fas fa-file-medical', 'fas fa-prescription-bottle-medical', 'fas fa-capsules',
  'fas fa-tablets', 'fas fa-tint', 'fas fa-tint-slash', 'fas fa-allergies', 'fas fa-bacteria',
  'fas fa-biohazard', 'fas fa-radiation', 'fas fa-radiation-alt', 'fas fa-vial', 'fas fa-tube',
  'fas fa-tint-droplet', 'fas fa-droplet', 'fas fa-droplet-slash', 'fas fa-temperature-high',
  'fas fa-temperature-low', 'fas fa-weight-scale', 'fas fa-ruler', 'fas fa-ruler-vertical',
  'fas fa-ruler-horizontal', 'fas fa-ruler-combined', 'fas fa-ruler-triangle', 'fas fa-ruler-vertical'
];

// Load ikon ke modal
function loadIcons() {
  const iconList = document.getElementById('iconList');
  iconList.innerHTML = '';
  
  icons.forEach(icon => {
    const col = document.createElement('div');
    col.className = 'col-md-3 col-sm-4 col-6 mb-3';
    col.innerHTML = `
      <div class="text-center p-2 border rounded cursor-pointer icon-item" data-icon="${icon}">
        <i class="${icon} fa-2x text-primary"></i>
        <div class="small mt-1">${icon}</div>
      </div>
    `;
    iconList.appendChild(col);
  });
}

// Search ikon
document.getElementById('searchIcon').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const iconItems = document.querySelectorAll('.icon-item');
  
  iconItems.forEach(item => {
    const iconClass = item.getAttribute('data-icon').toLowerCase();
    if (iconClass.includes(searchTerm)) {
      item.style.display = 'block';
    } else {
      item.style.display = 'none';
    }
  });
});

// Pilih ikon
document.addEventListener('click', function(e) {
  if (e.target.closest('.icon-item')) {
    const iconItem = e.target.closest('.icon-item');
    const iconClass = iconItem.getAttribute('data-icon');
    
    document.getElementById('ikon').value = iconClass;
    updatePreview();
    
    $('#iconModal').modal('hide');
  }
});

// Update preview
function updatePreview() {
  const iconInput = document.getElementById('ikon').value;
  const namaInput = document.getElementById('nama_layanan').value;
  
  const previewIcon = document.getElementById('preview-icon');
  const previewText = document.getElementById('preview-text');
  
  if (iconInput) {
    previewIcon.className = iconInput + ' fa-3x text-primary';
  }
  
  if (namaInput) {
    previewText.textContent = namaInput;
  }
}

// Event listeners untuk update preview
document.getElementById('ikon').addEventListener('input', updatePreview);
document.getElementById('nama_layanan').addEventListener('input', updatePreview);

// Load ikon saat modal dibuka
$('#iconModal').on('shown.bs.modal', function () {
  loadIcons();
});

// Inisialisasi preview
updatePreview();
</script>

<style>
.cursor-pointer {
  cursor: pointer;
}

.icon-item:hover {
  background-color: #f8f9fa;
  border-color: #007bff !important;
}

.icon-item {
  transition: all 0.2s ease;
}
</style> 