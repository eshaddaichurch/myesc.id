<!-- Animate CSS for the css animation support if needed -->
<link href="<?php echo base_url('myesc.id/assets/animate/animate.min.css') ?>" rel="stylesheet" />

<!-- Include SmartWizard CSS -->
<link href="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/css/smart_wizard_all.css" rel="stylesheet" type="text/css" />

<style>
  /* === SMARTWIZARD DESKTOP THEME (TIDAK BERUBAH) === */
  .sw-theme-square > .nav > .nav-link.active,
  .sw-theme-square > .nav > .nav-link.done {
    background-color: #ff5008 !important;
    color: white !important;
    border-color: #ff5008 !important;
  }

  .sw-theme-square > .nav > .nav-link:hover {
    background-color: #e04607 !important;
    border-color: #e04607 !important;
  }

  .sw-theme-square > .nav > .nav-link.active::after,
  .sw-theme-square > .nav > .nav-link.done::after {
    border-left-color: #ff5008 !important;
  }

  .sw-theme-square .progress-bar {
    background-color: #ff5008 !important;
  }

  .sw-theme-square > .nav > .nav-item:not(:first-child)::before {
    background-color: #ff5008 !important;
  }

  .sw-theme-square > .nav > .nav-link > .num {
    background-color: #ff5008 !important;
    color: white !important;
  }

  .sw-btn-next,
  .sw-btn-prev,
  .btn-success.btnSelesai {
    background-color: #ff5008 !important;
    border-color: #ff5008 !important;
  }

  .sw-btn-next:hover,
  .sw-btn-prev:hover,
  .btn-success.btnSelesai:hover {
    background-color: #e04607 !important;
    border-color: #e04607 !important;
  }

  .help-block {
    color: red;
  }

  .modal-custom {
    padding-bottom: 0px;
  }

  @media screen and (max-width: 480px) {
    h3.text-center {
      font-size: 15px !important;
    }
  }
</style>

