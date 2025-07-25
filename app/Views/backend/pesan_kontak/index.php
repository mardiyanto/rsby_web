<?= $this->include('backend/headeradmin') ?>
<div class="main-content">
  <?= $this->include('backend/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row">
          <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Total Pesan</h5>
                    <span class="h2 font-weight-bold mb-0"><?= $statistics['total'] ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                      <i class="fas fa-envelope"></i>
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
                    <h5 class="card-title text-uppercase text-muted mb-0">Pesan Baru</h5>
                    <span class="h2 font-weight-bold mb-0"><?= $statistics['baru'] ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                      <i class="fas fa-bell"></i>
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
                    <h5 class="card-title text-uppercase text-muted mb-0">Sudah Dibaca</h5>
                    <span class="h2 font-weight-bold mb-0"><?= $statistics['dibaca'] ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                      <i class="fas fa-eye"></i>
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
                    <h5 class="card-title text-uppercase text-muted mb-0">Sudah Dibalas</h5>
                    <span class="h2 font-weight-bold mb-0"><?= $statistics['dibalas'] ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                      <i class="fas fa-reply"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid mt--7">
    <div class="row">
      <div class="col-xl-12">
        <div class="card shadow">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Daftar Pesan Kontak</h3>
            <div class="btn-group">
              <a href="<?= base_url('pesan-kontak/export') ?>" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-download"></i> Export CSV
              </a>
            </div>
          </div>
          <div class="card-body">
            <!-- Filter and Search -->
            <div class="row mb-3">
              <div class="col-md-4">
                <select class="form-control" id="statusFilter">
                  <option value="">Semua Status</option>
                  <option value="baru" <?= (isset($status_filter) && $status_filter == 'baru') ? 'selected' : '' ?>>Baru</option>
                  <option value="dibaca" <?= (isset($status_filter) && $status_filter == 'dibaca') ? 'selected' : '' ?>>Sudah Dibaca</option>
                  <option value="dibalas" <?= (isset($status_filter) && $status_filter == 'dibalas') ? 'selected' : '' ?>>Sudah Dibalas</option>
                </select>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" id="searchInput" 
                       value="<?= isset($search) ? $search : '' ?>" 
                       placeholder="Cari berdasarkan nama, email, subjek, atau pesan...">
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-block" id="searchBtn">
                  <i class="fas fa-search"></i> Cari
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush" id="tabel-pesan">
                <thead class="thead-light">
                  <tr>
                    <th width="30">
                      <input type="checkbox" id="selectAll">
                    </th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Subjek</th>
                    <th>Status</th>
                    <th>Tanggal Kirim</th>
                    <th width="150">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($pesan)): ?>
                    <?php foreach ($pesan as $p): ?>
                      <tr>
                        <td>
                          <input type="checkbox" name="selected[]" value="<?= $p['id'] ?>" class="message-checkbox">
                        </td>
                        <td>
                          <strong><?= esc($p['nama']) ?></strong>
                          <?php if ($p['telepon']): ?>
                            <br><small class="text-muted"><?= esc($p['telepon']) ?></small>
                          <?php endif; ?>
                        </td>
                        <td><?= esc($p['email']) ?></td>
                        <td>
                          <span class="badge badge-secondary"><?= esc($p['subjek']) ?></span>
                        </td>
                        <td>
                          <?php
                          $statusClass = '';
                          $statusText = '';
                          switch ($p['status']) {
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
                        </td>
                        <td>
                          <?= date('d/m/Y H:i', strtotime($p['tanggal_kirim'])) ?>
                        </td>
                        <td>
                          <div class="btn-group" role="group">
                            <a href="<?= base_url('pesan-kontak/show/' . $p['id']) ?>" 
                               class="btn btn-sm btn-info" title="Lihat Detail">
                              <i class="fas fa-eye"></i>
                            </a>
                            <?php if ($p['status'] == 'baru'): ?>
                              <a href="<?= base_url('pesan-kontak/mark-as-read/' . $p['id']) ?>" 
                                 class="btn btn-sm btn-warning" title="Tandai Dibaca"
                                 onclick="return confirm('Tandai pesan ini sebagai dibaca?')">
                                <i class="fas fa-eye"></i>
                              </a>
                            <?php endif; ?>
                            <?php if ($p['status'] != 'dibalas'): ?>
                              <a href="<?= base_url('pesan-kontak/reply/' . $p['id']) ?>" 
                                 class="btn btn-sm btn-success" title="Balas">
                                <i class="fas fa-reply"></i>
                              </a>
                            <?php endif; ?>
                            <a href="<?= base_url('pesan-kontak/delete/' . $p['id']) ?>" 
                               class="btn btn-sm btn-danger" title="Hapus"
                               onclick="return confirm('Yakin ingin menghapus pesan ini?')">
                              <i class="fas fa-trash"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="7" class="text-center">Tidak ada data pesan.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <!-- Bulk Actions -->
            <div class="row mt-3">
              <div class="col-md-6">
                <div class="input-group">
                  <select class="form-control" name="action" id="bulkAction">
                    <option value="">Pilih Aksi</option>
                    <option value="mark_read">Tandai Dibaca</option>
                    <option value="mark_replied">Tandai Dibalas</option>
                    <option value="delete">Hapus</option>
                  </select>
                  <div class="input-group-append">
                    <button type="button" class="btn btn-primary" id="bulkSubmit" disabled>
                      Terapkan
                    </button>
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

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

// DataTables initialization
$(document).ready(function() {
  $('#tabel-pesan').DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
    },
    pageLength: 25,
    lengthMenu: [10, 25, 50, 100],
    ordering: true,
    searching: true,
    stateSave: true,
    responsive: true,
    autoWidth: false,
    scrollX: true,
    scrollY: 400,
    scrollCollapse: true,
    paging: true,
    info: true,
    order: [[5, "desc"]], // Sort by date column
    language: {
      paginate: {
        previous: "<i class='fas fa-angle-left'></i>",
        next: "<i class='fas fa-angle-right'></i>"
      }
    }
  });

  // Select all functionality
  $('#selectAll').change(function() {
    $('.message-checkbox').prop('checked', $(this).prop('checked'));
    updateBulkSubmit();
  });

  $('.message-checkbox').change(function() {
    updateBulkSubmit();
    
    // Update select all checkbox
    var totalCheckboxes = $('.message-checkbox').length;
    var checkedCheckboxes = $('.message-checkbox:checked').length;
    
    if (checkedCheckboxes === 0) {
      $('#selectAll').prop('indeterminate', false).prop('checked', false);
    } else if (checkedCheckboxes === totalCheckboxes) {
      $('#selectAll').prop('indeterminate', false).prop('checked', true);
    } else {
      $('#selectAll').prop('indeterminate', true);
    }
  });

  function updateBulkSubmit() {
    var checkedCount = $('.message-checkbox:checked').length;
    var action = $('#bulkAction').val();
    
    if (checkedCount > 0 && action) {
      $('#bulkSubmit').prop('disabled', false);
    } else {
      $('#bulkSubmit').prop('disabled', true);
    }
  }

  $('#bulkAction').change(function() {
    updateBulkSubmit();
  });

  // Bulk action submit
  $('#bulkSubmit').click(function() {
    var checkedCount = $('.message-checkbox:checked').length;
    var action = $('#bulkAction').val();
    
    if (checkedCount === 0) {
      Swal.fire('Error', 'Pilih setidaknya satu pesan.', 'error');
      return;
    }
    
    if (!action) {
      Swal.fire('Error', 'Pilih aksi yang akan dilakukan.', 'error');
      return;
    }
    
    if (action === 'delete') {
      Swal.fire({
        title: 'Yakin hapus pesan yang dipilih?',
        text: 'Aksi ini tidak bisa dibatalkan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          submitBulkAction();
        }
      });
    } else {
      submitBulkAction();
    }
  });

  function submitBulkAction() {
    var selected = [];
    $('.message-checkbox:checked').each(function() {
      selected.push($(this).val());
    });
    
    var action = $('#bulkAction').val();
    
    $.post('<?= base_url('pesan-kontak/bulk-action') ?>', {
      action: action,
      selected: selected
    }, function(response) {
      location.reload();
    });
  }

  // Search functionality
  $('#searchBtn').click(function() {
    var search = $('#searchInput').val();
    var status = $('#statusFilter').val();
    var url = '<?= base_url('pesan-kontak') ?>?';
    
    if (search) url += 'search=' + encodeURIComponent(search) + '&';
    if (status) url += 'status=' + encodeURIComponent(status);
    
    window.location.href = url;
  });

  // Enter key search
  $('#searchInput').keypress(function(e) {
    if (e.which == 13) {
      $('#searchBtn').click();
    }
  });
});
</script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.css') ?>">
<!-- DataTables JS -->
<script src="<?= base_url('argon/assets/js/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('argon/assets/js/plugins/datatables/dataTables.bootstrap4.min.js') ?>"></script> 