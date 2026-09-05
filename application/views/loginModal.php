<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">

      <div class="modal-body px-5 py-4 text-center">
        <form action="<?php echo site_url('login/cek_login') ?>" method="post" id="formLogin">

          <img src="<?php echo base_url('myesc.id/images/icon.png') ?>" alt="Logo" width="50" class="mb-3">
          <h4 class="fw-bold text-orange">MYESC</h4>
          <p class="text-muted small mb-4"></p>

          <!-- Input Email -->
          <div class="form-group position-relative mb-4">
            <input type="text" name="emaillogin" id="emaillogin"
              class="form-control rounded-pill ps-5"
              placeholder="Masukan Email atau Nomor Whatsapp">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-user"></i>
            </span>
          </div>

          <!-- Input Password -->
          <div class="form-group position-relative mb-4">
            <input type="password" name="passwordlogin" id="passwordlogin"
              class="form-control rounded-pill ps-5"
              placeholder="Masukan Password">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-lock"></i>
            </span>
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted" style="cursor: pointer;">
              <i class="fas fa-eye" id="togglePassword"></i>
            </span>
          </div>

          <div id="divAlert" class="mb-3"></div>

          <a href="#" class="float-end text-info mb-3 show-form-lupapassword"
            style="color: #ff5008 !important;">Lupa Password?</a>

          <button type="submit" class="btn btn-orange rounded-pill w-100 mb-2" id="btnLogin">LOGIN</button>

          <p class="small mt-2">Belum Punya Akun?
            <a href="#" class="show-form-registrasi text-decoration-none fw-bold"
              style="color: #ff5008;">Daftar Sekarang</a>
          </p>

          <div class="d-flex align-items-center my-3">
            <hr class="flex-grow-1">
            <span class="mx-2 small text-muted">atau</span>
            <hr class="flex-grow-1">
          </div>

          <!-- ============================================================
               TOMBOL SIGN-IN WITH GOOGLE
               Hanya untuk akun yang SUDAH terdaftar & email-nya sudah
               diverifikasi sebelumnya. Tidak membuat akun baru.
               ============================================================ -->
          <div id="g_id_onload"
               data-client_id="950128025099-725a9km1sdk140v8op4a68girk9itai8.apps.googleusercontent.com"
               data-callback="handleGoogleSignIn"
               data-auto_prompt="false">
          </div>

          <div class="g_id_signin"
               data-type="standard"
               data-shape="pill"
               data-theme="outline"
               data-text="signin_with"
               data-size="large"
               data-logo_alignment="left"
               style="display: flex; justify-content: center; margin-bottom: 8px;">
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- Script Google Identity Services (resmi dari Google) -->
<script src="https://accounts.google.com/gsi/client" async defer></script>

<style>
  .text-orange {
    color: #ff5008;
  }

  .btn-orange {
    background-color: #ff5008;
    color: #fff;
    border: none;
    transition: 0.3s;
  }

  .btn-orange:hover {
    background-color: #e04400;
    color: #fff;
  }

  .form-control {
    height: 48px;
    background: #f8f8f8;
    border: 1px solid #eee;
    font-size: 14px;
  }

  .form-control:focus {
    background: #fff;
    border-color: #ff5008;
    box-shadow: 0 0 0 3px rgba(255, 80, 8, 0.1);
  }

  input::placeholder {
    color: #bbb;
  }

  .form-group {
    position: relative;
  }

  .form-group i {
    font-size: 16px;
  }

  /* ===== FIX BOOTSTRAP VALIDATOR ===== */
  /* Sembunyikan icon bawaan bootstrapValidator */
  #formLogin .form-control-feedback {
    display: none !important;
  }

  /* Pesan error jadi absolute agar tidak geser layout */
  #formLogin .help-block {
    position: absolute;
    bottom: -20px;
    left: 12px;
    font-size: 11px;
    color: #ff5008;
    margin: 0;
    white-space: nowrap;
  }

  /* Tambah ruang bawah form-group agar pesan error tidak tertimpa elemen berikutnya */
  #formLogin .form-group {
    margin-bottom: 32px !important;
  }

  /* Hilangkan border merah/hijau bawaan bootstrapValidator */
  #formLogin .has-error .form-control {
    border-color: #ff5008 !important;
    box-shadow: 0 0 0 3px rgba(255, 80, 8, 0.1) !important;
  }

  #formLogin .has-success .form-control {
    border-color: #eee !important;
    box-shadow: none !important;
  }
</style>

<script>
  $("#formLogin").bootstrapValidator({
    feedbackIcons: {
      valid: null,
      invalid: null,
      validating: null
    },
    fields: {
      emaillogin: {
        validators: {
          notEmpty: {
            message: "Silahkan masukan email atau nomor whatsapp"
          },
        }
      },
      passwordlogin: {
        validators: {
          notEmpty: {
            message: "Silahkan masukan password"
          },
        }
      },
    }
  }).on('success.form.bv', function(e) {
    e.preventDefault();
    var email    = $("#emaillogin").val();
    var password = $("#passwordlogin").val();

    $.ajax({
        url: '<?php echo site_url('login/cekLoginAjax') ?>',
        type: 'POST',
        dataType: 'json',
        data: { 'email': email, 'password': password },
      })
      .done(function(cekLoginResult) {
        if (cekLoginResult.success) {
          window.open("<?php echo site_url() ?>", "_self");
        } else {
          swal('Informasi', cekLoginResult.msg, 'info');
        }
      })
      .fail(function() {
        $('#divAlert').html(`
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <div>Terjadi kesalahan, coba lagi.</div>
          </div>
        `);
      });
  });

  document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("passwordlogin");
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
    this.classList.toggle("fa-eye");
    this.classList.toggle("fa-eye-slash");
  });

  // ===== HANDLER SIGN-IN WITH GOOGLE =====
  function handleGoogleSignIn(response) {
    // response.credential berisi token JWT dari Google, dikirim ke backend untuk diverifikasi
    $.ajax({
        url: '<?php echo site_url('login/loginWithGoogle') ?>',
        type: 'POST',
        dataType: 'json',
        data: { credential: response.credential },
      })
      .done(function(res) {
        if (res.success) {
          window.open("<?php echo site_url() ?>", "_self");
        } else {
          swal('Informasi', res.msg, 'info');
        }
      })
      .fail(function() {
        swal('Error', 'Terjadi kesalahan, coba lagi.', 'error');
      });
  }
</script>