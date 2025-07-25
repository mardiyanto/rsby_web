<?= $this->include('backend/headeradmin') ?>
<div class="main-content">
  <?= $this->include('backend/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body"></div>
    </div>
  </div>
  <div class="container-fluid mt--7">
    <!-- Statistics Cards -->
    <div class="row mb-4">
      <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Total Layanan</h5>
                <span class="h2 font-weight-bold mb-0"><?= $statistics['total'] ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                  <i class="fas fa-list"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Aktif</h5>
                <span class="h2 font-weight-bold mb-0"><?= $statistics['aktif'] ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                  <i class="fas fa-check"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Nonaktif</h5>
                <span class="h2 font-weight-bold mb-0"><?= $statistics['nonaktif'] ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                  <i class="fas fa-times"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-6">
        <div class="card card-stats mb-4 mb-xl-0">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <h5 class="card-title text-uppercase text-muted mb-0">Slide</h5>
                <span class="h2 font-weight-bold mb-0"><?= ceil($statistics['aktif'] / 4) ?></span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                  <i class="fas fa-images"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-12">
        <div class="card shadow">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Daftar Layanan Checkerboard Carousel</h3>
            <?php if (session('role') === 'admin'): ?>
              <a href="<?= base_url('checkerboard-carousel/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Layanan</a>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
              <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
              </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>
            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush" id="tabel-layanan">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Ikon</th>
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Slug</th>
                    <th>Link</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($layanan)): ?>
                    <?php $no=1; foreach ($layanan as $row): ?>
                    <tr data-id="<?= $row['id'] ?>">
                      <td><?= $no++ ?></td>
                      <td>
                        <div class="text-center">
                          <i class="<?= esc($row['ikon']) ?> fa-2x text-primary"></i>
                        </div>
                      </td>
                      <td><?= esc($row['nama_layanan']) ?></td>
                      <td><?= esc(substr($row['deskripsi'], 0, 80)) ?>...</td>
                      <td>
                        <code><?= esc($row['slug']) ?></code>
                      </td>
                      <td>
                        <?php if ($row['link']): ?>
                          <a href="<?= esc($row['link']) ?>" target="_blank" class="text-primary">
                            <i class="fas fa-external-link-alt"></i> Link
                          </a>
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="badge badge-info"><?= $row['urutan'] ?></span>
                      </td>
                      <td>
                        <?php if ($row['status'] == 'aktif'): ?>
                          <span class="badge badge-success">Aktif</span>
                        <?php else: ?>
                          <span class="badge badge-secondary">Nonaktif</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if (session('role') === 'admin'): ?>
                          <a href="<?= base_url('checkerboard-carousel/edit/'.$row['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                            <i class="fas fa-pencil-alt"></i>
                          </a>
                          <a href="<?= base_url('checkerboard-carousel/toggle-status/'.$row['id']) ?>" class="btn btn-sm btn-info btn-toggle-status" title="Toggle Status">
                            <i class="fas fa-toggle-on"></i>
                          </a>
                          <a href="<?= base_url('checkerboard-carousel/delete/'.$row['id']) ?>" class="btn btn-sm btn-danger btn-hapus-layanan" title="Hapus">
                            <i class="fas fa-trash"></i>
                          </a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="9" class="text-center">Tidak ada data layanan.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
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
<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.css') ?>">
<!-- DataTables JS -->
<script src="<?= base_url('argon/assets/js/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') ?>"></script>

<script>
// Notifikasi SweetAlert2 dari flashdata
<?php if (session()->getFlashdata('success')): ?>
Swal.fire({
  icon: 'success',
  title: 'Sukses',
  text: '<?= session('success') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>
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
  $('#tabel-layanan').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
    },
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50, 100],
    ordering: true,
    searching: true,
    stateSave: true,
    responsive: true,
    autoWidth: false,
    scrollX: true,
    scrollY: 300,
    scrollCollapse: true,
    paging: true,
    info: true,
    language: {
      paginate: {
        previous: "<i class='fas fa-angle-left'></i>",
        next: "<i class='fas fa-angle-right'></i>"
      }
    }
  });
});

// SweetAlert2 konfirmasi hapus layanan
$(document).on('click', '.btn-hapus-layanan', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title: 'Yakin hapus layanan ini?',
    text: 'Data yang dihapus tidak bisa dikembalikan!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
});

// SweetAlert2 konfirmasi toggle status layanan
$(document).on('click', '.btn-toggle-status', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title: 'Ubah Status Layanan?',
    text: 'Apakah Anda yakin ingin mengubah status layanan ini?',
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Ya, ubah!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = url;
    }
  });
});
</script> 