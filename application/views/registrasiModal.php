


<!-- Animate CSS for the css animation support if needed -->
<link href="<?php echo base_url('myesc.id/assets/animate/animate.min.css') ?>" rel="stylesheet" />

<!-- Include SmartWizard CSS -->
<!-- <link href="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/css/demo.css" rel="stylesheet" type="text/css" /> -->
<link href="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/css/smart_wizard_all.css" rel="stylesheet" type="text/css" />


<style>
  /* Ganti warna utama SmartWizard theme 'square' dari biru ke #ff5008 */
  .sw-theme-square > .nav > .nav-link.active,
  .sw-theme-square > .nav > .nav-link.done {
    background-color: #ff5008 !important;
    color: white !important;
    border-color: #ff5008 !important;
  }

  /* Warna hover pada step */
  .sw-theme-square > .nav > .nav-link:hover {
    background-color: #e04607 !important; /* Sedikit lebih gelap untuk efek hover */
    border-color: #e04607 !important;
  }

  /* Warna border untuk step yang aktif/done */
  .sw-theme-square > .nav > .nav-link.active::after,
  .sw-theme-square > .nav > .nav-link.done::after {
    border-left-color: #ff5008 !important;
  }

  /* Ganti warna progress bar */
  .sw-theme-square .progress-bar {
    background-color: #ff5008 !important;
  }

  /* Garis horizontal antar langkah */
  .sw-theme-square > .nav > .nav-item:not(:first-child)::before {
    background-color: #ff5008 !important;
  }

  /* Nomor langkah (misalnya 1, 2, 3) */
  .sw-theme-square > .nav > .nav-link > .num {
    background-color: #ff5008 !important;
    color: white !important;
  }

  /* Tombol Next/Previous jika ikut tema (opsional) */
  .sw-btn-next,
  .sw-btn-prev,
  .btn-success.btnSelesai { /* Tombol "Kirim" */
    background-color: #ff5008 !important;
    border-color: #ff5008 !important;
  }

  .sw-btn-next:hover,
  .sw-btn-prev:hover,
  .btn-success.btnSelesai:hover {
    background-color: #e04607 !important;
    border-color: #e04607 !important;
  }
</style>

<style>
  .help-block {
    color: red;
  }
</style>

<style>
  .modal-custom {
    /* padding: 0 0 0 0; */
    padding-bottom: 0px;
  }

  @media screen and (max-width: 480px) {
      h3.text-center {
          font-size: 15px !important;
      }
  }


  /* ================= MOBILE APP MODE ================= */
body.mobile-app .modal-dialog {
  margin: 0;
  height: 100vh;
}

body.mobile-app .modal-content {
  height: 100vh;
  border-radius: 0;
}

/* sembunyikan header step (angka 1–2–3) */
/* body.mobile-app .sw-anchor,
body.mobile-app .nav-progress {
  display: none !important;
} */

body.mobile-app .nav {
  display: none !important;
}


/* wizard full height */
body.mobile-app #smartwizard {
  height: 100%;
  display: flex;
  flex-direction: column;
}

/* konten step scroll sendiri */
body.mobile-app .tab-content {
  flex: 1;
  overflow-y: auto;
  padding: 16px;
  margin-top: 0 !important;
}

/* toolbar fix di bawah seperti app */
body.mobile-app .sw-toolbar-bottom {
  position: sticky;
  bottom: 0;
  background: #fff;
  padding: 12px;
  box-shadow: 0 -4px 10px rgba(0,0,0,.1);
  z-index: 10;
}

/* tombol besar & full width */
body.mobile-app .sw-btn-group button,
body.mobile-app .btnSelesai {
  width: 100%;
  padding: 14px;
  font-size: 16px;
  margin-bottom: 8px;
}

/* judul lebih rapat */
body.mobile-app h3.text-center {
  font-size: 18px;
  margin-bottom: 16px;
}

