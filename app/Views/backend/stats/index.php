<?= $this->include('backend/headeradmin') ?>
<div class="main-content">
  <?= $this->include('backend/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row">
          <div class="col-xl-12">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Quick Stats</h5>
                    <span class="h2 font-weight-bold mb-0">Pengelolaan Statistik</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                      <i class="fas fa-chart-bar"></i>
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
            <h3 class="mb-0">Daftar Quick Stats</h3>
            <div class="btn-group">
              <a href="<?= base_url('stats/create') ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Stats
              </a>
              <a href="<?= base_url('stats/export') ?>" class="btn btn-sm btn-outline-primary">
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
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Nonaktif</option>
                </select>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan judul, angka, atau deskripsi...">
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-block" id="searchBtn">
                  <i class="fas fa-search"></i> Cari
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush" id="tabel-stats">
                <thead class="thead-light">
                  <tr>
                    <th width="30">
                      <input type="checkbox" id="selectAll">
                    </th>
                    <th width="50">Urutan</th>
                    <th>Judul</th>
                    <th width="100">Angka</th>
                    <th width="100">Ikon</th>
                    <th>Deskripsi</th>
                    <th width="100">Status</th>
                    <th width="150">Aksi</th>
                  </tr>
                </thead>
                <tbody id="statsTableBody">
                  <?php if (!empty($stats)): ?>
                    <?php foreach ($stats as $stat): ?>
                      <tr data-id="<?= $stat['id'] ?>">
                        <td>
                          <input type="checkbox" name="selected[]" value="<?= $stat['id'] ?>" class="stat-checkbox">
                        </td>
                        <td>
                          <span class="badge badge-info"><?= $stat['urutan'] ?></span>
                        </td>
                        <td>
                          <strong><?= esc($stat['judul']) ?></strong>
                        </td>
                        <td>
                          <span class="badge badge-primary"><?= esc($stat['angka']) ?></span>
                        </td>
                        <td>
                          <i class="<?= esc($stat['ikon']) ?> fa-2x text-primary"></i>
                        </td>
                        <td>
                          <?= esc($stat['deskripsi'] ?? '-') ?>
                        </td>
                        <td>
                          <?php
                          $statusClass = ($stat['status'] == 'aktif') ? 'badge-success' : 'badge-warning';
                          $statusText = ($stat['status'] == 'aktif') ? 'Aktif' : 'Nonaktif';
                          ?>
                          <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                          <div class="btn-group" role="group">
                            <a href="<?= base_url('stats/edit/' . $stat['id']) ?>" 
                               class="btn btn-sm btn-warning" title="Edit">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('stats/toggle-status/' . $stat['id']) ?>" 
                               class="btn btn-sm btn-info" title="Toggle Status"
                               onclick="return confirm('Ubah status stat ini?')">
                              <i class="fas fa-toggle-on"></i>
                            </a>
                            <a href="<?= base_url('stats/delete/' . $stat['id']) ?>" 
                               class="btn btn-sm btn-danger" title="Hapus"
                               onclick="return confirm('Yakin ingin menghapus stat ini?')">
                              <i class="fas fa-trash"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="8" class="text-center">Tidak ada data Quick Stats.</td></tr>
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
                    <option value="activate">Aktifkan</option>
                    <option value="deactivate">Nonaktifkan</option>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
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
  $('#tabel-stats').DataTable({
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
    order: [[1, "asc"]], // Sort by urutan column
    language: {
      paginate: {
        previous: "<i class='fas fa-angle-left'></i>",
        next: "<i class='fas fa-angle-right'></i>"
      }
    }
  });

  // Select all functionality
  $('#selectAll').change(function() {
    $('.stat-checkbox').prop('checked', $(this).prop('checked'));
    updateBulkSubmit();
  });

  $('.stat-checkbox').change(function() {
    updateBulkSubmit();
    
    // Update select all checkbox
    var totalCheckboxes = $('.stat-checkbox').length;
    var checkedCheckboxes = $('.stat-checkbox:checked').length;
    
    if (checkedCheckboxes === 0) {
      $('#selectAll').prop('indeterminate', false).prop('checked', false);
    } else if (checkedCheckboxes === totalCheckboxes) {
      $('#selectAll').prop('indeterminate', false).prop('checked', true);
    } else {
      $('#selectAll').prop('indeterminate', true);
    }
  });

  function updateBulkSubmit() {
    var checkedCount = $('.stat-checkbox:checked').length;
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
    var checkedCount = $('.stat-checkbox:checked').length;
    var action = $('#bulkAction').val();
    
    if (checkedCount === 0) {
      Swal.fire('Error', 'Pilih setidaknya satu stat.', 'error');
      return;
    }
    
    if (!action) {
      Swal.fire('Error', 'Pilih aksi yang akan dilakukan.', 'error');
      return;
    }
    
    if (action === 'delete') {
      Swal.fire({
        title: 'Yakin hapus stat yang dipilih?',
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
    $('.stat-checkbox:checked').each(function() {
      selected.push($(this).val());
    });
    
    var action = $('#bulkAction').val();
    
    $.post('<?= base_url('stats/bulk-action') ?>', {
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
    var url = '<?= base_url('stats') ?>?';
    
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