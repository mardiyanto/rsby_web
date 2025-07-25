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
            <h3 class="mb-0">Ubah Password</h3>
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
            <form method="post" action="<?= base_url('user/update-password') ?>" id="form-change-password">
              <?= csrf_field() ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Password Lama <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="password" name="current_password" id="current_password" class="form-control" required placeholder="Masukkan password lama">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Password Baru <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6" placeholder="Masukkan password baru">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <small class="form-text text-muted">Minimal 6 karakter</small>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6" placeholder="Konfirmasi password baru">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                          <i class="fas fa-eye"></i>
                        </button>
                      </div>
                    </div>
                    <small class="form-text text-muted">Harus sama dengan password baru</small>
                  </div>
                </div>
                <div class="col-md-6">
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
                <small class="text-muted">Mengubah password...</small>
              </div>
              
              <button type="submit" class="btn btn-success" id="btn-submit">
                <i class="fas fa-key"></i> Ubah Password
              </button>
              <a href="<?= base_url('dashboard/'.session('role')) ?>" class="btn btn-secondary">
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
    var currentPassword = $('#current_password');
    var newPassword = $('#new_password');
    var confirmPassword = $('#confirm_password');
    var progressContainer = $('#progress-container');
    var progressBar = $('.progress-bar');
    var btnSubmit = $('#btn-submit');

    // Toggle password visibility
    $('#toggleCurrentPassword').on('click', function() {
        var type = currentPassword.attr('type') === 'password' ? 'text' : 'password';
        currentPassword.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#toggleNewPassword').on('click', function() {
        var type = newPassword.attr('type') === 'password' ? 'text' : 'password';
        newPassword.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#toggleConfirmPassword').on('click', function() {
        var type = confirmPassword.attr('type') === 'password' ? 'text' : 'password';
        confirmPassword.attr('type', type);
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

    newPassword.on('input', function() {
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
    confirmPassword.on('input', function() {
        if ($(this).val() !== newPassword.val()) {
            $(this).addClass('is-invalid');
            $(this).removeClass('is-valid');
        } else {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        }
    });

    newPassword.on('input', function() {
        if (confirmPassword.val() !== '') {
            if (confirmPassword.val() !== $(this).val()) {
                confirmPassword.addClass('is-invalid');
                confirmPassword.removeClass('is-valid');
            } else {
                confirmPassword.removeClass('is-invalid');
                confirmPassword.addClass('is-valid');
            }
        }
    });

    // Form submission dengan progress bar
    $('#form-change-password').on('submit', function(e){
        var currentPass = currentPassword.val();
        var newPass = newPassword.val();
        var confirmPass = confirmPassword.val();
        
        if(!currentPass || !newPass || !confirmPass){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Semua field harus diisi!'
            });
            return false;
        }

        if(newPass !== confirmPass){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Konfirmasi password tidak cocok!'
            });
            return false;
        }

        if(newPass.length < 6){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Password minimal 6 karakter!'
            });
            return false;
        }

        if(newPass === currentPass){
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Password baru tidak boleh sama dengan password lama!'
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