<!-- MOBILE CUSTOM UI - HANYA TAMPIL DI MOBILE -->
<style>
@media screen and (max-width: 768px) {
  /* Sembunyikan UI SmartWizard asli di mobile */
  .mobile-app #smartwizard > ul.nav,
  .mobile-app #smartwizard > .progress,
  .mobile-app #smartwizard > .sw-toolbar {
    display: none !important;
  }

  /* Sembunyikan header default di mobile */
  .mobile-app .modal-body > .row > .col-12:first-child {
    display: none;
  }

  /* Mobile Custom UI */
  .mobile-custom-ui {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    z-index: 2000;
    padding-top: 60px;
    padding-bottom: 90px;
  }

  .mobile-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, #ff6d00, #ff3d00);
    color: white;
    padding: 20px 16px 12px;
    text-align: center;
    z-index: 101;
  }

  .mobile-step-indicator {
    margin-bottom: 12px;
  }
  .step-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.4);
    margin: 0 4px;
  }
  .step-dot.active {
    background: white;
  }

  .mobile-title {
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
  }

  .mobile-step-content {
    flex: 1;
    overflow-y: auto;
    padding: 0 16px;
  }

  .mobile-toolbar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    box-shadow: 0 -2px 16px rgba(0,0,0,0.08);
    z-index: 101;
  }

  .btn-mobile {
    width: 100%;
    padding: 16px;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 600;
    border: none;
    cursor: pointer;
  }

  .btn-primary {
    background: linear-gradient(135deg, #ff8100, #ff5008);
    color: white;
    box-shadow: 0 4px 12px rgba(255,129,0,0.25);
  }
  .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(255,129,0,0.4);
  }

  .btn-outline {
    background: #f1f5f9;
    color: #333;
    border: 1px solid #e2e8f0;
  }
  .btn-outline:hover {
    background: #e2e8f0;
  }

  .btn-cancel {
    background: #f9fafb;
    color: #6b7280;
    border: 1px solid #e5e7eb;
  }
  .btn-cancel:hover {
    background: #f3f4f6;
  }

  /* Konten step mirip form card */
  .mobile-step-content .card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }

  .mobile-step-content label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
  }

  .mobile-step-content .form-control,
  .mobile-step-content select {
    width: 100%;
    height: 52px;
    padding: 0 16px;
    border: 1px solid #e0e0e0;
    border-radius: 12px;
    font-size: 16px;
    background: white;
  }
  .mobile-step-content .form-control:focus,
  .mobile-step-content select:focus {
    border-color: #ff8100;
    outline: none;
    box-shadow: 0 0 0 2px rgba(255,129,0,0.15);
  }

  /* Radio button card */
  .mobile-step-content .form-check {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 16px 16px 16px 50px;
    margin-bottom: 12px;
    position: relative;
    min-height: 52px;
    display: flex;
    align-items: center;
  }
  .mobile-step-content .form-check-input {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    accent-color: #ff8100;
  }
  .mobile-step-content .form-check:has(input:checked) {
    border-color: #ff8100;
    background: #fff9f3;
  }
}
</style>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="registrasiModal" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body modal-custom">
        <div class="row">
          <div class="col-12">
            <h3 class="text-center">BUAT AKUN 'MYESC'</h3>
          </div>
          <div class="col-12 p-3">
            <!-- SmartWizard (tetap ada untuk logika, tapi disembunyikan di mobile) -->
            <div id="smartwizard">
              <ul class="nav nav-progress">
                <li class="nav-item"><a class="nav-link" href="#step-1"><div class="num">1</div> Selamat Datang</a></li>
                <li class="nav-item"><a class="nav-link" href="#step-2"><span class="num">2</span> Informasi Akun</a></li>
                <li class="nav-item"><a class="nav-link" href="#step-3"><span class="num">3</span> Konfirmasi Akun</a></li>
              </ul>

              <div class="tab-content">
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1"></div>
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2"></div>
                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3"></div>
              </div>
            </div>

            <!-- MOBILE CUSTOM UI -->
            <div class="mobile-custom-ui" style="display: none;">
              <div class="mobile-header">
                <div class="mobile-step-indicator">
                  <span class="step-dot active"></span>
                  <span class="step-dot"></span>
                  <span class="step-dot"></span>
                </div>
                <h1 id="mobile-step-title" class="mobile-title">Sudah Pernah Membuat Kartu Anggota?</h1>
              </div>
              <div class="mobile-step-content" id="mobile-content"></div>
              <div class="mobile-toolbar">
                <button id="mobile-btn-prev" class="btn-mobile btn-outline" style="display: none;">Kembali</button>
                <button id="mobile-btn-next" class="btn-mobile btn-primary">Selanjutnya</button>
                <button id="mobile-btn-submit" class="btn-mobile btn-primary" style="display: none;">Kirim</button>
                <button id="mobile-btn-cancel" class="btn-mobile btn-cancel">Batal</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include SmartWizard JavaScript -->
<script type="text/javascript" src="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/js/jquery.smartWizard.min.js"></script>

