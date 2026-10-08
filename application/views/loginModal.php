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

  <!-- ============================================================
       POP UP PENGINGAT METODE LOGIN
       Di HP tampil sebagai bottom sheet, di desktop sebagai kartu tengah
       ============================================================ -->
  <div id="loginHint" class="login-hint" role="dialog" aria-modal="true"
       aria-labelledby="loginHintTitle" aria-hidden="true">
    <div class="login-hint-backdrop" id="loginHintBackdrop"></div>

    <div class="login-hint-sheet">
      <div class="login-hint-handle"></div>

      <div class="login-hint-icon"><i class="fas fa-info"></i></div>
      <h5 class="login-hint-title" id="loginHintTitle">Login sesuai cara verifikasi</h5>
      <p class="login-hint-sub">Gunakan cara yang sama dengan saat kamu memverifikasi akun.</p>

      <div class="login-hint-list">
        <div class="login-hint-row">
          <div class="login-hint-row-icon"><i class="fab fa-whatsapp"></i></div>
          <div class="login-hint-row-text">
            <strong>Verifikasi lewat WhatsApp</strong>
            <span>Login dengan nomor WhatsApp, contoh 08123456789</span>
          </div>
        </div>

        <div class="login-hint-row">
          <div class="login-hint-row-icon"><i class="fas fa-envelope"></i></div>
          <div class="login-hint-row-text">
            <strong>Verifikasi lewat Email</strong>
            <span>Login dengan alamat email kamu</span>
          </div>
        </div>

        <!-- <div class="login-hint-row">
          <div class="login-hint-row-icon"><i class="fas fa-check-double"></i></div>
          <div class="login-hint-row-text">
            <strong>Sudah verifikasi keduanya</strong>
            <span>Bebas login dengan salah satunya</span>
          </div>
        </div> -->
      </div>

      <div class="login-hint-note">
        <i class="fas fa-exclamation-circle"></i>
        <span>Login dengan cara yang belum diverifikasi akan gagal.</span>
      </div>

      <button type="button" class="btn btn-orange rounded-pill w-100" id="loginHintBtn">Mengerti</button>
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

  /* ============================================================
     POP UP PENGINGAT METODE LOGIN
     ============================================================ */
  .login-hint {
    position: fixed;
    inset: 0;
    z-index: 20;
    display: flex;
    align-items: flex-end;           /* HP: menempel di bawah (bottom sheet) */
    justify-content: center;
    visibility: hidden;
    opacity: 0;
    transition: opacity 0.25s ease, visibility 0.25s;
    text-align: left;
  }

  .login-hint.show {
    visibility: visible;
    opacity: 1;
  }

  .login-hint-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(17, 24, 39, 0.55);
    -webkit-backdrop-filter: blur(3px);
    backdrop-filter: blur(3px);
  }

  .login-hint-sheet {
    position: relative;
    width: 100%;
    max-width: 440px;
    background: #fff;
    border-radius: 28px 28px 0 0;
    padding: 12px 24px calc(24px + env(safe-area-inset-bottom, 0px));
    box-shadow: 0 -12px 40px rgba(0, 0, 0, 0.2);
    transform: translateY(40px);
    transition: transform 0.3s cubic-bezier(.2, .8, .2, 1);
    max-height: 92vh;
    max-height: 92dvh;
    overflow-y: auto;
  }

  .login-hint.show .login-hint-sheet {
    transform: translateY(0);
  }

  .login-hint-handle {
    width: 40px;
    height: 4px;
    border-radius: 4px;
    background: #e5e7eb;
    margin: 0 auto 18px;
  }

  .login-hint-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ff6a20, #ff5008);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin: 0 auto 14px;
    box-shadow: 0 8px 20px rgba(255, 80, 8, 0.3);
  }

  .login-hint-title {
    text-align: center;
    font-size: 20px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 6px;
  }

  .login-hint-sub {
    text-align: center;
    font-size: 14px;
    line-height: 1.5;
    color: #6b7280;
    margin: 0 0 20px;
  }

  .login-hint-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 14px;
  }

  .login-hint-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 12px 14px;
    background: #f7f8fa;
    border: 1.5px solid #e8eaed;
    border-radius: 16px;
  }

  .login-hint-row-icon {
    flex: 0 0 auto;
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #fff3ee;
    color: #ff5008;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
  }

  .login-hint-row-text strong {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 2px;
  }

  .login-hint-row-text span {
    display: block;
    font-size: 13px;
    line-height: 1.45;
    color: #6b7280;
  }

  .login-hint-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 14px;
    margin-bottom: 18px;
    background: #fff3ee;
    border-radius: 14px;
    font-size: 13px;
    line-height: 1.5;
    color: #c2410c;
    font-weight: 600;
  }

  .login-hint-note i {
    margin-top: 2px;
    color: #ff5008;
  }

  #loginHintBtn {
    height: 50px;
    font-size: 15px;
    font-weight: 700;
    box-shadow: 0 4px 16px rgba(255, 80, 8, 0.3);
  }

  /* Desktop: kartu di tengah layar */
  @media (min-width: 576px) {
    .login-hint { align-items: center; }
    .login-hint-sheet {
      border-radius: 24px;
      padding-bottom: 24px;
      transform: translateY(16px) scale(0.97);
    }
    .login-hint.show .login-hint-sheet { transform: none; }
    .login-hint-handle { display: none; }
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
        } else if (cekLoginResult.needverify) {
          // Akun sudah ada tapi belum verifikasi -> lanjutkan ke step OTP, bukan daftar ulang
          swal('Verifikasi Diperlukan',
               'Akun kamu sudah terdaftar tapi belum diverifikasi. Silakan masukkan kode OTP.',
               'info').then(function() {
            $('#loginModal').modal('hide');
            setTimeout(function() {
              bukaRegistrasiLanjutOtp({
                idjemaat: cekLoginResult.idjemaat,
                nohp    : cekLoginResult.nohp,
                email   : cekLoginResult.email,
                tipe    : cekLoginResult.tipe
              });
            }, 400);
          });
        } else {
          // Login gagal: ingatkan lagi supaya pakai metode yang sama dengan saat verifikasi
          swal('Informasi',
               cekLoginResult.msg +
               '\n\nPastikan kamu login memakai nomor WhatsApp atau email yang sudah kamu verifikasi.',
               'info');
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

  // ===== POP UP PENGINGAT METODE LOGIN =====
  // Muncul sekali setiap modal login dibuka, saat user menyentuh kolom username
  var loginHintShown = false;

  function bukaLoginHint() {
    $('#loginHint').addClass('show').attr('aria-hidden', 'false');
    setTimeout(function () { $('#loginHintBtn').trigger('focus'); }, 80);
  }

  function tutupLoginHint() {
    $('#loginHint').removeClass('show').attr('aria-hidden', 'true');
    // kembalikan kursor ke kolom username (flag sudah true, jadi tidak muncul lagi)
    setTimeout(function () { $('#emaillogin').trigger('focus'); }, 250);
  }

  // Reset setiap modal login dibuka
  $('#loginModal').on('show.bs.modal', function () {
    loginHintShown = false;
    $('#loginHint').removeClass('show').attr('aria-hidden', 'true');
  });

  // PENTING: jangan buka pop up saat 'focus' yang dipicu mouse/sentuh.
  // Kalau pop up muncul di tengah klik, mousedown terjadi di input tetapi mouseup
  // jatuh di overlay. Browser lalu menembakkan 'click' ke elemen .modal, dan Bootstrap
  // mengira itu klik di luar dialog, sehingga modal login ikut tertutup.
  // Solusi: buka pop up SETELAH klik selesai (event 'click'),
  // atau saat fokus lewat keyboard (Tab).
  var loginHintPointer = false;

  $('#emaillogin').on('mousedown touchstart', function () {
    loginHintPointer = true;
  });

  $(document).on('mouseup touchend touchcancel', function () {
    setTimeout(function () { loginHintPointer = false; }, 0);
  });

  function tampilkanLoginHint(input) {
    if (loginHintShown) return;
    loginHintShown = true;
    input.blur();           // tutup keyboard HP supaya pop up tidak tertutup
    bukaLoginHint();
  }

  $('#emaillogin').on('click', function () {
    tampilkanLoginHint(this);
  });

  $('#emaillogin').on('focus', function () {
    if (loginHintPointer) return;   // fokus karena mouse/sentuh: tunggu event 'click'
    tampilkanLoginHint(this);       // fokus lewat keyboard (Tab)
  });

  $('#loginHintBtn, #loginHintBackdrop').on('click', tutupLoginHint);

  // Tombol Esc menutup pop up saja (bukan seluruh modal login)
  $('#loginHint').on('keydown', function (e) {
    if (e.key === 'Escape') {
      e.stopPropagation();
      tutupLoginHint();
    }
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