/* ================= APP LOOK & FEEL ================= */
body.mobile-app {
  background: #f6f7f9;
  font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* Header ala mobile app */
.mobile-app .modal-body > .row > .col-12:first-child {
  padding: 20px 16px 10px;
}

.mobile-app h3.text-center {
  font-size: 20px;
  font-weight: 700;
  color: #111;
}

/* Step container jadi card */
.mobile-app .tab-pane > .row {
  background: #fff;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,.06);
}

/* Question text */
.mobile-app .tab-pane h3 {
  font-size: 18px;
  line-height: 1.4;
  margin-bottom: 24px;
}

/* ================= RADIO CARD ================= */
.mobile-app .form-check {
  background: #f9fafb;
  border-radius: 14px;
  padding: 16px;
  margin-bottom: 12px;
  border: 2px solid transparent;
  display: flex;
  align-items: center;
  transition: all .2s ease;
}

.mobile-app .form-check-input {
  transform: scale(1.3);
  margin-right: 12px;
}

.mobile-app .form-check-input:checked ~ .form-check-label {
  font-weight: 600;
}

.mobile-app .form-check:has(input:checked) {
  border-color: #ff8100;
  background: #fff6ed;
}

/* ================= INPUT ================= */
.mobile-app .form-control,
.mobile-app select {
  height: 52px;
  border-radius: 12px;
  border: 1.5px solid #e5e7eb;
  padding: 12px 14px;
  font-size: 15px;
}

.mobile-app .form-control:focus,
.mobile-app select:focus {
  border-color: #ff8100;
  box-shadow: 0 0 0 3px rgba(255,129,0,.15);
}

/* ================= BUTTON ================= */
.mobile-app .sw-toolbar-bottom {
  background: #fff;
  border-top: 1px solid #eee;
}

.mobile-app .sw-btn-next,
.mobile-app .btnSelesai {
  background: linear-gradient(135deg, #ff8100, #ff5008);
  border: none;
  border-radius: 14px;
  font-weight: 600;
  box-shadow: 0 8px 20px rgba(255,129,0,.35);
}

.mobile-app .sw-btn-prev,
.mobile-app .btn-secondary {
  background: #f1f5f9;
  color: #333;
  border-radius: 14px;
  border: none;
}

/* ================= TABLE CONFIRM ================= */
.mobile-app table {
  background: #fff;
  border-radius: 14px;
  overflow: hidden;
}

.mobile-app table td {
  padding: 12px;
  font-size: 14px;
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

            <!-- SmartWizard html -->
            <div id="smartwizard">

              <ul class="nav nav-progress">
                <li class="nav-item">
                  <a class="nav-link" href="#step-1">
                    <div class="num">1</div>
                    Selamat Datang
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#step-2">
                    <span class="num">2</span>
                    Informasi Akun
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#step-3">
                    <span class="num">3</span>
                    Konfirmasi Akun
                  </a>
                </li>
              </ul>

              <div class="tab-content">
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" style="padding-bottom: 90px;">
                  <div class="row">
                    <div class="col-12">
                      <!-- <h5>Alasan anda membuat akun baru?</h5> -->
                    </div>
                    <div class="col-12">
                      <div class="row">
                        <!-- <div class="col-12" style="display: none;">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="alasanmembuatakun" id="alasanmembuatakun1" value="1">
                            <label class="form-check-label" for="alasanmembuatakun1">
                              I'm just here to visit
                            </label>
                          </div>
                        </div> -->
                        <div class="col-12" style="display: none;">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="alasanmembuatakun" id="alasanmembuatakun2" checked value="2">
                            <label class="form-check-label" for="alasanmembuatakun2">
                              <!-- I would like to join El Shaddai Church -->
                            </label>
                          </div>

                        </div>
                      </div>
                    </div>



                    <div class="col-12 mt-5 divsudahpernahfondationclass">
                      <div class="row">
                        <div class="col-12">
                          <!-- <h5 class="text">Sudah Pernah Membuat Kartu Anggota Jemaat ESC?</h5> -->
                          <h3 class="text-center">Sudah Pernah Membuat Kartu Anggota Jemaat ESC?</h3>

                        </div>
                        <div class="col-12">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sudahpernahfondationclass" id="sudahpernahfondationclass1" value="1">
                            <label class="form-check-label" for="sudahpernahfondationclass1">
                              Sudah
                            </label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sudahpernahfondationclass" id="sudahpernahfondationclass2" checked value="2">
                            <label class="form-check-label" for="sudahpernahfondationclass2">
                              Belum
                            </label>
                          </div>

                        </div>
                      </div>
                    </div>



                  </div>
                </div>
                <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2" style="padding-bottom: 90px;">

                  <form action="#" id="formBuatAkun" method="POST">

                    <div class="row">
                      <div class="col-12">
                        <!-- <h3>Silahkan Isi Data Di Bawah Ini:</h3> -->
                        <h3 class="text-center">Silahkan Isi Data Di Bawah Ini:</h3>
                      </div>
                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Nama Lengkap:</label>
                            <input type="text" placeholder="Nama Lengkap" class="form-control input-step-2-1" id="namalengkap" name="namalengkap">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 divnik">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">NIK (KTP):</label>
                            <input type="text" placeholder="Nomor Induk Kependudukan" class="form-control input-step-2-1" id="nik" name="nik">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Jenis Kelamin:</label>
                            <select name="jeniskelamin" id="jeniskelamin" class="form-control">
                              <option value="">Pilih jenis kelamin...</option>
                              <option value="Laki-laki">Laki-laki</option>
                              <option value="Perempuan">Perempuan</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 divtempatlahir">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Tempat Lahir:</label>
                            <input type="text" placeholder="Tempat lahir" class="form-control input-step-2-1" id="tempatlahir" name="tempatlahir">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 divtgllahir">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Tanggal Lahir:</label>
                            <input type="date" class="form-control input-step-2-1" id="tanggallahir" name="tanggallahir">
                          </div>
                        </div>

                      </div>


                      <div class="col-md-6 divalamatrumah">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Alamat:</label>
                            <input type="text" placeholder="Alamat tempat tinggal saat ini" class="form-control input-step-2-1" id="alamatrumah" name="alamatrumah">
                          </div>
                        </div>

                      </div>

                      <div class="col-md-6 divnohp">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Nomor WhatsApp:</label>
                            <input type="text" placeholder="Contoh: 08123456789" class="form-control input-step-2-1" id="nohp" name="nohp">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Email:</label>
                            <input type="text" placeholder="Email" class="form-control input-step-2-1" id="email" name="email">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Password:</label>
                            <input type="password" placeholder="Password" class="form-control input-step-2-1" id="password" name="password">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="account_name">Konfirmasi Password:</label>
                            <input type="password" placeholder="Konfirmasi Password" class="form-control input-step-2-1" id="password2" name="password2">
                          </div>
                        </div>
                      </div>


                    </div>
                  </form>
                </div>
                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3" style="padding-bottom: 90px;">
                  <div class="row">
                    <div class="col-12">
                      <!-- <h3 class>Silahkan Isi Data Di Bawah Ini</h3> -->
                      <h3 class="text-center">Silahkan Isi Data Di Bawah Ini:</h3>
                    </div>
                    <div class="col-12">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td style="width: 25%;">Nama Lengkap</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarNamaLengkap"></td>
                          </tr>
                          <tr class="divnik">
                            <td style="width: 25%;">NIK</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarNIK"></td>
                          </tr>
                          <tr>
                            <td style="width: 25%;">Jenis Kelamin</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarJenisKelamin"></td>
                          </tr>
                          <tr class="divtempatlahir">
                            <td style="width: 25%;">Tempat Lahir</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarTempatLahir"></td>
                          </tr>
                          <tr class="divtgllahir">
                            <td style="width: 25%;">Tanggal Lahir</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarTanggalLahir"></td>
                          </tr>
                          <tr class="divalamatrumah">
                            <td style="width: 25%;">Alamat Rumah</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarAlamatRumah"></td>
                          </tr>
                          <tr>
                            <td style="width: 25%;">Nomor HP</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarNomorHP"></td>
                          </tr>
                          <tr>
                            <td style="width: 25%;">Email</td>
                            <td style="width: 5%;">:</td>
                            <td style="width: 70%;" id="tdDaftarEmail"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="col-12 font-weight-bold">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="chkSyaratDanKetentuan">
                        <label class="form-check-label" for="chkSyaratDanKetentuan">Saya telah membaca dan menyetujui <a href="<?php echo base_url('myesc.id/TermsandConditions.html') ?>" target="_blank">Syarat dan Ketentuan GBI El Shaddai</a> 
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <!-- <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div> -->
            </div>


          </div>
        </div>


      </div>

    </div>
  </div>
</div>



<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/js/jquery.smartWizard.min.js"></script>


<script>
  function isMobileApp() {
    return window.innerWidth <= 768;
  }

  function applyMobileAppMode() {
    if (isMobileApp()) {
      document.body.classList.add('mobile-app');
    } else {
      document.body.classList.remove('mobile-app');
    }
  }

  applyMobileAppMode();
  window.addEventListener('resize', applyMobileAppMode);
</script>


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
    var sudahpernahfondationclass = $('#sudahpernahfondationclass1').val();


    if (!$('#chkSyaratDanKetentuan').prop('checked')) {
      swal("Syarat Dan Ketentuan", "Anda harus membaca dan menyetujui syarat dan ketentuan terlebih dahulu", "info");
      return
    }

    if ($('#sudahpernahfondationclass1').prop('checked')) {
      var sudahpernahfondationclass = 'Sudah';
    } else {
      var sudahpernahfondationclass = 'Belum';
    }

    if ($('#alasanmembuatakun1').prop('checked')) {
      var alasanmembuatakun = 'Berkunjung';
    } else {
      var alasanmembuatakun = 'Bergabung';
    }

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
    }

    $.ajax({
        url: '<?= site_url('login/simpanregistrasi') ?>',
        type: 'POST',
        dataType: 'json',
        data: formData,
      })
      .done(function(response) {
        console.log(response);
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
    // Step show event
    $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
      $("#prev-btn").removeClass('disabled').prop('disabled', false);
      $("#next-btn").removeClass('disabled').prop('disabled', false);
      if (stepPosition === 'first') {
        $("#prev-btn").addClass('disabled').prop('disabled', true);
      } else if (stepPosition === 'last') {
        $("#next-btn").addClass('disabled').prop('disabled', true);
      } else {
        $("#prev-btn").removeClass('disabled').prop('disabled', false);
        $("#next-btn").removeClass('disabled').prop('disabled', false);
      }

      // console.log(stepDirection);
      // console.log(stepIndex);

      // Get step info from Smart Wizard
      // let stepInfo = $('#smartwizard').smartWizard("getStepInfo");
      // $("#sw-current-step").text(stepInfo.currentStep + 1);
      // $("#sw-total-step").text(stepInfo.totalSteps);
    });

    $("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection, stepPosition) {
      checkStep = false;
      if (stepPosition == 'last') {
        $(".btnSelesai").show();

        $('#tdDaftarNamaLengkap').html($('#namalengkap').val());
        $('#tdDaftarNIK').html($('#nik').val());
        $('#tdDaftarJenisKelamin').html($('#jeniskelamin').val());
        $('#tdDaftarTempatLahir').html($('#tempatlahir').val());
        $('#tdDaftarTanggalLahir').html($('#tanggallahir').val());
        $('#tdDaftarAlamatRumah').html($('#alamatrumah').val());
        $('#tdDaftarNomorHP').html($('#nohp').val());
        $('#tdDaftarEmail').html($('#email').val());

      } else {
        $(".btnSelesai").hide();
      }
    });

    $("#smartwizard").on("leaveStep", function(e, anchorObject, stepNumber, stepDirection) {

      // var form_data = $("#form" + stepNumber).serialize();
      console.log(stepNumber);
      console.log(stepDirection);


      if (stepNumber == 1) {
        if (stepDirection == 2) {


          var validator = $("#formBuatAkun").data("bootstrapValidator");
          validator.validate();
          if (!validator.isValid()) {
            $('#smartwizard').smartWizard("fixHeight");
            return false;
          } else {
            if ($('#password').val() != $('#password2').val()) {
              swal("Ulangi Password", "Ulangi password tidak sama!", "info");
              return false;
            } else {
              $('#smartwizard').smartWizard("fixHeight");
              return true;
            }
          }

          return false;


        } else {
          return true;
        }
      }

      // if (stepNumber == 1) {
      //   if (stepDirection == 2) {
      //     var KdRuangan = $('#KdRuangan').val();
      //     var KdRujukanAsal = $('#KdRujukanAsal').val();
      //     var KdDokter = $('#KdDokter').val();

      //     if (KdRuangan == "") {
      //       swal("Informasi", "Nama poliklinik tidak boleh kosong!", "info");
      //       return false;
      //     }

      //     if (KdRujukanAsal == "") {
      //       swal("Informasi", "Asal rujukan tidak boleh kosong!", "info");
      //       return false;
      //     }

      //     if (KdDokter == "") {
      //       swal("Informasi", "Nama dokter pemeriksa tidak boleh kosong!", "info");
      //       return false;
      //     }

      //     return true;
      //   } else {
      //     return true;
      //   }
      // }



      if (stepNumber == 2) {
        return true;
      } else {}

      // return false;

    });


    $("#smartwizard").on("initialized", function(e) {
      console.log("initialized");
    });

    $("#smartwizard").on("loaded", function(e) {
      console.log("loaded");
    });

    // Smart Wizard
    $('#smartwizard').smartWizard({
      selected: 0,
      // autoAdjustHeight: false,
      enableUrlHash: false,
      autoAdjustHeight: true,
      theme: 'square', // basic, arrows, square, round, dots
      transition: {
        animation: 'myFade' // none|fade|slideHorizontal|slideVertical|slideSwing|css
      },
      toolbar: {
        showNextButton: true, // show/hide a Next button
        showPreviousButton: true, // show/hide a Previous button
        position: 'bottom', // none/ top/ both bottom
        extraHtml: `<button class="btn btn-success btnSelesai" onclick="onFinish()">Kirim</button>
                              <button class="btn btn-secondary" onclick="onCancel()">Batal</button>`
      },
      anchor: {
        enableNavigation: true, // Enable/Disable anchor navigation 
        enableNavigationAlways: false, // Activates all anchors clickable always
        enableDoneState: true, // Add done state on visited steps
        markPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
        unDoneOnBackNavigation: false, // While navigate back, done state will be cleared
        enableDoneStateNavigation: true // Enable/Disable the done state navigation
      },
      lang: { // Language variables for button
        next: 'Selanjutnya',
        previous: 'Kembali'
      },
      disabledSteps: [], // Array Steps disabled
      errorSteps: [], // Highlight step with errors
      hiddenSteps: [], // Hidden steps
      // getContent: (idx, stepDirection, selStep, callback) => {
      //   console.log('getContent',selStep, idx, stepDirection);
      //   callback('<h1>'+idx+'</h1>');
      // }
    });

    // ================= SWIPE GESTURE (MOBILE) =================
    if ('ontouchstart' in window) {
      let startX = 0;
      const wizard = document.getElementById('smartwizard');

      if (wizard) {
        wizard.addEventListener('touchstart', function (e) {
          startX = e.touches[0].clientX;
        });

        // wizard.addEventListener('touchend', function (e) {
        //   let endX = e.changedTouches[0].clientX;
        //   let diff = startX - endX;

        //   if (Math.abs(diff) > 60) {
        //     if (diff > 0) {
        //       $('#smartwizard').smartWizard("next");
        //     } else {
        //       $('#smartwizard').smartWizard("prev");
        //     }
        //   }
        // });

        wizard.addEventListener('touchend', function (e) {
          let stepInfo = $('#smartwizard').smartWizard("getStepInfo");
          if (stepInfo.currentStep === stepInfo.totalSteps - 1) return;

          let endX = e.changedTouches[0].clientX;
          let diff = startX - endX;

          if (Math.abs(diff) > 60) {
            diff > 0
              ? $('#smartwizard').smartWizard("next")
              : $('#smartwizard').smartWizard("prev");
          }
        });

      }
    }


    $.fn.smartWizard.transitions.myFade = (elmToShow, elmToHide, stepDirection, wizardObj, callback) => {
      if (!$.isFunction(elmToShow.fadeOut)) {
        callback(false);
        return;
      }

      if (elmToHide) {
        elmToHide.fadeOut(wizardObj.options.transition.speed, wizardObj.options.transition.easing, () => {
          elmToShow.fadeIn(wizardObj.options.transition.speed, wizardObj.options.transition.easing, () => {
            callback();
          });
        });
      } else {
        elmToShow.fadeIn(wizardObj.options.transition.speed, wizardObj.options.transition.easing, () => {
          callback();
        });
      }
    }


    $("#state_selector").on("change", function() {
      $('#smartwizard').smartWizard("setState", [$('#step_to_style').val()], $(this).val(), !$('#is_reset').prop("checked"));
      return true;
    });

    $("#style_selector").on("change", function() {
      $('#smartwizard').smartWizard("setStyle", [$('#step_to_style').val()], $(this).val(), !$('#is_reset').prop("checked"));
      return true;
    });

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
      namalengkap: {
        validators: {
          notEmpty: {
            message: "Nama tidak boleh kosong"
          },
        }
      },
      nik: {
        validators: {
          stringLength: {
            min: 16,
            max: 16,
            message: 'Panjang karakter harus 16 karakter'
          },
          callback: {
            message: 'Nomor induk kependudukan tidak boleh kosong',
            callback: function(value, validator, nik) {

              if ($('#alasanmembuatakun2').prop('checked') && $('#nik').val() == '') {
                return {
                  valid: false,
                  message: 'Nomor induk kependudukan tidak boleh kosong'
                }
              }
              return true
            }
          }
        }
      },
      jeniskelamin: {
        validators: {
          notEmpty: {
            message: "Jenis kelamin tidak boleh kosong"
          },
        }
      },
      tempatlahir: {
        validators: {
          callback: {
            message: 'Tempat lahir tidak boleh kosong',
            callback: function(value, validator, tampatlahir) {

              if ($('#alasanmembuatakun2').prop('checked') && $('#tempatlahir').val() == '') {
                return {
                  valid: false,
                  message: 'Tempat lahir tidak boleh kosong'
                }
              }
              return true
            }
          }
        }
      },
      tanggallahir: {
        validators: {
          callback: {
            message: 'Tangggal lahir tidak boleh kosong',
            callback: function(value, validator, tanggallahir) {

              if ($('#alasanmembuatakun2').prop('checked') && $('#tanggallahir').val() == '') {
                return {
                  valid: false,
                  message: 'Tangggal lahir tidak boleh kosong'
                }
              }
              return true
            }
          }
        }
      },
      nohp: {
        validators: {
          callback: {
            message: 'Nomor Whatsapp tidak boleh kosong',
            callback: function(value, validator, nohp) {

              if ($('#alasanmembuatakun2').prop('checked') && $('#nohp').val() == '') {
                return {
                  valid: false,
                  message: 'Nomor Whatsapp tidak boleh kosong'
                }
              }
              return true
            }
          }
        }
      },
      email: {
        validators: {
          notEmpty: {
            message: "Email tidak boleh kosong"
          },
        }
      },
      password: {
        validators: {
          stringLength: {
            min: 6,
            max: 25,
            message: 'Panjang karakter minimal 6 sd 25 karakter'
          },
          callback: {
            message: 'Password tidak boleh kosong',
            callback: function(value, validator, password) {

              if ($('#password').val() == '') {
                return {
                  valid: false,
                  message: 'Password tidak boleh kosong'
                }
              }
              return true
            }
          }
        }
      },
      password2: {
        validators: {
          stringLength: {
            min: 6,
            max: 25,
            message: 'Panjang karakter minimal 6 sd 25 karakter'
          },
          callback: {
            message: 'Password tidak boleh kosong',
            callback: function(value, validator, password2) {

              if ($('#password2').val() == '') {
                return {
                  valid: false,
                  message: 'Konfirmasi Password tidak boleh kosong'
                }
              }
              return true
            }
          }
        }
      },

    },
    onSuccess: function(e, data) {
      e.preventDefault();

      // console.log("1");

      // if ($('#optradioBergabung1').prop('checked') === false && $('#optradioBergabung2').prop('checked') === false) {
      //   e.preventDefault();
      //   swal("Upss", "Silahkan pilih apakah anda hanya ingin berkunjung atau ingin bergabung di El Shaddai Church.", "info")
      //     .then(function() {
      //       $('#optradioBergabung1').focus();
      //     });
      //   return false;
      // }
      // console.log("3");

      // $('#btnDaftar').prop('disabled', true);
    }
  });


  $(document).on('change', '#alasanmembuatakun1', function() {
    alasanmembuatakun();
  });

  $(document).on('change', '#alasanmembuatakun2', function() {
    alasanmembuatakun();
  });


  $(document).on('change', '#sudahpernahfondationclass1', function() {
    alasanmembuatakun();
  });

  $(document).on('change', '#sudahpernahfondationclass2', function() {
    alasanmembuatakun();
  });

  function alasanmembuatakun() {

    if ($('#alasanmembuatakun1').prop('checked')) {
      $('.divsudahpernahfondationclass').hide();
      $('.divnik').hide();
      $('.divtempatlahir').hide();
      $('.divtgllahir').hide();
      $('.divnohp').hide();
      $('.divalamatrumah').hide();

    } else {
      $('.divsudahpernahfondationclass').show();

      if ($('#sudahpernahfondationclass1').prop('checked')) {
        $('.divnik').show();
        $('.divtempatlahir').show();
        $('.divtgllahir').show();
        // $('.divnohp').show();
        $('.divalamatrumah').show();

      } else {
        $('.divnik').hide();
        $('.divtempatlahir').hide();
        $('.divtgllahir').hide();
        // $('.divnohp').hide();  
        $('.divalamatrumah').hide();

      }
    }

  }
</script>


<script>
  $(document).ready(function() {

    $('#sudahpernahfondationclass2').change();

    $('.radio-group .radio').click(function() {
      $(this).parent().find('.radio').removeClass('selected');
      $(this).addClass('selected');
    });

    $(".submit").click(function() {
      return false;
    })

  });


  function kosongkanText() {
    $('#namalengkap').val('');
    $('#nik').val('');
    $('#jeniskelamin').val('');
    $('#tempatlahir').val('');
    $('#tanggallahir').val('');
    $('#alamatrumah').val('');
    $('#nohp').val('');
    $('#email').val('');
    $('#password').val('');
    $('#password2').val('');
  }


  // function kosongkanText() {
  //   $('#namalengkap').val() = '';
  //   $('#nik').val() = '';
  //   $('#jeniskelamin').val() = '';
  //   $('#tempatlahir').val() = '';
  //   $('#tanggallahir').val() = '';
  //   $('#alamatrumah').val() = '';
  //   $('#nohp').val() = '';
  //   $('#email').val() = '';
  //   $('#password').val() = '';
  //   $('#password2').val() = '';
  // }
</script>
