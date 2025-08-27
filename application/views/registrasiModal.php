<!-- Animate CSS for the css animation support if needed -->
<link href="<?php echo base_url('myesc.id/assets/animate/animate.min.css') ?>" rel="stylesheet" />

<!-- Include SmartWizard CSS -->
<!-- <link href="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/css/demo.css" rel="stylesheet" type="text/css" /> -->
<link href="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/css/smart_wizard_all.css" rel="stylesheet" type="text/css" />

<!-- ================= MOBILE-FRIENDLY OVERRIDES (TAMPILAN SAJA) ================= -->
<style>
  /* Warna brand SmartWizard (pertahankan dari versi Anda) */
  .sw-theme-square > .nav > .nav-link.active,
  .sw-theme-square > .nav > .nav-link.done {
    background-color: #ff5008 !important;
    color: white !important;
    border-color: #ff5008 !important;
  }
  .sw-theme-square > .nav > .nav-link:hover {
    background-color: #e04607 !important; /* hover */
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

  /* ====== Tambahan agar nyaman di mobile (tidak mengubah logika) ====== */
  #registrasiModal .modal-content {
    border-radius: 14px;
  }

  /* Step nav bisa di-scroll horizontal di mobile */
  #registrasiModal .sw-theme-square > .nav {
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 8px;
    padding: 8px 12px 12px;
    border-bottom: 1px solid #f1f1f1;
  }
  #registrasiModal .sw-theme-square > .nav .nav-item {
    flex: 0 0 auto;
  }
  #registrasiModal .sw-theme-square > .nav > .nav-link {
    padding: 10px 12px;
    min-width: 160px;
    border-radius: 10px !important;
    white-space: nowrap;
  }
  #registrasiModal .sw-theme-square > .nav > .nav-link .num {
    width: 28px; height: 28px; line-height: 28px;
    border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    margin-right: 8px;
    font-weight: 600;
  }

  /* Tab content padding rapi (hapus margin negatif bawaan) */
  #registrasiModal .tab-content {
    padding: 12px;
    margin-top: 0 !important; /* <— penting untuk mobile */
  }

  /* Form controls besar agar mudah diketik */
  #registrasiModal .form-control, 
  #registrasiModal select.form-control {
    height: 46px;
    font-size: 16px; /* cegah auto-zoom iOS */
    border-radius: 10px;
  }
  #registrasiModal label {
    font-weight: 600;
    margin-bottom: 6px;
  }
  #registrasiModal .form-row + .form-row {
    margin-top: 12px;
  }

  /* Progress & toolbar sticky supaya selalu terlihat di mobile */
  #registrasiModal .progress {
    position: sticky;
    bottom: 72px; /* beri ruang toolbar */
    z-index: 3;
    margin: 0 12px 12px;
    border-radius: 999px;
    height: 8px;
  }
  #registrasiModal .sw-toolbar {
    position: sticky;
    bottom: 0;
    z-index: 5;
    background: #fff;
    padding: 12px;
    border-top: 1px solid #eee;
    box-shadow: 0 -6px 12px rgba(0,0,0,.06);
  }
  #registrasiModal .sw-btn-next,
  #registrasiModal .sw-btn-prev,
  #registrasiModal .btn-success.btnSelesai, 
  #registrasiModal .btn-secondary {
    border-radius: 999px !important;
    padding: 10px 16px !important;
    font-weight: 600;
  }

  /* Tabel konfirmasi jadi kartu-kartu saat mobile */
  @media (max-width: 576px) {
    #registrasiModal .modal-dialog { margin: 0; }
    #registrasiModal .table {
      display: block;
      width: 100%;
    }
    #registrasiModal .table tbody tr {
      display: grid;
      grid-template-columns: 1fr;
      padding: 10px 12px;
      border: 1px solid #eee;
      border-radius: 10px;
      margin-bottom: 10px;
      background: #fafafa;
    }
    #registrasiModal .table tbody tr td:first-child {
      font-weight: 600;
      color: #333;
    }
    #registrasiModal .table tbody tr td:nth-child(2) { display: none; } /* sembunyikan ':' */
    #registrasiModal .table tbody tr td:last-child {
      margin-top: 4px;
      word-break: break-word;
    }
  }

  /* Heading responsif */
  #registrasiModal h3 {
    font-size: clamp(18px, 2.2vw, 22px);
    font-weight: 700;
    margin: 6px 0 14px;
  }
  #registrasiModal h5 {
    font-size: clamp(16px, 2vw, 18px);
    margin-bottom: 8px;
  }

  /* Error text */
  #registrasiModal .help-block { color: #e53935; }

  /* Radio/checkbox spacing */
  #registrasiModal .form-check { padding: 6px 0; }
