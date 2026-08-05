<!-- ============================================================
     MODAL REGISTRASI - REDESIGN MOBILE-FRIENDLY
     Mengganti SmartWizard dengan custom stepper ringan
     Semua logic PHP/JS backend dipertahankan
     + STEP 4: VERIFIKASI OTP WHATSAPP (ganti dari link ke kode)
     ============================================================ -->

     <style>
  /* ===== VARIABEL WARNA ===== */
  :root {
    --orange: #ff5008;
    --orange-light: #fff3ee;
    --orange-dark: #e04400;
    --gray-bg: #f7f8fa;
    --gray-border: #e8eaed;
    --gray-text: #6b7280;
    --dark: #111827;
    --radius: 16px;
  }

  /* ===== MODAL WRAPPER ===== */
  #registrasiModal .modal-dialog {
    margin: 0 auto;
    max-width: 520px;
  }

  #registrasiModal .modal-content {
    border: none;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(0,0,0,0.18);
  }

  @media (max-width: 576px) {
    #registrasiModal .modal-dialog {
      margin: 8px;
      max-width: 100%;
    }
    #registrasiModal .modal-content {
      border-radius: 20px;
      max-height: 96vh;
      overflow-y: auto;
    }
  }

  /* ===== HEADER ===== */
  .reg-header {
    background: linear-gradient(135deg, #ff6a20 0%, #ff5008 100%);
    padding: 28px 28px 20px;
    color: #fff;
    position: relative;
  }

  .reg-header-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
  }

  .reg-header-logo {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .reg-header-logo img {
    width: 36px;
    height: 36px;
    filter: brightness(0) invert(1);
  }

  .reg-header-logo span {
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 1px;
  }

  .reg-header-close {
    background: rgba(255,255,255,0.2);
    border: none;
    color: #fff;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 16px;
    transition: background 0.2s;
  }

  .reg-header-close:hover {
    background: rgba(255,255,255,0.35);
  }

  /* ===== STEP INDICATOR ===== */
  .reg-steps {
    display: flex;
    align-items: center;
    gap: 0;
  }

  .reg-step-item {
    display: flex;
    align-items: center;
    flex: 1;
  }

  .reg-step-circle {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255,255,255,0.25);
    color: rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
    transition: all 0.3s;
    border: 2px solid rgba(255,255,255,0.3);
  }

  .reg-step-circle.active {
    background: #fff;
    color: var(--orange);
    border-color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }

  .reg-step-circle.done {
    background: rgba(255,255,255,0.9);
    color: var(--orange);
    border-color: rgba(255,255,255,0.9);
  }

  .reg-step-line {
    flex: 1;
    height: 2px;
    background: rgba(255,255,255,0.25);
    margin: 0 6px;
    transition: background 0.3s;
  }

  .reg-step-line.done {
    background: rgba(255,255,255,0.8);
  }

  .reg-step-label {
    font-size: 10px;
    color: rgba(255,255,255,0.75);
    margin-top: 4px;
    text-align: center;
    font-weight: 500;
  }

  .reg-step-label.active {
    color: #fff;
    font-weight: 700;
  }

  .reg-step-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
  }

  /* ===== BODY ===== */
  .reg-body {
    padding: 0;
    background: var(--gray-bg);
  }

  /* ===== PANEL PER STEP ===== */
  .reg-panel {
    display: none;
    padding: 24px 28px 100px;
    animation: fadeSlide 0.3s ease;
  }

  .reg-panel.active {
    display: block;
  }

  @keyframes fadeSlide {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 576px) {
    .reg-panel {
      padding: 20px 20px 110px;
    }
  }

  /* ===== JUDUL STEP ===== */
  .reg-panel-title {
    font-size: 20px;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 4px;
  }

  .reg-panel-subtitle {
    font-size: 13px;
    color: var(--gray-text);
    margin-bottom: 24px;
  }

  /* ===== CARD PILIHAN (step 1) ===== */
  .reg-choice-card {
    background: #fff;
    border: 2px solid var(--gray-border);
    border-radius: var(--radius);
    padding: 18px 20px;
    margin-bottom: 12px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.2s;
    position: relative;
  }

  .reg-choice-card:hover {
    border-color: var(--orange);
    background: var(--orange-light);
  }

  .reg-choice-card.selected {
    border-color: var(--orange);
    background: var(--orange-light);
  }

  .reg-choice-card input[type="radio"] {
    width: 20px;
    height: 20px;
    accent-color: var(--orange);
    flex-shrink: 0;
  }

  .reg-choice-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--orange-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
  }

  .reg-choice-text strong {
    display: block;
    font-size: 15px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 2px;
  }

  .reg-choice-text span {
    font-size: 12px;
    color: var(--gray-text);
    line-height: 1.4;
  }

  /* ===== INPUT FIELD ===== */
  .reg-field {
    margin-bottom: 16px;
  }

  .reg-field label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
  }

  .reg-field label .req {
    color: var(--orange);
    margin-left: 2px;
  }

  .reg-input {
    width: 100%;
    height: 50px;
    border: 1.5px solid var(--gray-border);
    border-radius: 12px;
    padding: 0 16px;
    font-size: 15px;
    background: #fff;
    color: var(--dark);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    -webkit-appearance: none;
    appearance: none;
  }

  .reg-input:focus {
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(255, 80, 8, 0.12);
  }

  .reg-input.has-error {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
  }

  .reg-error-msg {
    font-size: 12px;
    color: #ef4444;
    margin-top: 4px;
    display: none;
  }

  .reg-error-msg.show {
    display: block;
  }

  .reg-input-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }

  @media (max-width: 480px) {
    .reg-input-row {
      grid-template-columns: 1fr;
    }
  }

  /* password toggle */
  .reg-input-wrap {
    position: relative;
  }

  .reg-input-wrap .reg-input {
    padding-right: 48px;
  }

  .reg-pw-toggle {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--gray-text);
    cursor: pointer;
    font-size: 16px;
    padding: 4px;
  }

  /* ===== KONFIRMASI TABLE ===== */
  .reg-confirm-card {
    background: #fff;
    border-radius: var(--radius);
    overflow: hidden;
    border: 1.5px solid var(--gray-border);
    margin-bottom: 20px;
  }

  .reg-confirm-row {
    display: flex;
    padding: 14px 18px;
    border-bottom: 1px solid var(--gray-border);
    font-size: 14px;
  }

  .reg-confirm-row:last-child {
    border-bottom: none;
  }

  .reg-confirm-label {
    width: 40%;
    color: var(--gray-text);
    font-weight: 500;
    flex-shrink: 0;
  }

  .reg-confirm-value {
    color: var(--dark);
    font-weight: 600;
    word-break: break-word;
  }

  /* syarat */
  .reg-syarat {
    background: #fff;
    border: 1.5px solid var(--gray-border);
    border-radius: var(--radius);
    padding: 16px 18px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    cursor: pointer;
  }

  .reg-syarat input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: var(--orange);
    flex-shrink: 0;
    margin-top: 2px;
  }

  .reg-syarat label {
    font-size: 13px;
    color: #374151;
    line-height: 1.6;
    cursor: pointer;
  }

  .reg-syarat a {
    color: var(--orange);
    font-weight: 600;
    text-decoration: underline;
  }

  /* ===== FOOTER TOMBOL (FIXED) ===== */
  .reg-footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    padding: 14px 20px 20px;
    box-shadow: 0 -6px 24px rgba(0,0,0,0.1);
    z-index: 9999;
    display: flex;
    gap: 10px;
  }

  /* Di dalam modal, footer tidak fixed tapi sticky */
  #registrasiModal .reg-footer {
    position: sticky;
    bottom: 0;
    box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
    border-top: 1px solid var(--gray-border);
  }

  .reg-btn {
    flex: 1;
    height: 52px;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .reg-btn-prev {
    background: var(--gray-bg);
    color: #374151;
    border: 1.5px solid var(--gray-border);
    flex: 0.6;
  }

  .reg-btn-prev:hover {
    background: #e5e7eb;
  }

  .reg-btn-next {
    background: linear-gradient(135deg, #ff6a20, var(--orange));
    color: #fff;
    box-shadow: 0 4px 16px rgba(255, 80, 8, 0.3);
  }

  .reg-btn-next:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(255, 80, 8, 0.4);
  }

  .reg-btn-next:disabled {
    opacity: 0.6;
    transform: none;
    cursor: not-allowed;
  }

  .reg-btn-cancel {
    background: transparent;
    color: var(--gray-text);
    border: none;
    font-size: 13px;
    flex: 0.4;
    height: 52px;
    cursor: pointer;
  }

  /* ===== ALERT ===== */
  .reg-alert {
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 13px;
    color: #dc2626;
    margin-bottom: 16px;
    display: none;
  }

  .reg-alert.show {
    display: block;
  }


  /* ===== FIX TOMBOL FOOTER DI MOBILE ===== */
  .reg-btn {
    white-space: nowrap;
  }

  .reg-footer {
    flex-wrap: nowrap;
  }

  @media (max-width: 480px) {
    .reg-footer {
      padding: 10px 14px 14px;
      gap: 8px;
    }

    .reg-btn {
      height: 46px;
      font-size: 13px;
      padding: 0 8px;
      gap: 5px;
    }

    .reg-btn svg,
    .reg-btn i {
      font-size: 12px;
    }

    .reg-btn-cancel {
      flex: 0 0 auto;
      width: 64px;
      font-size: 12px;
    }

    .reg-btn-prev {
      flex: 0 0 auto;
      width: 90px;
    }

    .reg-btn-next {
      flex: 1;
      min-width: 0;
    }
  }
</style>


<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
     id="registrasiModal" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- HEADER + STEP INDICATOR -->
      <div class="reg-header">
        <div class="reg-header-top">
          <div class="reg-header-logo">
            <img src="<?php echo base_url('myesc.id/images/icon.png') ?>" alt="Logo">
            <span>MYESC</span>
          </div>
          <button class="reg-header-close" onclick="onCancel()">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <!-- Step Indicator -->
        <div class="reg-steps">
          <div class="reg-step-wrapper">
            <div class="reg-step-circle active" id="stepCircle1">1</div>
            <div class="reg-step-label active" id="stepLabel1">Mulai</div>
          </div>
          <div class="reg-step-line" id="stepLine1"></div>
          <div class="reg-step-wrapper">
            <div class="reg-step-circle" id="stepCircle2">2</div>
            <div class="reg-step-label" id="stepLabel2">Data Diri</div>
          </div>
          <div class="reg-step-line" id="stepLine2"></div>
          <div class="reg-step-wrapper">
            <div class="reg-step-circle" id="stepCircle3">3</div>
            <div class="reg-step-label" id="stepLabel3">Konfirmasi</div>
          </div>
          <div class="reg-step-line" id="stepLine3"></div>
          <div class="reg-step-wrapper">
            <div class="reg-step-circle" id="stepCircle4">4</div>
            <div class="reg-step-label" id="stepLabel4">Verifikasi</div>
          </div>
        </div>
      </div>

      <!-- BODY -->
      <div class="reg-body">

        <!-- ========== STEP 1 ========== -->
        <div class="reg-panel active" id="regPanel1">
          <div class="reg-panel-title">Selamat Datang!</div>
          <div class="reg-panel-subtitle">Sudah pernah membuat Kartu Anggota Jemaat ESC?</div>

          <label class="reg-choice-card selected" for="sudahpernahfondationclass1" id="card_sudah">
            <input type="radio" name="sudahpernahfondationclass"
                   id="sudahpernahfondationclass1" value="1">
            
            <div class="reg-choice-text">
              <strong>Sudah Pernah</strong>
              <span>Saya sudah memiliki Kartu Anggota Jemaat ESC sebelumnya</span>
            </div>
          </label>

          <label class="reg-choice-card" for="sudahpernahfondationclass2" id="card_belum">
            <input type="radio" name="sudahpernahfondationclass"
                   id="sudahpernahfondationclass2" value="2" checked>
            
            <div class="reg-choice-text">
              <strong>Belum Pernah</strong>
              <span>Ini pertama kali saya mendaftar di ESC</span>
            </div>
          </label>

          <!-- hidden radio alasanmembuatakun (tetap ada untuk logic JS) -->
          <input type="radio" name="alasanmembuatakun" id="alasanmembuatakun2"
                 value="2" checked style="display:none">
        </div>

        <!-- ========== STEP 2 ========== -->
        <div class="reg-panel" id="regPanel2">
          <div class="reg-panel-title">Data Diri</div>
          <div class="reg-panel-subtitle">Lengkapi informasi akun Anda</div>

          <div id="regAlert" class="reg-alert"></div>

          <form id="formBuatAkun" action="#" method="POST" novalidate>

            <div class="reg-field">
              <label>Nama Lengkap <span class="req">*</span></label>
              <input type="text" class="reg-input" id="namalengkap" name="namalengkap"
                     placeholder="Masukkan nama lengkap Anda">
              <div class="reg-error-msg" id="err_namalengkap">Nama lengkap tidak boleh kosong</div>
            </div>

            <div class="reg-field divnik">
              <label>NIK (KTP) <span class="req">*</span></label>
              <input type="text" class="reg-input" id="nik" name="nik"
                     maxlength="16" placeholder="16 digit Nomor Induk Kependudukan">
              <div class="reg-error-msg" id="err_nik">NIK harus 16 digit</div>
            </div>

            <div class="reg-input-row">
              <div class="reg-field">
                <label>Jenis Kelamin <span class="req">*</span></label>
                <select class="reg-input" id="jeniskelamin" name="jeniskelamin">
                  <option value="">Pilih...</option>
                  <option value="Laki-laki">Laki-laki</option>
                  <option value="Perempuan">Perempuan</option>
                </select>
                <div class="reg-error-msg" id="err_jeniskelamin">Pilih jenis kelamin</div>
              </div>

              <div class="reg-field divtempatlahir">
                <label>Tempat Lahir <span class="req">*</span></label>
                <input type="text" class="reg-input" id="tempatlahir" name="tempatlahir"
                       placeholder="Kota lahir">
                <div class="reg-error-msg" id="err_tempatlahir">Tempat lahir tidak boleh kosong</div>
              </div>
            </div>

            <div class="reg-input-row">
              <div class="reg-field divtgllahir">
                <label>Tanggal Lahir <span class="req">*</span></label>
                <input type="date" class="reg-input" id="tanggallahir" name="tanggallahir">
                <div class="reg-error-msg" id="err_tanggallahir">Tanggal lahir tidak boleh kosong</div>
              </div>

              <div class="reg-field divnohp">
                <label>Nomor WhatsApp <span class="req">*</span></label>
                <input type="tel" class="reg-input" id="nohp" name="nohp"
                       placeholder="08xxxxxxxxxx">
                <div class="reg-error-msg" id="err_nohp">Nomor WhatsApp tidak boleh kosong</div>
              </div>
            </div>

            <div class="reg-field divalamatrumah">
              <label>Alamat Tempat Tinggal <span class="req">*</span></label>
              <input type="text" class="reg-input" id="alamatrumah" name="alamatrumah"
                     placeholder="Jl. Contoh No. 1, Kota">
              <div class="reg-error-msg" id="err_alamatrumah">Alamat tidak boleh kosong</div>
            </div>

            <div class="reg-field">
              <label>Email <span class="req">*</span></label>
              <input type="email" class="reg-input" id="email" name="email"
                     placeholder="email@contoh.com">
              <div class="reg-error-msg" id="err_email">Email tidak boleh kosong</div>
            </div>

            <div class="reg-input-row">
              <div class="reg-field">
                <label>Password <span class="req">*</span></label>
                <div class="reg-input-wrap">
                  <input type="password" class="reg-input" id="password" name="password"
                         placeholder="Min. 6 karakter">
                  <button type="button" class="reg-pw-toggle" onclick="togglePw('password', this)">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                <div class="reg-error-msg" id="err_password">Password min. 6 karakter</div>
              </div>

              <div class="reg-field">
                <label>Konfirmasi Password <span class="req">*</span></label>
                <div class="reg-input-wrap">
                  <input type="password" class="reg-input" id="password2" name="password2"
                         placeholder="Ulangi password">
                  <button type="button" class="reg-pw-toggle" onclick="togglePw('password2', this)">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
                <div class="reg-error-msg" id="err_password2">Password tidak cocok</div>
              </div>
            </div>

          </form>
        </div>

        <!-- ========== STEP 3 ========== -->
        <div class="reg-panel" id="regPanel3">
          <div class="reg-panel-title">Konfirmasi Data</div>
          <div class="reg-panel-subtitle">Periksa kembali data Anda sebelum mendaftar</div>

          <div class="reg-confirm-card">
            <div class="reg-confirm-row">
              <div class="reg-confirm-label">Nama Lengkap</div>
              <div class="reg-confirm-value" id="tdDaftarNamaLengkap"></div>
            </div>
            <div class="reg-confirm-row divnik">
              <div class="reg-confirm-label">NIK</div>
              <div class="reg-confirm-value" id="tdDaftarNIK"></div>
            </div>
            <div class="reg-confirm-row">
              <div class="reg-confirm-label">Jenis Kelamin</div>
              <div class="reg-confirm-value" id="tdDaftarJenisKelamin"></div>
            </div>
            <div class="reg-confirm-row divtempatlahir">
              <div class="reg-confirm-label">Tempat Lahir</div>
              <div class="reg-confirm-value" id="tdDaftarTempatLahir"></div>
            </div>
            <div class="reg-confirm-row divtgllahir">
              <div class="reg-confirm-label">Tanggal Lahir</div>
              <div class="reg-confirm-value" id="tdDaftarTanggalLahir"></div>
            </div>
            <div class="reg-confirm-row divalamatrumah">
              <div class="reg-confirm-label">Alamat</div>
              <div class="reg-confirm-value" id="tdDaftarAlamatRumah"></div>
            </div>
            <div class="reg-confirm-row">
              <div class="reg-confirm-label">No. WhatsApp</div>
              <div class="reg-confirm-value" id="tdDaftarNomorHP"></div>
            </div>
            <div class="reg-confirm-row">
              <div class="reg-confirm-label">Email</div>
              <div class="reg-confirm-value" id="tdDaftarEmail"></div>
            </div>
          </div>

          <label class="reg-syarat">
            <input type="checkbox" id="chkSyaratDanKetentuan" value="1">
            <span>Saya telah membaca dan menyetujui
              <a href="<?php echo base_url('myesc.id/TermsandConditions.html') ?>"
                 target="_blank">Syarat dan Ketentuan GBI El Shaddai</a>
            </span>
          </label>

          <p class="recaptcha-disclaimer">
            Situs ini dilindungi reCAPTCHA dan
            <a href="https://policies.google.com/privacy" target="_blank">Kebijakan Privasi</a>
            dan
            <a href="https://policies.google.com/terms" target="_blank">Persyaratan Layanan</a>
            Google.
          </p>
        
        </div>

        <!-- ========== STEP 4: VERIFIKASI OTP (SATU KARTU, TAB WA/EMAIL) ========== -->
        <div class="reg-panel" id="regPanel4">
          <div class="reg-panel-title">Verifikasi Akun</div>
          <div class="reg-panel-subtitle">
            Pilih cara menerima kode, lalu masukkan 6 digit kode untuk mengaktifkan akun kamu.
          </div>

          <!-- ===== TAB SWITCHER ===== -->
          <div style="display:flex; gap:8px; margin-bottom:16px;">
            <button type="button" class="reg-btn" id="tabOtpWa"
                    style="flex:1; height:44px; background: var(--orange); color:#fff;">
              <i class="fab fa-whatsapp"></i> WhatsApp
              <i class="fas fa-check-circle" id="iconCheckWa" style="display:none; margin-left:4px;"></i>
            </button>
            <button type="button" class="reg-btn" id="tabOtpEmail"
                    style="flex:1; height:44px; background: var(--gray-bg); color:#374151; border:1.5px solid var(--gray-border);">
              <i class="fas fa-envelope"></i> Email
              <i class="fas fa-check-circle" id="iconCheckEmail" style="display:none; margin-left:4px;"></i>
            </button>
          </div>

          <!-- ===== KARTU OTP (ISI BERUBAH SESUAI TAB AKTIF) ===== -->
          <div class="reg-confirm-card" style="padding: 18px 20px;">
            <div style="font-size:13px; color: var(--gray-text); margin-bottom:12px;">
              Kode telah dikirim ke <strong id="otpTujuanAktif"></strong>
            </div>

            <div id="otpAlert" class="reg-alert" style="margin-bottom:10px;"></div>

            <div class="reg-field" style="margin-bottom:12px;">
              <input type="text" class="reg-input" id="otpInput" maxlength="6"
                     inputmode="numeric" pattern="[0-9]*"
                     placeholder="Masukkan 6 digit kode"
                     style="letter-spacing: 8px; font-size: 20px; text-align: center; font-weight: 700;">
            </div>

            <button type="button" class="reg-btn reg-btn-next" id="btnVerifikasiOtp" style="width:100%; height:48px;">
              <i class="fas fa-check"></i> Verifikasi & Selesaikan Pendaftaran
            </button>

            <div style="text-align: center; margin-top: 14px;">
              <span style="font-size: 12px; color: var(--gray-text);">Tidak menerima kode? </span>
              <a href="javascript:void(0)" id="btnKirimUlangOtp"
                 style="font-size: 12px; font-weight: 700; color: var(--orange); text-decoration: underline;">
                Kirim Ulang
              </a>
              <span id="otpCountdown" style="font-size: 12px; color: var(--gray-text); display:none;"></span>
            </div>
          </div>

          <div id="otpSelesaiHint" style="text-align:center; margin-top:16px; font-size:12px; color: var(--gray-text);">
            Pastikan anda memiliki akses ke WhatsApp atau Email yang terdaftar. jika anda tidak menerima kode, silahkan kirim ulang.
          </div>
        </div>

      </div><!-- /reg-body -->

      <!-- FOOTER TOMBOL -->
      <div class="reg-footer" id="regFooter">
        <button class="reg-btn reg-btn-cancel" onclick="onCancel()" id="regBtnCancel">
          Batal
        </button>
        <button class="reg-btn reg-btn-prev" id="regBtnPrev" onclick="regPrev()" style="display:none">
          <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <button class="reg-btn reg-btn-next" id="regBtnNext" onclick="regNext()">
          Selanjutnya <i class="fas fa-arrow-right"></i>
        </button>
      </div>

    </div>
  </div>
</div>


<script>
/* ============================================================
   CUSTOM STEPPER LOGIC
   Menggantikan SmartWizard sepenuhnya
   Total 4 step: Mulai -> Data Diri -> Konfirmasi -> Verifikasi OTP
   ============================================================ */

var regCurrentStep = 1;
var regTotalSteps  = 4;

// Daftar field wajib per step (diisi/disembunyikan sesuai kondisi)
function getRequiredFields() {
  var isSudah = $('#sudahpernahfondationclass1').prop('checked');
  var fields = ['namalengkap', 'jeniskelamin', 'email', 'password', 'password2', 'nohp', 'tanggallahir'];
  if (isSudah) {
    fields.push('nik', 'tempatlahir', 'alamatrumah');
  }
  return fields;
}

function regGoTo(step) {
  // Sembunyikan semua panel
  for (var i = 1; i <= regTotalSteps; i++) {
    $('#regPanel' + i).removeClass('active');
  }
  // Tampilkan panel aktif
  $('#regPanel' + step).addClass('active');
  regCurrentStep = step;

  // Update step indicator
  for (var i = 1; i <= regTotalSteps; i++) {
    var circle = $('#stepCircle' + i);
    var label  = $('#stepLabel' + i);
    circle.removeClass('active done');
    label.removeClass('active');

    if (i < step) {
      circle.addClass('done').html('<i class="fas fa-check" style="font-size:11px"></i>');
    } else if (i === step) {
      circle.addClass('active').html(i);
      label.addClass('active');
    } else {
      circle.html(i);
    }
  }

  // Update garis
  for (var i = 1; i < regTotalSteps; i++) {
    if (i < step) {
      $('#stepLine' + i).addClass('done');
    } else {
      $('#stepLine' + i).removeClass('done');
    }
  }

  // Update tombol sesuai step
  $('#regFooter').show(); // pastikan footer tampil lagi kalau kembali dari step 4

  if (step === 1) {
    $('#regBtnPrev').hide();
    $('#regBtnCancel').show();
    $('#regBtnNext').show();
    $('#regBtnNext').html('Selanjutnya <i class="fas fa-arrow-right"></i>');
  } else if (step === 3) {
    $('#regBtnPrev').show();
    $('#regBtnCancel').hide();
    $('#regBtnNext').show();
    $('#regBtnNext').html('<i class="fas fa-paper-plane"></i> Daftar Sekarang');
    // Isi data konfirmasi
    regIsiKonfirmasi();
  } else if (step === 4) {
    // Step OTP: sembunyikan SELURUH footer, satu-satunya aksi adalah
    // tombol "Verifikasi Kode" di dalam kartu (menghindari 2 tombol membingungkan)
    $('#regFooter').hide();
  } else {
    $('#regBtnPrev').show();
    $('#regBtnCancel').hide();
    $('#regBtnNext').show();
    $('#regBtnNext').html('Selanjutnya <i class="fas fa-arrow-right"></i>');
  }


  // Scroll ke atas modal
  $('#registrasiModal .modal-content').scrollTop(0);
}

function regNext() {
  if (regCurrentStep === 1) {
    regGoTo(2);
  } else if (regCurrentStep === 2) {
    if (regValidasiStep2()) {
      regGoTo(3);
    }
  } else if (regCurrentStep === 3) {
    onFinish();
  } else if (regCurrentStep === 4) {
    onSelesaiRegistrasi();
  }
}

function regPrev() {
  if (regCurrentStep > 1) {
    regGoTo(regCurrentStep - 1);
  }
}

// ===== VALIDASI STEP 2 =====
function regValidasiStep2() {
  var valid = true;
  var isSudah = $('#sudahpernahfondationclass1').prop('checked');

  // Reset semua error
  $('.reg-input').removeClass('has-error');
  $('.reg-error-msg').removeClass('show');

  function cekField(id, errId, minLen) {
    var val = $('#' + id).val().trim();
    if (!val || (minLen && val.length < minLen)) {
      $('#' + id).addClass('has-error');
      $('#' + errId).addClass('show');
      valid = false;
    }
  }

  function cekNomorHP() {
    var val = $('#nohp').val().trim();
    // Hanya boleh angka, wajib diawali 08, panjang wajar 10-15 digit
    var isValid = /^08[0-9]{8,13}$/.test(val);

    if (!isValid) {
      $('#nohp').addClass('has-error');
      $('#err_nohp')
        .text('Nomor WhatsApp harus diawali 08 dan hanya berisi angka (tanpa +62, spasi, atau simbol)')
        .addClass('show');
      valid = false;
    }
  }

  cekField('namalengkap', 'err_namalengkap');
  cekField('jeniskelamin', 'err_jeniskelamin');
  cekField('email', 'err_email');
  cekNomorHP();
  cekField('tanggallahir', 'err_tanggallahir');

  // NIK, tempatlahir, alamatrumah hanya wajib kalau sudah
  if (isSudah) {
    var nik = $('#nik').val().trim();
    if (nik.length !== 16) {
      $('#nik').addClass('has-error');
      $('#err_nik').addClass('show');
      valid = false;
    }
    cekField('tempatlahir', 'err_tempatlahir');
    cekField('alamatrumah', 'err_alamatrumah');
  }

  // password
  var pw  = $('#password').val();
  var pw2 = $('#password2').val();
  if (pw.length < 6) {
    $('#password').addClass('has-error');
    $('#err_password').addClass('show');
    valid = false;
  }
  if (pw !== pw2) {
    $('#password2').addClass('has-error');
    $('#err_password2').addClass('show');
    valid = false;
  }

  if (!valid) {
    var alertEl = $('#regAlert');
    alertEl.text('Harap lengkapi semua field yang wajib diisi.').addClass('show');
    setTimeout(function() { alertEl.removeClass('show'); }, 3000);
  } else {
    $('#regAlert').removeClass('show');
  }

  return valid;
}

// ===== ISI DATA KONFIRMASI =====
function regIsiKonfirmasi() {
  $('#tdDaftarNamaLengkap').text($('#namalengkap').val());
  $('#tdDaftarNIK').text($('#nik').val());
  $('#tdDaftarJenisKelamin').text($('#jeniskelamin').val());
  $('#tdDaftarTempatLahir').text($('#tempatlahir').val());
  $('#tdDaftarTanggalLahir').text($('#tanggallahir').val());
  $('#tdDaftarAlamatRumah').text($('#alamatrumah').val());
  $('#tdDaftarNomorHP').text($('#nohp').val());
  $('#tdDaftarEmail').text($('#email').val());
}

// ===== TOGGLE PILIHAN CARD STEP 1 =====
$(document).on('change', 'input[name="sudahpernahfondationclass"]', function() {
  if ($('#sudahpernahfondationclass1').prop('checked')) {
    $('#card_sudah').addClass('selected');
    $('#card_belum').removeClass('selected');
    $('.divnik, .divtempatlahir, .divalamatrumah').show();
  } else {
    $('#card_belum').addClass('selected');
    $('#card_sudah').removeClass('selected');
    $('.divnik, .divtempatlahir, .divalamatrumah').hide();
  }
  alasanmembuatakun();
});

// Set visual awal
$(document).ready(function() {
  // Default: belum → sembunyikan field nik dll
  alasanmembuatakun();
  regGoTo(1);
  // Reset saat modal dibuka
  $('#registrasiModal').on('show.bs.modal', function() {
    regGoTo(1);
    kosongkanText();
    $('.reg-input').removeClass('has-error');
    $('.reg-error-msg').removeClass('show');
    $('#regAlert').removeClass('show');

    // Reset state OTP
    $('#otpAlert').removeClass('show');
    $('#otpInput').val('').prop('disabled', false);
    $('#btnVerifikasiOtp').prop('disabled', false).html('Verifikasi Kode');
    $('#btnKirimUlangOtp').show();
    $('#otpCountdown').hide();
    $('#iconCheckWa, #iconCheckEmail').hide();
    clearInterval(otpCountdownTimer);
    window.otpWaVerified = false;
    window.otpEmailVerified = false;
    window.otpTabAktif = 'wa';

    $('#chkSyaratDanKetentuan').prop('checked', false);
    $('#sudahpernahfondationclass2').prop('checked', true).trigger('change');
  });
});

// ===== AUTO-NORMALISASI NOMOR WHATSAPP =====
$(document).on('input', '#nohp', function() {
  var val = $(this).val();
  val = val.replace(/[^\d+]/g, '');       // buang semua kecuali angka dan '+'
  val = val.replace(/^\+62/, '0');        // +62xxx -> 0xxx
  val = val.replace(/^62/, '0');          // 62xxx  -> 0xxx
  val = val.replace(/\+/g, '');           // buang sisa '+' yang nyangkut
  $(this).val(val);
});

// ===== PASSWORD TOGGLE =====
function togglePw(inputId, btn) {
  var input = document.getElementById(inputId);
  var icon  = btn.querySelector('i');
  if (input.type === 'password') {
    input.type = 'text';
    icon.classList.replace('fa-eye', 'fa-eye-slash');
  } else {
    input.type = 'password';
    icon.classList.replace('fa-eye-slash', 'fa-eye');
  }
}

// ===== onFinish - KIRIM DATA (dengan reCAPTCHA), lanjut ke step OTP =====
function onFinish() {
  if (!$('#chkSyaratDanKetentuan').prop('checked')) {
    swal("Syarat Dan Ketentuan",
         "Anda harus membaca dan menyetujui syarat dan ketentuan terlebih dahulu", "info");
    return;
  }

  if (typeof grecaptcha === 'undefined') {
    swal("Error", "Sistem verifikasi keamanan gagal dimuat. Silakan refresh halaman dan coba lagi.", "error");
    return;
  }

  $('#regBtnNext').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

  grecaptcha.ready(function() {
    grecaptcha.execute('6Lee0W8tAAAAABG8ld1IaYBdmW2IN0xM3lIH5NON', {action: 'registrasi'}).then(function(token) {

      var sudahpernahfondationclass = $('#sudahpernahfondationclass1').prop('checked') ? 'Sudah' : 'Belum';
      var alasanmembuatakun         = $('#alasanmembuatakun1').prop('checked') ? 'Berkunjung' : 'Bergabung';

      var formData = {
        namalengkap             : $('#namalengkap').val(),
        nik                     : $('#nik').val(),
        jeniskelamin            : $('#jeniskelamin').val(),
        tempatlahir             : $('#tempatlahir').val(),
        tanggallahir            : $('#tanggallahir').val(),
        alamatrumah             : $('#alamatrumah').val(),
        nohp                    : $('#nohp').val(),
        email                   : $('#email').val(),
        password                : $('#password').val(),
        alasanmembuatakun       : alasanmembuatakun,
        sudahpernahfondationclass: sudahpernahfondationclass,
        'g-recaptcha-response'  : token,
      };

      $.ajax({
          url     : '<?= site_url('login/simpanregistrasi') ?>',
          type    : 'POST',
          dataType: 'json',
          data    : formData,
        })
        .done(function(response) {
          if (response.success) {
            // Simpan idjemaat terenkripsi & data tujuan untuk step verifikasi OTP
            window.currentIdJemaatEnc = response.idjemaat;
            window.otpWaVerified = false;
            window.otpEmailVerified = false;
            window.otpNohpTujuan = $('#nohp').val();
            window.otpEmailTujuanVal = $('#email').val();
            window.otpTabAktif = 'wa'; // default tab pertama kali dibuka

            switchOtpTab('wa');
            regGoTo(4);
          } else {
            swal("Gagal", response.msg, "info");
          }
        })
        .fail(function() {
          swal("Error", "Terjadi kesalahan, coba lagi.", "error");
        })
        .always(function() {
          $('#regBtnNext').prop('disabled', false)
            .html('<i class="fas fa-paper-plane"></i> Daftar Sekarang');
        });

    });
  });
}


// ===== SWITCH TAB (WA <-> Email) =====
function switchOtpTab(tipe) {
  window.otpTabAktif = tipe;
  $('#otpInput').val('');
  $('#otpAlert').removeClass('show');

  if (tipe === 'wa') {
    $('#tabOtpWa').css({ background: 'var(--orange)', color: '#fff', border: 'none' });
    $('#tabOtpEmail').css({ background: 'var(--gray-bg)', color: '#374151', border: '1.5px solid var(--gray-border)' });
    $('#otpTujuanAktif').text(window.otpNohpTujuan);
  } else {
    $('#tabOtpEmail').css({ background: 'var(--orange)', color: '#fff', border: 'none' });
    $('#tabOtpWa').css({ background: 'var(--gray-bg)', color: '#374151', border: '1.5px solid var(--gray-border)' });
    $('#otpTujuanAktif').text(window.otpEmailTujuanVal);
  }

  // Tampilkan status terverifikasi jika kanal ini sudah pernah diverifikasi
  var sudahVerified = (tipe === 'wa') ? window.otpWaVerified : window.otpEmailVerified;
  if (sudahVerified) {
    $('#otpInput').prop('disabled', true).val('••••••');
    $('#btnVerifikasiOtp').prop('disabled', true).html('<i class="fas fa-check"></i> Sudah Terverifikasi');
    $('#btnKirimUlangOtp, #otpCountdown').hide();
  } else {
    $('#otpInput').prop('disabled', false).val('');
    $('#btnVerifikasiOtp').prop('disabled', false).html('Verifikasi Kode');
    startOtpCountdown(tipe);
  }
}

$(document).on('click', '#tabOtpWa', function() {
  if (window.otpTabAktif !== 'wa') switchOtpTab('wa');
});

$(document).on('click', '#tabOtpEmail', function() {
  if (window.otpTabAktif !== 'email') switchOtpTab('email');
});

$(document).on('click', '#btnVerifikasiOtp', function() {
  var otp = $('#otpInput').val().trim();
  $('#otpAlert').removeClass('show');

  if (otp.length !== 6) {
    $('#otpAlert').text('Masukkan 6 digit kode OTP.').addClass('show');
    return;
  }

  var tipe = window.otpTabAktif;
  var url = (tipe === 'wa')
    ? '<?= site_url('login/verifikasiOtpWa') ?>'
    : '<?= site_url('login/verifikasiOtpEmail') ?>';

  var btn = $(this);
  btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memverifikasi...');

  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: { idjemaat: window.currentIdJemaatEnc, otp: otp }
    })
    .done(function(response) {
      if (response.success) {
        // Berhasil: langsung selesai, tidak perlu tombol tambahan lagi
        swal({
          title: "Berhasil!",
          text: "Akun kamu sudah aktif. Silakan login untuk melanjutkan.",
          icon: "success",
          button: "Login Sekarang"
        }).then(function() {
          $('#registrasiModal').modal('hide');
          // Buka modal login supaya user bisa langsung masuk
          setTimeout(function() {
            $('#loginModal').modal('show');
          }, 300);
        });
      } else {
        $('#otpAlert').text(response.msg).addClass('show');
        btn.prop('disabled', false).html('<i class="fas fa-check"></i> Verifikasi & Selesaikan Pendaftaran');
      }
    })
    .fail(function() {
      $('#otpAlert').text('Terjadi kesalahan, coba lagi.').addClass('show');
      btn.prop('disabled', false).html('<i class="fas fa-check"></i> Verifikasi & Selesaikan Pendaftaran');
    });
});