<script>
  function isMobileApp() {
    return /Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || window.innerWidth <= 768;
  }

  // === KONTEN STEP UNTUK MOBILE ===
  const mobileStepContents = {
    0: `
      <div class="card">
        <h3 class="text-center">Sudah Pernah Membuat Kartu Anggota Jemaat ESC?</h3>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="sudahpernahfondationclass" id="m_sudahpernahfondationclass1" value="1">
          <label class="form-check-label" for="m_sudahpernahfondationclass1">Sudah</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="sudahpernahfondationclass" id="m_sudahpernahfondationclass2" value="2" checked>
          <label class="form-check-label" for="m_sudahpernahfondationclass2">Belum</label>
        </div>
      </div>
    `,
    1: `
      <div class="card">
        <h3 class="text-center">Silahkan Isi Data Di Bawah Ini:</h3>
        <label>Nama Lengkap:</label>
        <input type="text" id="m_namalengkap" class="form-control" placeholder="Nama Lengkap">
        <label>NIK (KTP):</label>
        <input type="text" id="m_nik" class="form-control" placeholder="Nomor Induk Kependudukan">
        <label>Jenis Kelamin:</label>
        <select id="m_jeniskelamin" class="form-control">
          <option value="">Pilih jenis kelamin...</option>
          <option value="Laki-laki">Laki-laki</option>
          <option value="Perempuan">Perempuan</option>
        </select>
        <label>Tempat Lahir:</label>
        <input type="text" id="m_tempatlahir" class="form-control" placeholder="Tempat lahir">
        <label>Tanggal Lahir:</label>
        <input type="date" id="m_tanggallahir" class="form-control">
        <label>Alamat:</label>
        <input type="text" id="m_alamatrumah" class="form-control" placeholder="Alamat tempat tinggal">
        <label>Nomor WhatsApp:</label>
        <input type="text" id="m_nohp" class="form-control" placeholder="Contoh: 08123456789">
        <label>Email:</label>
        <input type="text" id="m_email" class="form-control" placeholder="Email">
        <label>Password:</label>
        <input type="password" id="m_password" class="form-control" placeholder="Password">
        <label>Konfirmasi Password:</label>
        <input type="password" id="m_password2" class="form-control" placeholder="Konfirmasi Password">
      </div>
    `,
    2: `
      <div class="card">
        <h3 class="text-center">Konfirmasi Data Anda:</h3>
        <table style="width:100%; background:white; border-radius:14px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.05);">
          <tr><td style="width:30%; padding:14px 16px;">Nama</td><td id="m_tdNama" style="padding:14px 16px;"></td></tr>
          <tr><td style="padding:14px 16px;">NIK</td><td id="m_tdNIK" style="padding:14px 16px;"></td></tr>
          <tr><td style="padding:14px 16px;">Jenis Kelamin</td><td id="m_tdJK" style="padding:14px 16px;"></td></tr>
          <tr><td style="padding:14px 16px;">Tempat Lahir</td><td id="m_tdTL" style="padding:14px 16px;"></td></tr>
          <tr><td style="padding:14px 16px;">Tgl Lahir</td><td id="m_tdTGL" style="padding:14px 16px;"></td></tr>
          <tr><td style="padding:14px 16px;">Alamat</td><td id="m_tdAlamat" style="padding:14px 16px;"></td></tr>
          <tr><td style="padding:14px 16px;">HP</td><td id="m_tdHP" style="padding:14px 16px;"></td></tr>
          <tr><td style="padding:14px 16px;">Email</td><td id="m_tdEmail" style="padding:14px 16px;"></td></tr>
        </table>
        <div class="form-check" style="margin-top:16px;">
          <input class="form-check-input" type="checkbox" id="m_chkSyarat">
          <label class="form-check-label">
            Saya telah membaca dan menyetujui <a href="<?php echo base_url('myesc.id/TermsandConditions.html') ?>" target="_blank">Syarat dan Ketentuan</a>
          </label>
        </div>
      </div>
    `
  };

  const mobileStepTitles = [
    "Sudah Pernah Membuat Kartu Anggota?",
    "Lengkapi Data Anda",
    "Konfirmasi Data"
  ];

  let currentMobileStep = 0;

  function updateMobileUI(stepIndex) {
    currentMobileStep = stepIndex;
    document.getElementById('mobile-step-title').innerText = mobileStepTitles[stepIndex];
    document.querySelectorAll('.step-dot').forEach((dot, i) => {
      dot.classList.toggle('active', i === stepIndex);
    });
    document.getElementById('mobile-content').innerHTML = mobileStepContents[stepIndex];
    document.getElementById('mobile-btn-prev').style.display = stepIndex === 0 ? 'none' : 'block';
    document.getElementById('mobile-btn-next').style.display = stepIndex === 2 ? 'none' : 'block';
    document.getElementById('mobile-btn-submit').style.display = stepIndex === 2 ? 'block' : 'none';
    syncToMobileUI();
  }

  function syncToMobileUI() {
    if (currentMobileStep === 0) {
      const val = $('#sudahpernahfondationclass1').prop('checked') ? '1' : '2';
      $(`#m_sudahpernahfondationclass${val}`).prop('checked', true);
    }
    if (currentMobileStep === 1) {
      $('#m_namalengkap').val($('#namalengkap').val());
      $('#m_nik').val($('#nik').val());
      $('#m_jeniskelamin').val($('#jeniskelamin').val());
      $('#m_tempatlahir').val($('#tempatlahir').val());
      $('#m_tanggallahir').val($('#tanggallahir').val());
      $('#m_alamatrumah').val($('#alamatrumah').val());
      $('#m_nohp').val($('#nohp').val());
      $('#m_email').val($('#email').val());
      $('#m_password').val($('#password').val());
      $('#m_password2').val($('#password2').val());
    }
    if (currentMobileStep === 2) {
      $('#m_tdNama').text($('#namalengkap').val());
      $('#m_tdNIK').text($('#nik').val());
      $('#m_tdJK').text($('#jeniskelamin').val());
      $('#m_tdTL').text($('#tempatlahir').val());
      $('#m_tdTGL').text($('#tanggallahir').val());
      $('#m_tdAlamat').text($('#alamatrumah').val());
      $('#m_tdHP').text($('#nohp').val());
      $('#m_tdEmail').text($('#email').val());
      $('#m_chkSyarat').prop('checked', $('#chkSyaratDanKetentuan').prop('checked'));
    }
  }

  function syncFromMobileUI() {
    if (currentMobileStep === 0) {
      const val = $('#m_sudahpernahfondationclass1').prop('checked') ? '1' : '2';
      $(`#sudahpernahfondationclass${val}`).prop('checked', true);
    }
    if (currentMobileStep === 1) {
      $('#namalengkap').val($('#m_namalengkap').val());
      $('#nik').val($('#m_nik').val());
      $('#jeniskelamin').val($('#m_jeniskelamin').val());
      $('#tempatlahir').val($('#m_tempatlahir').val());
      $('#tanggallahir').val($('#m_tanggallahir').val());
      $('#alamatrumah').val($('#m_alamatrumah').val());
      $('#nohp').val($('#m_nohp').val());
      $('#email').val($('#m_email').val());
      $('#password').val($('#m_password').val());
      $('#password2').val($('#m_password2').val());
    }
    if (currentMobileStep === 2) {
      $('#chkSyaratDanKetentuan').prop('checked', $('#m_chkSyarat').prop('checked'));
    }
  }

  // === EVENT LISTENER TOMBOL MOBILE ===
  document.getElementById('mobile-btn-prev').onclick = () => {
    syncFromMobileUI();
    $('#smartwizard').smartWizard("prev");
  };

  document.getElementById('mobile-btn-next').onclick = () => {
    syncFromMobileUI();
    if (currentMobileStep === 1) {
      const validator = $("#formBuatAkun").data("bootstrapValidator");
      validator.validate();
      if (!validator.isValid()) {
        swal("Perhatian", "Harap lengkapi data dengan benar", "warning");
        return;
      }
      if ($('#m_password').val() !== $('#m_password2').val()) {
        swal("Password", "Konfirmasi password tidak cocok", "warning");
        return;
      }
    }
    $('#smartwizard').smartWizard("next");
  };

  document.getElementById('mobile-btn-submit').onclick = () => {
    syncFromMobileUI();
    onFinish();
  };

  document.getElementById('mobile-btn-cancel').onclick = onCancel;

  // === TOGGLE TAMPILAN MOBILE ===
  function toggleMobileUI() {
    const isMobile = isMobileApp();
    document.body.classList.toggle('mobile-app', isMobile);
    const mobileUI = document.querySelector('.mobile-custom-ui');
    if (isMobile) {
      mobileUI.style.display = 'flex';
      updateMobileUI(0);
    } else {
      mobileUI.style.display = 'none';
    }
  }

  toggleMobileUI();
  window.addEventListener('resize', toggleMobileUI);
