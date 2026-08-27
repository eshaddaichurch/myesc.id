<?php $this->load->view('template/festavalive/header'); ?>

<body>
  <main>
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

      * { box-sizing: border-box; }

      html, body {
        margin: 0;
        padding: 0;
        background: #f5f5f5;
        font-family: 'Figtree', sans-serif;
        color: #111;
        line-height: 1.6;
      }

      /* Padding agar tidak tertimpa navbar */
      .page-content {
        padding-top: 80px !important;
        padding-bottom: 80px !important;
      }
      @media (min-width: 768px) {
        .page-content {
          padding-top: 120px !important;
          padding-bottom: 100px !important;
        }
      }
      @media (min-width: 1200px) {
        .page-content {
          padding-top: 160px !important;
          padding-bottom: 151px !important;
        }
      }

      /* ===== HERO SECTION ===== */
      .password-hero {
        background: linear-gradient(135deg, #e04607 0%, #ff6b35 55%, #ffb347 100%);
        border-radius: 20px;
        padding: 32px 28px 60px;
        position: relative;
        overflow: hidden;
        margin-bottom: -40px;
      }

      .password-hero::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        pointer-events: none;
      }

      .password-hero::after {
        content: '';
        position: absolute;
        bottom: -30px; left: -10px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
      }

      .hero-brand {
        font-size: 12px;
        font-weight: 600;
        color: rgba(255,255,255,0.85);
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 20px;
      }

      .hero-title {
        font-size: 26px;
        font-weight: 700;
        color: #fff;
        margin: 0;
        line-height: 1.3;
      }

      .hero-desc {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        margin: 10px 0 0;
      }

      /* ===== ICON BOX ===== */
      .icon-box {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: rgba(255,255,255,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-bottom: 16px;
      }

      .icon-box svg {
        width: 28px;
        height: 28px;
        stroke: white;
      }

      /* ===== MAIN CARD ===== */
      .password-main-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        padding: 32px 24px;
        position: relative;
        z-index: 2;
      }

      /* ===== FORM STYLING ===== */
      .form-group-custom {
        margin-bottom: 20px;
      }

      .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        margin-bottom: 8px;
        display: block;
      }

      .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #e0e0e0;
        border-radius: 12px;
        font-size: 14px;
        font-family: 'Figtree', sans-serif;
        color: #1a1a1a;
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
      }

      .form-control:focus {
        outline: none;
        border-color: #ff6b35;
        box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.08);
      }

      .form-control::placeholder {
        color: #ccc;
      }

      /* ===== INFO BOX ===== */
      .info-box {
        background: #fffbea;
        border: 1px solid #ffe08a;
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 20px;
        font-size: 12px;
        color: #7a5c00;
        display: flex;
        gap: 10px;
        align-items: flex-start;
      }

      .info-box::before {
        content: 'ℹ';
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
      }

      /* ===== BUTTON STYLING ===== */
      .button-group {
        display: flex;
        gap: 10px;
        margin-top: 28px;
        flex-wrap: wrap;
      }

      .btn-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: transform 0.15s, box-shadow 0.15s;
        font-family: 'Figtree', sans-serif;
      }

      .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.12);
      }

      .btn-custom:active {
        transform: translateY(0);
      }

      .btn-primary-custom {
        background: linear-gradient(135deg, #e04607, #ff7c42);
        color: #fff !important;
      }

      .btn-primary-custom:hover {
        box-shadow: 0 6px 24px rgba(255, 107, 53, 0.35);
      }

      .btn-secondary-custom {
        background: #f5f5f5;
        color: #666 !important;
        border: 1.5px solid #e0e0e0;
      }

      .btn-secondary-custom:hover {
        background: #efefef;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      }

      /* ===== RESPONSIVE ===== */
      @media (min-width: 768px) {
        .password-hero {
          padding: 40px;
          margin-bottom: 0;
          border-radius: 20px 0 0 20px;
        }
        .password-main-card {
          padding: 40px;
          border-radius: 0 20px 20px 0;
        }
        .password-layout {
          display: flex;
          align-items: stretch;
          border-radius: 20px;
          overflow: hidden;
          box-shadow: 0 6px 32px rgba(0,0,0,0.1);
        }
        .password-hero {
          flex: 0 0 280px;
          margin-bottom: 0 !important;
        }
        .password-main-card {
          flex: 1;
          box-shadow: none;
        }
        .hero-title {
          font-size: 28px;
        }
      }

      /* ===== PASSWORD STRENGTH INDICATOR (OPTIONAL) ===== */
      .password-strength {
        margin-top: 8px;
        height: 4px;
        background: #e0e0e0;
        border-radius: 2px;
        overflow: hidden;
      }

      .strength-bar {
        height: 100%;
        width: 0%;
        transition: width 0.2s, background-color 0.2s;
        background: #ccc;
      }

      .strength-text {
        font-size: 11px;
        color: #999;
        margin-top: 4px;
        font-weight: 500;
      }

      /* ===== PASSWORD TOGGLE ===== */
      .password-wrapper {
        position: relative;
      }

      .password-toggle-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        transition: color 0.2s;
      }

      .password-toggle-btn:hover {
        color: #ff6b35;
      }

      .password-toggle-btn svg {
        width: 18px;
        height: 18px;
        stroke: currentColor;
        fill: none;
        stroke-width: 2.2;
        stroke-linecap: round;
        stroke-linejoin: round;
      }

      /* Adjust input padding to accommodate toggle button */
      .form-control.password-input {
        padding-right: 42px;
      }
    </style>

    <section class="page-content">
      <div class="container">
        <div class="password-layout">

          <!-- ===== HERO SECTION ===== -->
          <div class="password-hero">
            <div class="hero-brand">El Shaddai Church</div>
            <div class="icon-box">
              <svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </div>
            <h1 class="hero-title">Ubah Password</h1>
            <p class="hero-desc">Perbarui password akun Anda untuk menjaga keamanan.</p>
          </div>

          <!-- ===== FORM CARD ===== -->
          <div class="password-main-card">

            <!-- data-bv="off" dipakai sebagai penanda supaya script global tidak menempelkan BootstrapValidator ke form ini -->
            <form action="<?php echo site_url('akun/simpanubahpassword') ?>" method="post" id="formUbahPassword" data-bv="off">

              <!-- Info Box -->
              <div class="info-box">
                Gunakan password yang kuat dengan kombinasi huruf besar, kecil, angka, dan simbol.
              </div>

              <!-- Password Lama -->
              <div class="form-group-custom form-group">
                <label for="passwordlama" class="form-label">Password Lama</label>
                <div class="password-wrapper">
                  <input 
                    type="password" 
                    class="form-control password-input" 
                    id="passwordlama" 
                    name="passwordlama" 
                    placeholder="Masukkan password lama Anda"
                    required>
                  <button type="button" class="password-toggle-btn" onclick="togglePassword('passwordlama')">
                    <svg viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Password Baru -->
              <div class="form-group-custom form-group">
                <label for="passwordbaru1" class="form-label">Password Baru</label>
                <div class="password-wrapper">
                  <input 
                    type="password" 
                    class="form-control password-input" 
                    id="passwordbaru1" 
                    name="passwordbaru1" 
                    placeholder="Masukkan password baru"
                    required
                    onkeyup="checkPasswordStrength(this.value)">
                  <button type="button" class="password-toggle-btn" onclick="togglePassword('passwordbaru1')">
                    <svg viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                </div>
                <div class="password-strength">
                  <div class="strength-bar" id="strengthBar"></div>
                </div>
                <div class="strength-text" id="strengthText"></div>
              </div>

              <!-- Ulangi Password Baru -->
              <div class="form-group-custom form-group">
                <label for="passwordbaru2" class="form-label">Ulangi Password Baru</label>
                <div class="password-wrapper">
                  <input 
                    type="password" 
                    class="form-control password-input" 
                    id="passwordbaru2" 
                    name="passwordbaru2" 
                    placeholder="Ulangi password baru Anda"
                    required
                    onchange="validatePasswordMatch()">
                  <button type="button" class="password-toggle-btn" onclick="togglePassword('passwordbaru2')">
                    <svg viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                      <circle cx="12" cy="12" r="3"/>
                    </svg>
                  </button>
                </div>
              </div>

              <!-- Button Group -->
              <div class="button-group">
                <button type="submit" class="btn-custom btn-primary-custom">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                  </svg>
                  Simpan
                </button>
                <a href="<?php echo site_url('akun/profil') ?>" class="btn-custom btn-secondary-custom">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                  </svg>
                  Kembali
                </a>
              </div>

            </form>

          </div><!-- /.password-main-card -->
        </div><!-- /.password-layout -->
      </div><!-- /.container -->
    </section>

    <script>
      // ===== GUARD: matikan BootstrapValidator kalau ke-attach otomatis oleh script global =====
      // Form ini sudah punya validasi manual sendiri (checkPasswordStrength, validatePasswordMatch, dll),
      // jadi BootstrapValidator tidak dibutuhkan dan justru menyebabkan error karena struktur
      // form ini pakai class "form-group-custom", bukan struktur default Bootstrap yang diharapkan library itu.
      (function () {
        var $form = window.jQuery ? jQuery('#formUbahPassword') : null;
        if ($form && $form.data('bootstrapValidator')) {
          try {
            $form.bootstrapValidator('destroy');
          } catch (e) {
            console.warn('Gagal destroy bootstrapValidator:', e);
          }
        }
      })();

      // Toggle Show/Hide Password
      function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const toggleBtn = field.parentElement.querySelector('.password-toggle-btn');
        
        if (field.type === 'password') {
          field.type = 'text';
          toggleBtn.innerHTML = `
            <svg viewBox="0 0 24 24">
              <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
              <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
          `;
        } else {
          field.type = 'password';
          toggleBtn.innerHTML = `
            <svg viewBox="0 0 24 24">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
              <circle cx="12" cy="12" r="3"/>
            </svg>
          `;
        }
      }

      // Password Strength Indicator
      function checkPasswordStrength(password) {
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;

        const strengthPercent = (strength / 5) * 100;
        strengthBar.style.width = strengthPercent + '%';

        if (password.length === 0) {
          strengthBar.style.width = '0%';
          strengthText.textContent = '';
        } else if (strength <= 2) {
          strengthBar.style.backgroundColor = '#ff6b6b';
          strengthText.textContent = 'Lemah';
        } else if (strength === 3) {
          strengthBar.style.backgroundColor = '#ffa94d';
          strengthText.textContent = 'Sedang';
        } else {
          strengthBar.style.backgroundColor = '#51cf66';
          strengthText.textContent = 'Kuat';
        }
      }

      // Validasi Password Match
      function validatePasswordMatch() {
        const pwd1 = document.getElementById('passwordbaru1').value;
        const pwd2 = document.getElementById('passwordbaru2').value;
        
        if (pwd1 && pwd2 && pwd1 !== pwd2) {
          alert('Password baru tidak cocok!');
          document.getElementById('passwordbaru2').focus();
        }
      }

      // Form Submit Handler
      document.getElementById('formUbahPassword').addEventListener('submit', function(e) {
        const passwordlama = document.getElementById('passwordlama').value;
        const passwordbaru1 = document.getElementById('passwordbaru1').value;
        const passwordbaru2 = document.getElementById('passwordbaru2').value;

        if (!passwordlama || !passwordbaru1 || !passwordbaru2) {
          e.preventDefault();
          alert('Semua field harus diisi!');
          return;
        }

        if (passwordbaru1 !== passwordbaru2) {
          e.preventDefault();
          alert('Password baru tidak cocok!');
          return;
        }

        if (passwordbaru1.length < 8) {
          e.preventDefault();
          alert('Password baru minimal 8 karakter!');
          return;
        }
      });
    </script>

    <?php $this->load->view('template/festavalive/footer'); ?>
  </main>
</body>

</html>