</style>

<style>
  .help-block { color: red; } /* pertahankan */
  .modal-custom { padding-bottom: 0px; }
</style>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="registrasiModal" data-bs-backdrop="static" data-bs-keyboard="false">
  <!-- PERUBAHAN: tambah modal-dialog-centered & modal-fullscreen-sm-down agar full screen di mobile -->
  <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down modal-xl">
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

              <!-- PERUBAHAN: hapus style margin-top:-80px -->
              <div class="tab-content">
                <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" style="padding-bottom: 90px;">
                  <div class="row">
                    <div class="col-12"></div>
                    <div class="col-12">
                      <div class="row">
                        <!-- tetap hidden -->
                        <div class="col-12" style="display: none;">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="alasanmembuatakun" id="alasanmembuatakun2" checked value="2">
                            <label class="form-check-label" for="alasanmembuatakun2"></label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12 mt-3 mt-sm-5 divsudahpernahfondationclass">
                      <div class="row">
                        <div class="col-12">
                          <h5 class="">Sudah Pernah Membuat Kartu Anggota Jemaat ESC?</h5>
                        </div>
                        <div class="col-12">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sudahpernahfondationclass" id="sudahpernahfondationclass1" value="1">
                            <label class="form-check-label" for="sudahpernahfondationclass1">Sudah</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="sudahpernahfondationclass" id="sudahpernahfondationclass2" checked value="2">
                            <label class="form-check-label" for="sudahpernahfondationclass2">Belum</label>
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
                        <h3>Silahkan Isi Data Di Bawah Ini:</h3>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="namalengkap">Nama Lengkap:</label>
                            <input type="text" placeholder="Nama Lengkap" class="form-control input-step-2-1" id="namalengkap" name="namalengkap">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 divnik">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="nik">NIK (KTP):</label>
                            <input type="text" placeholder="Nomor Induk Kependudukan" class="form-control input-step-2-1" id="nik" name="nik" inputmode="numeric">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="jeniskelamin">Jenis Kelamin:</label>
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
                            <label for="tempatlahir">Tempat Lahir:</label>
                            <input type="text" placeholder="Tempat lahir" class="form-control input-step-2-1" id="tempatlahir" name="tempatlahir">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 divtgllahir">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="tanggallahir">Tanggal Lahir:</label>
                            <input type="date" class="form-control input-step-2-1" id="tanggallahir" name="tanggallahir">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 divalamatrumah">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="alamatrumah">Alamat:</label>
                            <input type="text" placeholder="Alamat tempat tinggal saat ini" class="form-control input-step-2-1" id="alamatrumah" name="alamatrumah">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 divnohp">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="nohp">Nomor WhatsApp:</label>
                            <input type="text" inputmode="tel" placeholder="Nomor WhatsApp" class="form-control input-step-2-1" id="nohp" name="nohp" autocomplete="tel">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="email">Email:</label>
                            <input type="email" placeholder="Email" class="form-control input-step-2-1" id="email" name="email" autocomplete="email">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="password">Password:</label>
                            <input type="password" placeholder="Password" class="form-control input-step-2-1" id="password" name="password" autocomplete="new-password">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-holder form-holder-2">
                            <label for="password2">Konfirmasi Password:</label>
                            <input type="password" placeholder="Konfirmasi Password" class="form-control input-step-2-1" id="password2" name="password2" autocomplete="new-password">
                          </div>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>

                <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3" style="padding-bottom: 90px;">
                  <div class="row">
                    <div class="col-12">
                      <h3>Silahkan Isi Data Di Bawah Ini</h3>
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
                  </div>
                </div>

              </div>

              <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </div>
