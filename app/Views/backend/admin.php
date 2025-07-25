<?= $this->include('backend/headeradmin') ?>
  <div class="main-content">
    <!-- Navbar -->
   <?= $this->include('backend/menuatasadmin') ?>
    <!-- End Navbar -->
    <!-- Header -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <div class="header-body">
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah User</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_user ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Berita</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_berita ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fas fa-newspaper"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Download</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_download ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-download"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Jumlah Slide</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_slide ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-images"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Card kategori dan halaman -->
          <div class="row mt-4">
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Kategori Berita</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_kategori ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-secondary text-white rounded-circle shadow">
                        <i class="fas fa-tags"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Kategori Download</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_kategori_download ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                        <i class="fas fa-folder"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Halaman</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_halaman ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-file-alt"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Galeri</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_galeri ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                        <i class="fas fa-photo-video"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Pesan Kontak</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_pesan ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-envelope"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2">
                      <i class="fas fa-arrow-up"></i> <?= $pesan_statistics['unread'] ?? 0 ?>
                    </span>
                    <span class="text-nowrap">Pesan baru</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">FAQ</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_faq ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-question-circle"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2">
                      <i class="fas fa-arrow-up"></i> Aktif
                    </span>
                    <span class="text-nowrap">Pertanyaan umum</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Quick Stats</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $jumlah_stats ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2">
                      <i class="fas fa-arrow-up"></i> Aktif
                    </span>
                    <span class="text-nowrap">Statistik frontend</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-6 mb-5 mb-xl-0">
          <div class="card bg-gradient-default shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                  <h2 class="text-white mb-0">Grafik Berita per Bulan</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-berita" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 mb-5 mb-xl-0">
          <div class="card bg-gradient-default shadow">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                  <h2 class="text-white mb-0">Grafik Download per Bulan</h2>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-download" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Berita Terbaru dan Download Populer -->
      <div class="row mt-4">
        <div class="col-xl-6">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Berita Terbaru</h3>
                </div>
                <div class="col text-right">
                  <a href="<?= base_url('berita') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Judul</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($berita_terbaru)): ?>
                    <?php foreach ($berita_terbaru as $berita): ?>
                    <tr>
                      <td>
                        <div class="media align-items-center">
                          <div class="media-body">
                            <span class="name mb-0 text-sm"><?= esc($berita['judul']) ?></span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-info"><?= esc($berita['nama_kategori']) ?></span>
                      </td>
                      <td>
                        <span class="text-muted"><?= date('d/m/Y', strtotime($berita['created_at'])) ?></span>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center text-muted">Tidak ada berita terbaru</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Download Terpopuler</h3>
                </div>
                <div class="col text-right">
                  <a href="<?= base_url('download') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Judul</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Hits</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($download_populer)): ?>
                    <?php foreach ($download_populer as $download): ?>
                    <tr>
                      <td>
                        <div class="media align-items-center">
                          <div class="media-body">
                            <span class="name mb-0 text-sm"><?= esc($download['judul']) ?></span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-warning"><?= esc($download['nama_kategori_download']) ?></span>
                      </td>
                      <td>
                        <span class="badge badge-success"><?= $download['hits'] ?> kali</span>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="3" class="text-center text-muted">Tidak ada download populer</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Galeri Terbaru -->
      <div class="row mt-4">
        <div class="col-xl-12">
          <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Galeri Terbaru</h3>
                </div>
                <div class="col text-right">
                  <a href="<?= base_url('galeri') ?>" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <?php if (!empty($galeri_terbaru)): ?>
                  <?php foreach ($galeri_terbaru as $galeri): ?>
                  <div class="col-md-3 mb-3">
                    <div class="card">
                      <img src="<?= base_url('uploads/galeri/'.$galeri['gambar']) ?>" class="card-img-top" alt="Galeri" style="height: 150px; object-fit: cover;">
                      <div class="card-body p-2">
                        <h6 class="card-title mb-0"><?= esc($galeri['judul']) ?></h6>
                        <small class="text-muted"><?= date('d/m/Y', strtotime($galeri['created_at'])) ?></small>
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                <?php else: ?>
                  <div class="col-12 text-center text-muted">
                    <i class="fas fa-images fa-3x mb-3"></i>
                    <p>Tidak ada galeri terbaru</p>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
    <?= $this->include('backend/footeradmin') ?>
    </div>
  </div>
  <?= $this->include('backend/jsadmin') ?>
<script>
$(function() {
  // Chart Berita
  if (window.Chart && $('#chart-berita').length) {
    var ctx = document.getElementById('chart-berita').getContext('2d');
    var beritaChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= $grafik_berita_labels ?>,
        datasets: [{
          label: 'Jumlah Berita',
          data: <?= $grafik_berita_data ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.5)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          yAxes: [{
            gridLines: { lineWidth: 1, color: '#dfe2e6', zeroLineColor: '#dfe2e6' },
            ticks: { callback: function(value) { if (!(value % 10)) { return value } } }
          }]
        },
        tooltips: {
          callbacks: {
            label: function(item, data) {
              var label = data.datasets[item.datasetIndex].label || '';
              var yLabel = item.yLabel;
              var content = '';
              if (data.datasets.length > 1) {
                content += '<span class="popover-body-label mr-auto">' + label + '</span>';
              }
              content += '<span class="popover-body-value">' + yLabel + '</span>';
              return content;
            }
          }
        }
      }
    });
  }

  // Chart Download
  if (window.Chart && $('#chart-download').length) {
    var ctx = document.getElementById('chart-download').getContext('2d');
    var downloadChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= $grafik_download_labels ?>,
        datasets: [{
          label: 'Jumlah Download',
          data: <?= $grafik_download_data ?>,
          backgroundColor: 'rgba(255, 206, 86, 0.5)',
          borderColor: 'rgba(255, 206, 86, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          yAxes: [{
            gridLines: { lineWidth: 1, color: '#dfe2e6', zeroLineColor: '#dfe2e6' },
            ticks: { callback: function(value) { if (!(value % 10)) { return value } } }
          }]
        },
        tooltips: {
          callbacks: {
            label: function(item, data) {
              var label = data.datasets[item.datasetIndex].label || '';
              var yLabel = item.yLabel;
              var content = '';
              if (data.datasets.length > 1) {
                content += '<span class="popover-body-label mr-auto">' + label + '</span>';
              }
              content += '<span class="popover-body-value">' + yLabel + '</span>';
              return content;
            }
          }
        }
      }
    });
  }
});
</script>