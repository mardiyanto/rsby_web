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
                    <h5 class="card-title text-uppercase text-muted mb-0">Total FAQ</h5>
                    <span class="h2 font-weight-bold mb-0"><?= $statistics['total'] ?></span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                      <i class="fas fa-question-circle"></i>
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
                    <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                      <i class="fas fa-check-circle"></i>
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
                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                      <i class="fas fa-times-circle"></i>
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
            <h3 class="mb-0">Daftar FAQ</h3>
            <div class="btn-group">
              <a href="<?= base_url('faq/create') ?>" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah FAQ
              </a>
              <a href="<?= base_url('faq/export') ?>" class="btn btn-sm btn-outline-primary">
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
                  <option value="aktif" <?= (isset($status_filter) && $status_filter == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                  <option value="nonaktif" <?= (isset($status_filter) && $status_filter == 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                </select>
              </div>
              <div class="col-md-6">
                <input type="text" class="form-control" id="searchInput" 
                       value="<?= isset($search) ? $search : '' ?>" 
                       placeholder="Cari berdasarkan pertanyaan atau jawaban...">
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-block" id="searchBtn">
                  <i class="fas fa-search"></i> Cari
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered align-items-center table-flush" id="tabel-faq">
                <thead class="thead-light">
                  <tr>
                    <th width="30">
                      <input type="checkbox" id="selectAll">
                    </th>
                    <th width="50">Urutan</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                    <th width="100">Status</th>
                    <th width="150">Aksi</th>
                  </tr>
                </thead>
                <tbody id="faqTableBody">
                  <?php if (!empty($faq)): ?>
                    <?php foreach ($faq as $f): ?>
                      <tr data-id="<?= $f['id'] ?>">
                        <td>
                          <input type="checkbox" name="selected[]" value="<?= $f['id'] ?>" class="faq-checkbox">
                        </td>
                        <td>
                          <span class="badge badge-info"><?= $f['urutan'] ?></span>
                        </td>
                        <td>
                          <strong><?= esc($f['pertanyaan']) ?></strong>
                        </td>
                        <td>
                          <?= esc(substr($f['jawaban'], 0, 100)) ?>...
                        </td>
                        <td>
                          <?php
                          $statusClass = ($f['status'] == 'aktif') ? 'badge-success' : 'badge-warning';
                          $statusText = ($f['status'] == 'aktif') ? 'Aktif' : 'Nonaktif';
                          ?>
                          <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </td>
                        <td>
                          <div class="btn-group" role="group">
                            <a href="<?= base_url('faq/edit/' . $f['id']) ?>" 
                               class="btn btn-sm btn-warning" title="Edit">
                              <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?= base_url('faq/toggle-status/' . $f['id']) ?>" 
                               class="btn btn-sm btn-info" title="Toggle Status"
                               onclick="return confirm('Ubah status FAQ ini?')">
                              <i class="fas fa-toggle-on"></i>
                            </a>
                            <a href="<?= base_url('faq/delete/' . $f['id']) ?>" 
                               class="btn btn-sm btn-danger" title="Hapus"
                               onclick="return confirm('Yakin ingin menghapus FAQ ini?')">
                              <i class="fas fa-trash"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="6" class="text-center">Tidak ada data FAQ.</td></tr>
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
  $('#tabel-faq').DataTable({
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
    $('.faq-checkbox').prop('checked', $(this).prop('checked'));
    updateBulkSubmit();
  });

  $('.faq-checkbox').change(function() {
    updateBulkSubmit();
    
    // Update select all checkbox
    var totalCheckboxes = $('.faq-checkbox').length;
    var checkedCheckboxes = $('.faq-checkbox:checked').length;
    
    if (checkedCheckboxes === 0) {
      $('#selectAll').prop('indeterminate', false).prop('checked', false);
    } else if (checkedCheckboxes === totalCheckboxes) {
      $('#selectAll').prop('indeterminate', false).prop('checked', true);
    } else {
      $('#selectAll').prop('indeterminate', true);
    }
  });

  function updateBulkSubmit() {
    var checkedCount = $('.faq-checkbox:checked').length;
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
    var checkedCount = $('.faq-checkbox:checked').length;
    var action = $('#bulkAction').val();
    
    if (checkedCount === 0) {
      Swal.fire('Error', 'Pilih setidaknya satu FAQ.', 'error');
      return;
    }
    
    if (!action) {
      Swal.fire('Error', 'Pilih aksi yang akan dilakukan.', 'error');
      return;
    }
    
    if (action === 'delete') {
      Swal.fire({
        title: 'Yakin hapus FAQ yang dipilih?',
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
    $('.faq-checkbox:checked').each(function() {
      selected.push($(this).val());
    });
    
    var action = $('#bulkAction').val();
    
    $.post('<?= base_url('faq/bulk-action') ?>', {
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
    var url = '<?= base_url('faq') ?>?';
    
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