</div>

<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="<?php echo base_url('myesc.id/assets/jquery-smartwizard-master/dist') ?>/js/jquery.smartWizard.min.js"></script>

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
          swal("Hubungi hotline gereja WhatsApp 085550001187 untuk konfirmasi akun", response.msg, "info");
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
        } else {
          return true;
        }
      }

      if (stepNumber == 2) {
        return true;
      } else {}
    });

    $("#smartwizard").on("initialized", function(e) {
      console.log("initialized");
    });

    $("#smartwizard").on("loaded", function(e) {
      console.log("loaded");
    });

    // Smart Wizard init (tetap sama, hanya UI yang berubah)
    $('#smartwizard').smartWizard({
      selected: 0,
      enableUrlHash: false,
      autoAdjustHeight: true,
      theme: 'square', // basic, arrows, square, round, dots
      transition: {
        animation: 'myFade' // none|fade|slideHorizontal|slideVertical|slideSwing|css
      },
      toolbar: {
        showNextButton: true,
        showPreviousButton: true,
        position: 'bottom',
        extraHtml: `<button class="btn btn-success btnSelesai" onclick="onFinish()">Kirim</button>
                    <button class="btn btn-secondary" onclick="onCancel()">Batal</button>`
      },
      anchor: {
        enableNavigation: true,
        enableNavigationAlways: false,
        enableDoneState: true,
        markPreviousStepsAsDone: true,
        unDoneOnBackNavigation: false,
        enableDoneStateNavigation: true
      },
      lang: {
        next: 'Selanjutnya',
        previous: 'Kembali'
      },
      disabledSteps: [],
      errorSteps: [],
      hiddenSteps: []
    });

    // Custom transition tetap sama
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
          notEmpty: { message: "Nama tidak boleh kosong" },
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
                return { valid: false, message: 'Nomor induk kependudukan tidak boleh kosong' }
              }
              return true
            }
          }
        }
      },
      jeniskelamin: {
        validators: {
          notEmpty: { message: "Jenis kelamin tidak boleh kosong" },
        }
      },
      tempatlahir: {
        validators: {
          callback: {
            message: 'Tempat lahir tidak boleh kosong',
            callback: function(value, validator, tampatlahir) {
              if ($('#alasanmembuatakun2').prop('checked') && $('#tempatlahir').val() == '') {
                return { valid: false, message: 'Tempat lahir tidak boleh kosong' }
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
                return { valid: false, message: 'Tangggal lahir tidak boleh kosong' }
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
                return { valid: false, message: 'Nomor Whatsapp tidak boleh kosong' }
              }
              return true
            }
          }
        }
      },
      email: {
        validators: {
          notEmpty: { message: "Email tidak boleh kosong" },
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
                return { valid: false, message: 'Password tidak boleh kosong' }
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
                return { valid: false, message: 'Konfirmasi Password tidak boleh kosong' }
              }
              return true
            }
          }
        }
      },
    },
    onSuccess: function(e, data) {
      e.preventDefault();
    }
  });

  $(document).on('change', '#alasanmembuatakun1', function() { alasanmembuatakun(); });
  $(document).on('change', '#alasanmembuatakun2', function() { alasanmembuatakun(); });
  $(document).on('change', '#sudahpernahfondationclass1', function() { alasanmembuatakun(); });
  $(document).on('change', '#sudahpernahfondationclass2', function() { alasanmembuatakun(); });

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
        $('.divalamatrumah').show();
      } else {
        $('.divnik').hide();
        $('.divtempatlahir').hide();
        $('.divtgllahir').hide();
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
    /* memperbaiki assignment yang salah pada versi sebelumnya */
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
</script>
