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
            <h3 class="mb-0"><?= $title ?></h3>
            <a href="<?= base_url('galeri/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Galeri</a>
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
              <table class="table table-bordered align-items-center table-flush" id="tabel-galeri">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Upload</th>
                    <th>Created At</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($galeri)): ?>
                    <?php $no=1; foreach ($galeri as $item): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td>
                        <?php if ($item['nama_file']): ?>
                          <img src="<?= base_url('uploads/galeri/'.$item['nama_file']) ?>" alt="Gambar" width="60" class="img-thumbnail">
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      </td>
                      <td><?= esc($item['judul']) ?></td>
                      <td>
                        <?php 
                        $deskripsi = $item['deskripsi'];
                        echo strlen($deskripsi) > 100 ? substr($deskripsi, 0, 100) . '...' : $deskripsi;
                        ?>
                      </td>
                      <td><?= date('d/m/Y', strtotime($item['tanggal_upload'])) ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></td>
                      <td>
                        <a href="<?= base_url('uploads/galeri/' . $item['nama_file']) ?>" 
                           target="_blank" 
                           class="btn btn-sm btn-info" 
                           title="Lihat Gambar">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= base_url('galeri/download/' . $item['id_galeri']) ?>" 
                           class="btn btn-sm btn-success" 
                           title="Download">
                          <i class="fas fa-download"></i>
                        </a>
                        <a href="<?= base_url('galeri/edit/'.$item['id_galeri']) ?>" class="btn btn-sm btn-warning" title="Edit">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="<?= base_url('galeri/delete/'.$item['id_galeri']) ?>" class="btn btn-sm btn-danger btn-hapus-galeri" title="Hapus">
                          <i class="fas fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="7" class="text-center">Tidak ada data galeri.</td></tr>
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

<!-- Form untuk delete -->
<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<script>
// Notifikasi SweetAlert2 dari flashdata
<?php if (session('success')): ?>
Swal.fire({
  icon: 'success',
  title: 'Sukses',
  text: '<?= session('success') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>
<?php if (session('error')): ?>
Swal.fire({
  icon: 'error',
  title: 'Gagal',
  text: '<?= session('error') ?>',
  timer: 2000,
  showConfirmButton: false
});
<?php endif; ?>

$(document).ready(function() {
  $('#tabel-galeri').DataTable({
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

// SweetAlert2 konfirmasi hapus galeri
$(document).on('click', '.btn-hapus-galeri', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title: 'Yakin hapus galeri ini?',
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
</script> 