

  <!-- Modal Login -->
<div class="modal fade" id="lupaPasswordModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">

      <div class="modal-body px-5 py-4 text-center">

        <!-- form masukkan kode token -->
        <form action="#" method="post" id="formMasukkanEmail">

          <img src="<?php echo base_url('myesc.id/images/icon.png') ?>" alt="Logo" width="50" class="mb-3">
          <h4 class="fw-bold text-orange">MYESC</h4>
          <p class="text-muted small mb-4"></p>


          <p>Masukkan Email atau Nomor Whatsapp untuk mereset password anda.</p>
          <div class="form-group position-relative mb-3">
            <input type="text" name="emailResetPassword" id="emailResetPassword" class="form-control rounded-pill ps-5" placeholder="Masukan Email atau Nomor Whatsapp">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-user"></i>
            </span>
          </div>

          <div id="divAlert" class="mb-3"></div>

          <button type="submit" class="btn btn-orange rounded-pill w-100 mb-2 mt-3">Kirim</button>

          <a href="#" class="show-form-login text-decoration-none fw-bold">Kembali ke Halaman Login</a>

          <div class="d-flex align-items-center my-3">
            <hr class="flex-grow-1">
            <span class="mx-2 small text-muted"></span>
            <hr class="flex-grow-1">
          </div>

        </form>

        <!-- form masukkan kode token -->
        <form action="#" method="post" id="formMasukkanToken" style="display: none;">

          <img src="<?php echo base_url('myesc.id/images/icon.png') ?>" alt="Logo" width="50" class="mb-3">
          <h4 class="fw-bold text-orange">MYESC</h4>
          <p class="text-muted small mb-4"></p>

          <p>Buka email/whatsapp anda dan masukkan token untuk mereset password.</p>

          <div class="form-group position-relative mb-3">
            <input type="text" name="tokenResetPassword" id="tokenResetPassword" class="form-control rounded-pill ps-5" placeholder="Masukkan Token">
            </span>
          </div>

          <div id="divAlert" class="mb-3"></div>

          <button type="submit" class="btn btn-orange rounded-pill w-100 mb-2 mt-3">Kirim</button>

        </form>


        <!-- form masukkan kode token -->
        <form action="#" method="post" id="formUbahPassword" style="display: none;">

          <img src="<?php echo base_url('myesc.id/images/icon.png') ?>" alt="Logo" width="50" class="mb-3">
          <h4 class="fw-bold text-orange">MYESC</h4>
          <p class="text-muted small mb-4"></p>


          <p>Masukkan password baru anda.</p>
          <div class="form-group position-relative mb-4">
            <input type="password" name="resetPasswordBaru1" id="resetPasswordBaru1" class="form-control rounded-pill ps-5" placeholder="Masukan Password Baru">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-lock"></i>
            </span>
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted" style="cursor: pointer;">
              <i class="fas fa-eye" id="togglePassword1"></i>
            </span>
          </div>

          <div class="form-group position-relative mb-4">
            <input type="password" name="resetPasswordBaru2" id="resetPasswordBaru2" class="form-control rounded-pill ps-5" placeholder="Ulangi Password Baru">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-lock"></i>
            </span>
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted" style="cursor: pointer;">
              <i class="fas fa-eye" id="togglePassword2"></i>
            </span>
          </div>


          <div id="divAlert" class="mb-3"></div>

          <button type="submit" class="btn btn-orange rounded-pill w-100 mb-2 mt-3">Simpan</button>


          <div class="d-flex align-items-center my-3">
            <hr class="flex-grow-1">
            <span class="mx-2 small text-muted"></span>
            <hr class="flex-grow-1">
          </div>

        </form>

      </div>
    </div>
  </div>
</div>

