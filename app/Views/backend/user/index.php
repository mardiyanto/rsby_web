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
            <h3 class="mb-0">Daftar User</h3>
            <?php if (session('role') === 'admin'): ?>
              <a href="<?= base_url('user/create') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah User</a>
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
              <table class="table table-bordered align-items-center table-flush" id="tabel-user">
                <thead class="thead-light">
                  <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terakhir Login</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($users)): ?>
                    <?php $no=1; foreach ($users as $row): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td>
                        <div class="d-flex align-items-center">
                          <div class="avatar avatar-sm rounded-circle bg-gradient-primary mr-3">
                            <i class="fas fa-user text-white"></i>
                          </div>
                          <div>
                            <span class="font-weight-bold"><?= esc($row['username']) ?></span>
                            <?php if ($row['id'] == session('user_id')): ?>
                              <span class="badge badge-info ml-2">Anda</span>
                            <?php endif; ?>
                          </div>
                        </div>
                      </td>
                      <td><?= esc($row['nama']) ?></td>
                      <td>
                        <?php if ($row['role'] == 'admin'): ?>
                          <span class="badge badge-danger">
                            <i class="fas fa-crown"></i> Admin
                          </span>
                        <?php else: ?>
                          <span class="badge badge-info">
                            <i class="fas fa-user"></i> User
                          </span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($row['id'] == session('user_id')): ?>
                          <span class="badge badge-success">
                            <i class="fas fa-circle"></i> Online
                          </span>
                        <?php else: ?>
                          <span class="badge badge-secondary">
                            <i class="fas fa-circle"></i> Offline
                          </span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if (isset($row['last_login'])): ?>
                          <?= date('d/m/Y H:i', strtotime($row['last_login'])) ?>
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if (session('role') === 'admin'): ?>
                          <?php if ($row['id'] != session('user_id')): ?>
                            <a href="<?= base_url('user/edit/'.$row['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                              <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="<?= base_url('user/delete/'.$row['id']) ?>" class="btn btn-sm btn-danger btn-hapus-user" title="Hapus">
                              <i class="fas fa-trash"></i>
                            </a>
                          <?php else: ?>
                            <a href="<?= base_url('user/profile') ?>" class="btn btn-sm btn-info" title="Profil Saya">
                              <i class="fas fa-user-edit"></i>
                            </a>
                            <a href="<?= base_url('user/change-password') ?>" class="btn btn-sm btn-secondary" title="Ubah Password">
                              <i class="fas fa-key"></i>
                            </a>
                          <?php endif; ?>
                        <?php else: ?>
                          <a href="<?= base_url('user/profile') ?>" class="btn btn-sm btn-info" title="Profil Saya">
                            <i class="fas fa-user-edit"></i>
                          </a>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="7" class="text-center">Tidak ada data user.</td></tr>
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
  $('#tabel-user').DataTable({
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

// SweetAlert2 konfirmasi hapus user
$(document).on('click', '.btn-hapus-user', function(e) {
  e.preventDefault();
  var url = $(this).attr('href');
  Swal.fire({
    title: 'Yakin hapus user ini?',
    text: 'Data user yang dihapus tidak bisa dikembalikan!',
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