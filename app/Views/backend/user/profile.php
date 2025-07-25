<?= $this->include('backend/headeradmin') ?>
<div class="main-content">
  <?= $this->include('backend/menuatasadmin') ?>
  <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body"></div>
    </div>
  </div>
  <div class="container-fluid mt--7">
    <div class="row justify-content-center">
      <div class="col-xl-8">
        <div class="card shadow">
          <div class="card-header border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Profil Saya</h3>
            <div class="float-right">
              <a href="<?= base_url('dashboard/'.session('role')) ?>" class="btn btn-secondary">Kembali</a>
            </div>
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
            
            <!-- Profile Info -->
            <div class="row mb-4">
              <div class="col-md-3 text-center">
                <div class="avatar avatar-xl rounded-circle bg-gradient-primary mx-auto mb-3">
                  <i class="fas fa-user text-white" style="font-size: 3rem;"></i>
                </div>
                <h5 class="mb-0"><?= esc($user['nama']) ?></h5>
                <small class="text-muted"><?= ucfirst($user['role']) ?></small>
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">Username</label>
                      <p class="form-control-plaintext"><?= esc($user['username']) ?></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">Role</label>
                      <p class="form-control-plaintext">
                        <?php if ($user['role'] == 'admin'): ?>
                          <span class="badge badge-danger">
                            <i class="fas fa-crown"></i> Admin
                          </span>
                        <?php else: ?>
                          <span class="badge badge-info">
                            <i class="fas fa-user"></i> User
                          </span>
                        <?php endif; ?>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">Status</label>
                      <p class="form-control-plaintext">
                        <span class="badge badge-success">
                          <i class="fas fa-circle"></i> Online
                        </span>
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="font-weight-bold">Terakhir Login</label>
                      <p class="form-control-plaintext">
                        <?php if (isset($user['last_login'])): ?>
                          <?= date('d/m/Y H:i', strtotime($user['last_login'])) ?>
                        <?php else: ?>
                          <span class="text-muted">-</span>
                        <?php endif; ?>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <hr>

            <!-- Edit Profile Form -->
            <form method="post" action="<?= base_url('user/update-profile') ?>" id="form-profile">
              <?= csrf_field() ?>
              <h5 class="mb-3">Edit Profil</h5>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= old('username', $user['username']) ?>" required maxlength="50" placeholder="Masukkan username">
                    <small class="form-text text-muted">Username harus unik dan tidak boleh mengandung spasi</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama']) ?>" required maxlength="100" placeholder="Masukkan nama lengkap">
                  </div>
                </div>
              </div>
              
              <!-- Progress Bar -->
              <div id="progress-container" style="display:none;">
                <div class="progress mb-3">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="text-muted">Mengupdate profil...</small>
              </div>
              
              <button type="submit" class="btn btn-success" id="btn-submit">
                <i class="fas fa-save"></i> Update Profil
              </button>
              <a href="<?= base_url('user/change-password') ?>" class="btn btn-warning">
                <i class="fas fa-key"></i> Ubah Password
              </a>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?= $this->include('backend/footeradmin') ?>
  </div>
</div>
<?= $this->include('backend/jsadmin') ?>

<script>
$(function(){
    var progressContainer = $('#progress-container');
    var progressBar = $('.progress-bar');
    var btnSubmit = $('#btn-submit');

    // Form submission dengan progress bar
    $('#form-profile').on('submit', function(e){
        var username = $('input[name="username"]').val().trim();
        var nama = $('input[name="nama"]').val().trim();
        
        if(!username || !nama){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua field yang bertanda * harus diisi!'
            });
            return false;
        }
        
        // Tampilkan progress bar
        progressContainer.show();
        btnSubmit.prop('disabled', true);
        
        // Simulasi progress bar
        var progress = 0;
        var interval = setInterval(function(){
            progress += Math.random() * 30;
            if(progress > 90) progress = 90;
            progressBar.css('width', progress + '%');
        }, 200);
        
        // Reset progress saat form berhasil disubmit
        $(this).on('submit', function(){
            clearInterval(interval);
            progressBar.css('width', '100%');
        });
    });
});
</script> 