// ===== COUNTDOWN & KIRIM ULANG OTP (mengikuti tab aktif) =====
var otpCountdownTimer = null;

function startOtpCountdown(tipe) {
  var sisa = 60;
  $('#btnKirimUlangOtp').hide();
  $('#otpCountdown').show().text('Kirim ulang dalam ' + sisa + ' detik');

  clearInterval(otpCountdownTimer);
  otpCountdownTimer = setInterval(function() {
    // Hanya jalan kalau tab yang sedang dihitung masih tab aktif
    if (window.otpTabAktif !== tipe) {
      clearInterval(otpCountdownTimer);
      return;
    }
    sisa--;
    if (sisa <= 0) {
      clearInterval(otpCountdownTimer);
      $('#otpCountdown').hide();
      $('#btnKirimUlangOtp').show();
    } else {
      $('#otpCountdown').text('Kirim ulang dalam ' + sisa + ' detik');
    }
  }, 1000);
}

$(document).on('click', '#btnKirimUlangOtp', function() {
  var tipe = window.otpTabAktif;
  var url = (tipe === 'wa')
    ? '<?= site_url('login/kirimUlangOtpWa') ?>'
    : '<?= site_url('login/kirimUlangOtpEmail') ?>';

  $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      data: { idjemaat: window.currentIdJemaatEnc }
    })
    .done(function(response) {
      if (response.success) {
        var label = (tipe === 'wa') ? 'WhatsApp' : 'email';
        swal("Terkirim", "Kode OTP baru telah dikirim ke " + label + " kamu.", "success");
        $('#otpInput').val('');
        startOtpCountdown(tipe);
      } else {
        swal("Gagal", response.msg, "info");
      }
    })
    .fail(function() {
      swal("Error", "Terjadi kesalahan, coba lagi.", "error");
    });
});

