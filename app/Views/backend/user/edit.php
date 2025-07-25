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
            <h3 class="mb-0">Edit User</h3>
            <div class="float-right">
              <a href="<?= base_url('user') ?>" class="btn btn-secondary">Kembali</a>
            </div>
          </div>
          <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
              </div>
            <?php endif; ?>
            <form method="post" action="<?= base_url('user/update/'.$user['id']) ?>" id="form-user">
              <?= csrf_field() ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= old('username', $user['username']) ?>" required maxlength="50" placeholder="Masukkan username">
                    <small class="form-text text-muted">Username harus unik dan tidak boleh mengandung spasi</small>
                  </div>
                  <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama']) ?>" required maxlength="100" placeholder="Masukkan nama lengkap">
                  </div>
                  <div class="form-group">
                    <label>Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-control" required>
                      <option value="">Pilih Role</option>
                      <option value="admin" <?= old('role', $user['role']) == 'admin' ? 'selected' : '' ?>>Admin</option>
                      <option value="user" <?= old('role', $user['role']) == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                    <small class="form-text text-muted">Admin memiliki akses penuh, User memiliki akses terbatas</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Password Baru (Opsional)</label>
                    <div class="input-group">
                      <input type="password" name="password" id="password" class="form-control" minlength="6" placeholder="Kosongkan jika tidak ingin ganti password">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <small class="form-text text-muted">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password</small>
                  </div>
                  <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <div class="input-group">
                      <input type="password" name="password_confirm" id="password_confirm" class="form-control" minlength="6" placeholder="Konfirmasi password baru">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <small class="form-text text-muted">Harus sama dengan password baru</small>
                  </div>
                  <div class="form-group">
                    <label>Kekuatan Password</label>
                    <div class="progress mb-2">
                      <div class="progress-bar" id="passwordStrength" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small class="form-text text-muted" id="passwordStrengthText">Masukkan password untuk melihat kekuatan</small>
                  </div>
                </div>
              </div>
              
              <!-- Progress Bar -->
              <div id="progress-container" style="display:none;">
                <div class="progress mb-3">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                </div>
                <small class="text-muted">Mengupdate user...</small>
              </div>
              
              <button type="submit" class="btn btn-success" id="btn-submit">
                <i class="fas fa-save"></i> Update
              </button>
              <a href="<?= base_url('user') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
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
    var password = $('#password');
    var passwordConfirm = $('#password_confirm');
    var progressContainer = $('#progress-container');
    var progressBar = $('.progress-bar');
    var btnSubmit = $('#btn-submit');

    // Toggle password visibility
    $('#togglePassword').on('click', function() {
        var type = password.attr('type') === 'password' ? 'text' : 'password';
        password.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#togglePasswordConfirm').on('click', function() {
        var type = passwordConfirm.attr('type') === 'password' ? 'text' : 'password';
        passwordConfirm.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // Password strength checker
    function checkPasswordStrength(password) {
        var strength = 0;
        var feedback = [];

        if (password.length >= 6) strength += 20;
        if (password.length >= 8) strength += 20;
        if (password.match(/[a-z]/)) strength += 20;
        if (password.match(/[A-Z]/)) strength += 20;
        if (password.match(/[0-9]/)) strength += 20;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 20;

        if (password.length < 6) feedback.push('Minimal 6 karakter');
        if (!password.match(/[a-z]/)) feedback.push('Tambahkan huruf kecil');
        if (!password.match(/[A-Z]/)) feedback.push('Tambahkan huruf besar');
        if (!password.match(/[0-9]/)) feedback.push('Tambahkan angka');
        if (!password.match(/[^a-zA-Z0-9]/)) feedback.push('Tambahkan karakter khusus');

        return { strength: strength, feedback: feedback };
    }

    password.on('input', function() {
        var result = checkPasswordStrength($(this).val());
        var strengthBar = $('#passwordStrength');
        var strengthText = $('#passwordStrengthText');

        strengthBar.css('width', result.strength + '%');

        if (result.strength <= 40) {
            strengthBar.removeClass('bg-success bg-warning').addClass('bg-danger');
            strengthText.text('Password lemah: ' + result.feedback.join(', '));
        } else if (result.strength <= 80) {
            strengthBar.removeClass('bg-danger bg-success').addClass('bg-warning');
            strengthText.text('Password sedang: ' + result.feedback.join(', '));
        } else {
            strengthBar.removeClass('bg-danger bg-warning').addClass('bg-success');
            strengthText.text('Password kuat!');
        }
    });

    // Password confirmation checker
    passwordConfirm.on('input', function() {
        if (password.val() !== '' && $(this).val() !== password.val()) {
            $(this).addClass('is-invalid');
            $(this).removeClass('is-valid');
        } else if (password.val() !== '' && $(this).val() === password.val()) {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        } else {
            $(this).removeClass('is-invalid is-valid');
        }
    });

    password.on('input', function() {
        if (passwordConfirm.val() !== '') {
            if (passwordConfirm.val() !== $(this).val()) {
                passwordConfirm.addClass('is-invalid');
                passwordConfirm.removeClass('is-valid');
            } else {
                passwordConfirm.removeClass('is-invalid');
                passwordConfirm.addClass('is-valid');
            }
        } else {
            passwordConfirm.removeClass('is-invalid is-valid');
        }
    });

    // Form submission dengan progress bar
    $('#form-user').on('submit', function(e){
        var username = $('input[name="username"]').val().trim();
        var nama = $('input[name="nama"]').val().trim();
        var role = $('select[name="role"]').val();
        var password = $('input[name="password"]').val();
        var passwordConfirm = $('input[name="password_confirm"]').val();
        
        if(!username || !nama || !role){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua field yang bertanda * harus diisi!'
            });
            return false;
        }

        if(password !== '' && password !== passwordConfirm){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Konfirmasi password tidak cocok!'
            });
            return false;
        }

        if(password !== '' && password.length < 6){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Password minimal 6 karakter!'
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