<!-- CSS di file yang sama -->
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
    background-color: #ff5008;
  }

  .form-control {
    height: 48px;
    background: #f8f8f8;
    border: none;
    font-size: 14px;
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

  .gap-3 > * {
    margin-right: 10px;
  }
</style>


  <script>
    $("#formMasukkanEmail").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        emailResetPassword: {
          validators: {
            notEmpty: {
              message: "Silahkan masukan email atau nomor whatsapp yang terverifikasi"
            },
          }
        },
      }
    }).on('success.form.bv', function(e) {
      e.preventDefault();
      var email = $("#emailResetPassword").val();

      $.ajax({
          url: '<?php echo site_url('login/kirimKodeResetPassword') ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            'email': email,
          },
        })
        .done(function(response) {
          console.log("success");
          if (response.success) {
            $('#formMasukkanEmail').hide(); 
            $('#formMasukkanToken').show();
          } else {
            swal('Informasi', response.msg, 'info');
          }
        })
        .fail(function() {
          $('#divAlert').empty();
          var addText = `
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                          <i class="fas fa-exclamation-triangle"></i> 
                          <div>
                            error script!
                          </div>
                        </div>
              `;
          $('#divAlert').html(addText)
        })
    });


    $("#formMasukkanToken").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        tokenResetPassword: {
          validators: {
            notEmpty: {
              message: "Token tidak boleh kosong"
            },
          }
        },
      }
    }).on('success.form.bv', function(e) {
      e.preventDefault();
      var email = $("#emailResetPassword").val();
      var tokenResetPassword = $("#tokenResetPassword").val();

      $.ajax({
          url: '<?php echo site_url('login/cekTokenResetPassword') ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            'email': email,
            'tokenResetPassword': tokenResetPassword
          },
        })
        .done(function(response) {

          if (response.success) {
            $('#formMasukkanEmail').hide(); 
            $('#formMasukkanToken').hide();
            $('#formUbahPassword').show();

          } else {
            swal('Informasi', response.msg, 'info');
          }
        })
        .fail(function() {
          $('#divAlert').empty();
          var addText = `
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                          <i class="fas fa-exclamation-triangle"></i> 
                          <div>
                            error script!
                          </div>
                        </div>
              `;
          $('#divAlert').html(addText)
        })
    });



    $("#formUbahPassword").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        //resetPasswordBaru1 minimal 6 karakter dan harus mengandung angka dan huruf besar dan kecil
        resetPasswordBaru1: {
          validators: {
            notEmpty: {
              message: "Silahkan masukan password baru"
            },
            stringLength: {
              min: 6,
              message: 'Password minimal 6 karakter'
            },
            regexp: {
              regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/,
              message: ' Password harus mengandung angka dan huruf besar dan kecil'
            }
          }
        },
        //validasi resetPasswordBaru2 harus sama dengan resetPasswordBaru1
        resetPasswordBaru2: {
          validators: {
            notEmpty: {
              message: "Silahkan token reset password"
            },
            identical: {
              field: 'resetPasswordBaru1',
              message: 'Password tidak sama'
            }
          }
        },
      }
    }).on('success.form.bv', function(e) {
      e.preventDefault();
      var email = $("#emailResetPassword").val();
      var resetPasswordBaru1 = $("#resetPasswordBaru1").val();

      $.ajax({
          url: '<?php echo site_url('login/updateResetPassword') ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            'email': email,
            'password': resetPasswordBaru1
          },
        })
        .done(function(response) {

          if (response.success) {
            swal('Berhasil', "Reset password berhasil. Silahkan login untuk menlanjutkan.", 'success')
              .then(function() {
                $('#lupaPasswordModal').modal('hide');
                $('#loginModal').modal('show');
              });            

          } else {
            swal('Informasi', response.msg, 'info');
          }
        })
        .fail(function() {
          $('#divAlert').empty();
          var addText = `
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                          <i class="fas fa-exclamation-triangle"></i> 
                          <div>
                            error script!
                          </div>
                        </div>
              `;
          $('#divAlert').html(addText)
        })
    });


    document.getElementById("togglePassword1").addEventListener("click", function () {
      const passwordInput = document.getElementById("resetPasswordBaru1");
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Toggle icon
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });

    document.getElementById("togglePassword2").addEventListener("click", function () {
      const passwordInput = document.getElementById("resetPasswordBaru2");
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Toggle icon
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });

  </script>