</script>

<!-- === SMARTWIZARD & FUNGSI ASLI (TIDAK DIUBAH) === -->
<script type="text/javascript">
  function onFinish() {
    var namalengkap = $('#namalengkap').val();
    var nik = $('#nik').val();
    var jeniskelamin = $('#jeniskelamin').val();
    var tempatlahir = $('#tempatlahir').val();
    var tanggallahir = $('#tanggallahir').val();
    var alamatrumah = $('#alamatrumah').val();
    var nohp = $('#nohp').val();
    var email = $('#email').val();
    var password = $('#password').val();

    if (!$('#chkSyaratDanKetentuan').prop('checked')) {
      swal("Syarat Dan Ketentuan", "Anda harus membaca dan menyetujui syarat dan ketentuan terlebih dahulu", "info");
      return;
    }

    var sudahpernahfondationclass = $('#sudahpernahfondationclass1').prop('checked') ? 'Sudah' : 'Belum';
    var alasanmembuatakun = 'Bergabung';

    formData = {
      'namalengkap': namalengkap,
      'nik': nik,
      'jeniskelamin': jeniskelamin,
      'tempatlahir': tempatlahir,
      'tanggallahir': tanggallahir,
      'alamatrumah': alamatrumah,
      'nohp': nohp,
      'email': email,
      'password': password,
      'alasanmembuatakun': alasanmembuatakun,
      'sudahpernahfondationclass': sudahpernahfondationclass,
    };

    $.ajax({
      url: '<?= site_url('login/simpanregistrasi') ?>',
      type: 'POST',
      dataType: 'json',
      data: formData,
    })
    .done(function(response) {
      if (response.success) {
        swal("Berhasil", "Pendaftaran Anda berhasil! Silahkan cek kotak masuk atau spam Email Anda untuk verifikasi Email.", "success")
          .then(function() {
            $('#registrasiModal').modal('hide');
          });
      } else {
        swal("Gagal", response.msg, "info");
      }
    })
    .fail(function() {
      console.log('error simpanregistrasi');
    });
  }

  function onCancel() {
    $('#smartwizard').smartWizard("reset");
    $('#registrasiModal').modal('hide');
  }

  $(function() {
    $('#smartwizard').smartWizard({
      selected: 0,
      enableUrlHash: false,
      autoAdjustHeight: true,
      theme: 'square',
      transition: { animation: 'myFade' },
      toolbar: {
        showNextButton: true,
        showPreviousButton: true,
        position: 'bottom',
        extraHtml: `<button class="btn btn-success btnSelesai" onclick="onFinish()">Kirim</button>
                    <button class="btn btn-secondary" onclick="onCancel()">Batal</button>`
      },
      lang: { next: 'Selanjutnya', previous: 'Kembali' },
      anchor: {
        enableNavigation: true,
        enableDoneState: true,
        markPreviousStepsAsDone: true,
        unDoneOnBackNavigation: false,
        enableDoneStateNavigation: true
      }
    });

    $('#smartwizard').on('showStep', function(e, anchor, stepIndex) {
      if (isMobileApp()) {
        updateMobileUI(stepIndex);
      }
      if (stepIndex === 2) {
        $('#tdDaftarNamaLengkap').text($('#namalengkap').val());
        $('#tdDaftarNIK').text($('#nik').val());
        $('#tdDaftarJenisKelamin').text($('#jeniskelamin').val());
        $('#tdDaftarTempatLahir').text($('#tempatlahir').val());
        $('#tdDaftarTanggalLahir').text($('#tanggallahir').val());
        $('#tdDaftarAlamatRumah').text($('#alamatrumah').val());
        $('#tdDaftarNomorHP').text($('#nohp').val());
        $('#tdDaftarEmail').text($('#email').val());
      }
    });

    // Swipe gesture
    if ('ontouchstart' in window) {
      let startX = 0;
      const wizard = document.getElementById('smartwizard');
      if (wizard) {
        wizard.addEventListener('touchstart', e => startX = e.touches[0].clientX);
        wizard.addEventListener('touchend', e => {
          let stepInfo = $('#smartwizard').smartWizard("getStepInfo");
          if (stepInfo.currentStep === stepInfo.totalSteps - 1) return;
          let endX = e.changedTouches[0].clientX;
          let diff = startX - endX;
          if (Math.abs(diff) > 60) {
            diff > 0 ? $('#smartwizard').smartWizard("next") : $('#smartwizard').smartWizard("prev");
          }
        });
      }
    }
  });
