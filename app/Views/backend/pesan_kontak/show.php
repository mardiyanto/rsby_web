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
            <h3 class="mb-0">Detail Pesan Kontak</h3>
            <div class="btn-group">
              <a href="<?= base_url('pesan-kontak') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
              <?php if ($pesan['status'] != 'dibalas'): ?>
                <a href="<?= base_url('pesan-kontak/reply/' . $pesan['id']) ?>" class="btn btn-sm btn-success">
                  <i class="fas fa-reply"></i> Balas
                </a>
              <?php endif; ?>
              <a href="<?= base_url('pesan-kontak/delete/' . $pesan['id']) ?>" 
                 class="btn btn-sm btn-danger"
                 onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                <i class="fas fa-trash"></i> Hapus
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-8">
                <!-- Message Details -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Pesan</h6>
                  </div>
                  <div class="card-body">
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <strong>Nama Pengirim:</strong><br>
                        <?= esc($pesan['nama']) ?>
                      </div>
                      <div class="col-md-6">
                        <strong>Email:</strong><br>
                        <a href="mailto:<?= esc($pesan['email']) ?>"><?= esc($pesan['email']) ?></a>
                      </div>
                    </div>
                    
                    <?php if ($pesan['telepon']): ?>
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <strong>Telepon:</strong><br>
                        <a href="tel:<?= esc($pesan['telepon']) ?>"><?= esc($pesan['telepon']) ?></a>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <strong>Subjek:</strong><br>
                        <span class="badge badge-secondary"><?= esc($pesan['subjek']) ?></span>
                      </div>
                      <div class="col-md-6">
                        <strong>Status:</strong><br>
                        <?php
                        $statusClass = '';
                        $statusText = '';
                        switch ($pesan['status']) {
                            case 'baru':
                                $statusClass = 'badge-warning';
                                $statusText = 'Baru';
                                break;
                            case 'dibaca':
                                $statusClass = 'badge-info';
                                $statusText = 'Dibaca';
                                break;
                            case 'dibalas':
                                $statusClass = 'badge-success';
                                $statusText = 'Dibalas';
                                break;
                        }
                        ?>
                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                      </div>
                    </div>
                    
                    <div class="mb-3">
                      <strong>Pesan:</strong><br>
                      <div class="border rounded p-3 bg-light">
                        <?= nl2br(esc($pesan['pesan'])) ?>
                      </div>
                    </div>
                    
                    <?php if ($pesan['catatan_admin']): ?>
                    <div class="mb-3">
                      <strong>Catatan Admin:</strong><br>
                      <div class="border rounded p-3 bg-warning bg-opacity-10">
                        <?= nl2br(esc($pesan['catatan_admin'])) ?>
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              
              <div class="col-lg-4">
                <!-- Message Timeline -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Timeline</h6>
                  </div>
                  <div class="card-body">
                    <div class="timeline">
                      <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                          <h6 class="timeline-title">Pesan Dikirim</h6>
                          <p class="timeline-text"><?= date('d/m/Y H:i', strtotime($pesan['tanggal_kirim'])) ?></p>
                        </div>
                      </div>
                      
                      <?php if ($pesan['tanggal_dibaca']): ?>
                      <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                          <h6 class="timeline-title">Pesan Dibaca</h6>
                          <p class="timeline-text"><?= date('d/m/Y H:i', strtotime($pesan['tanggal_dibaca'])) ?></p>
                        </div>
                      </div>
                      <?php endif; ?>
                      
                      <?php if ($pesan['tanggal_dibalas']): ?>
                      <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                          <h6 class="timeline-title">Pesan Dibalas</h6>
                          <p class="timeline-text"><?= date('d/m/Y H:i', strtotime($pesan['tanggal_dibalas'])) ?></p>
                        </div>
                      </div>
                      <?php endif; ?>
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
                      <?php if ($pesan['status'] == 'baru'): ?>
                        <a href="<?= base_url('pesan-kontak/mark-as-read/' . $pesan['id']) ?>" 
                           class="btn btn-warning btn-sm"
                           onclick="return confirm('Tandai pesan ini sebagai dibaca?')">
                          <i class="fas fa-eye"></i> Tandai Dibaca
                        </a>
                      <?php endif; ?>
                      
                      <?php if ($pesan['status'] != 'dibalas'): ?>
                        <a href="<?= base_url('pesan-kontak/reply/' . $pesan['id']) ?>" 
                           class="btn btn-success btn-sm">
                          <i class="fas fa-reply"></i> Balas Pesan
                        </a>
                      <?php endif; ?>
                      
                      <a href="mailto:<?= esc($pesan['email']) ?>?subject=Re: <?= urlencode($pesan['subjek']) ?>" 
                         class="btn btn-info btn-sm">
                        <i class="fas fa-envelope"></i> Kirim Email
                      </a>
                      
                      <?php if ($pesan['telepon']): ?>
                        <a href="tel:<?= esc($pesan['telepon']) ?>" 
                           class="btn btn-secondary btn-sm">
                          <i class="fas fa-phone"></i> Telepon
                        </a>
                      <?php endif; ?>
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

<style>
.timeline {
  position: relative;
  padding-left: 30px;
}

.timeline::before {
  content: '';
  position: absolute;
  left: 15px;
  top: 0;
  bottom: 0;
  width: 2px;
  background: #e3e6f0;
}

.timeline-item {
  position: relative;
  margin-bottom: 20px;
}

.timeline-marker {
  position: absolute;
  left: -22px;
  top: 0;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: 2px solid #fff;
  box-shadow: 0 0 0 2px #e3e6f0;
}

.timeline-content {
  background: #f8f9fc;
  padding: 15px;
  border-radius: 5px;
  border-left: 3px solid #4e73df;
}

.timeline-title {
  margin: 0 0 5px 0;
  font-size: 14px;
  font-weight: 600;
  color: #5a5c69;
}

.timeline-text {
  margin: 0;
  font-size: 12px;
  color: #858796;
}

.d-grid.gap-2 {
  display: grid;
  gap: 0.5rem;
}
</style> 