// Hanya boleh angka di input OTP, dan hilangkan alert saat mulai mengetik ulang
$(document).on('input', '#otpInput', function() {
  $(this).val($(this).val().replace(/[^0-9]/g, ''));
  $('#otpAlert').removeClass('show');
});


// ===== onCancel =====
function onCancel() {
  $('#registrasiModal').modal('hide');
}

// ===== kosongkanText (tetap seperti aslinya) =====
function kosongkanText() {
  $('#namalengkap, #nik, #tempatlahir, #alamatrumah, #nohp, #email, #password, #password2')
    .val('');
  $('#jeniskelamin').val('');
  $('#tanggallahir').val('');
}

// ===== alasanmembuatakun (tetap seperti aslinya, untuk kompatibilitas) =====
function alasanmembuatakun() {
  if ($('#alasanmembuatakun1').prop('checked')) {
    $('.divsudahpernahfondationclass').hide();
    $('.divnik, .divtempatlahir, .divtgllahir, .divnohp, .divalamatrumah').hide();
  } else {
    $('.divsudahpernahfondationclass').show();
    if ($('#sudahpernahfondationclass1').prop('checked')) {
      $('.divnik, .divtempatlahir, .divtgllahir, .divalamatrumah').show();
    } else {
      $('.divnik, .divtempatlahir, .divalamatrumah').hide();
      $('.divtgllahir, .divnohp').show();
    }
  }
}
</script>