</script>

<script>
  $("#formBuatAkun").bootstrapValidator({
    feedbackIcons: {
      valid: 'glyphicon glyphicon-ok',
      invalid: 'glyphicon glyphicon-remove',
      validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
      namalengkap: { validators: { notEmpty: { message: "Nama tidak boleh kosong" } } },
      nik: {
        validators: {
          stringLength: { min: 16, max: 16, message: 'Panjang karakter harus 16 karakter' },
          callback: {
            message: 'Nomor induk kependudukan tidak boleh kosong',
            callback: function(value) {
              return $('#alasanmembuatakun2').prop('checked') ? value !== '' : true;
            }
          }
        }
      },
      jeniskelamin: { validators: { notEmpty: { message: "Jenis kelamin tidak boleh kosong" } } },
      tempatlahir: {
        validators: {
          callback: {
            message: 'Tempat lahir tidak boleh kosong',
            callback: function(value) {
              return $('#alasanmembuatakun2').prop('checked') ? value !== '' : true;
            }
          }
        }
      },
      tanggallahir: {
        validators: {
          callback: {
            message: 'Tanggal lahir tidak boleh kosong',
            callback: function(value) {
              return $('#alasanmembuatakun2').prop('checked') ? value !== '' : true;
            }
          }
        }
      },
      nohp: {
        validators: {
          callback: {
            message: 'Nomor Whatsapp tidak boleh kosong',
            callback: function(value) {
              return $('#alasanmembuatakun2').prop('checked') ? value !== '' : true;
            }
          }
        }
      },
      email: { validators: { notEmpty: { message: "Email tidak boleh kosong" } } },
      password: {
        validators: {
          stringLength: { min: 6, max: 25, message: 'Panjang karakter minimal 6 sd 25 karakter' },
          callback: { message: 'Password tidak boleh kosong', callback: v => v !== '' }
        }
      },
      password2: {
        validators: {
          stringLength: { min: 6, max: 25, message: 'Panjang karakter minimal 6 sd 25 karakter' },
          callback: { message: 'Konfirmasi Password tidak boleh kosong', callback: v => v !== '' }
        }
      }
    }
  });

  function alasanmembuatakun() {
    if ($('#alasanmembuatakun1').prop('checked')) {
      $('.divsudahpernahfondationclass, .divnik, .divtempatlahir, .divtgllahir, .divnohp, .divalamatrumah').hide();
    } else {
      $('.divsudahpernahfondationclass').show();
      if ($('#sudahpernahfondationclass1').prop('checked')) {
        $('.divnik, .divtempatlahir, .divtgllahir, .divalamatrumah').show();
      } else {
        $('.divnik, .divtempatlahir, .divtgllahir, .divalamatrumah').hide();
      }
    }
  }

  $(document).on('change', '#alasanmembuatakun1, #alasanmembuatakun2, #sudahpernahfondationclass1, #sudahpernahfondationclass2', alasanmembuatakun);
  $(document).ready(function() { $('#sudahpernahfondationclass2').change(); });
</script>