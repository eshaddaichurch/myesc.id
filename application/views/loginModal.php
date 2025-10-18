  <!-- <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" id="loginModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-body">

          <form action="<?php echo site_url('login/cek_login') ?>" method="post" id="formLogin">

            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="form-group row">
                    <div class="col-4 col-md-2">
                      <img src="<?php echo base_url('myesc.id/images/icon.png') ?>" alt="" style="width: 50px;">
                    </div>
                    <div class="col-8 col-md-10">
                      <h4>MYESC</h4>
                      <p>Login</p>
                    </div>
                  </div>
                </div>
                <div class="col-12">



                  <div class="form-group row mt-5 p-1">
                    <label for="" class="col-md-4 col-form-label">Email</label>
                    <div class="col-md-8">
                      <input type="text" name="emaillogin" id="emaillogin" class="form-control" placeholder="Masukan Email">
                    </div>
                  </div>
                  <div class="form-group row p-1">
                    <label for="" class="col-md-4 col-form-label">Password</label>
                    <div class="col-md-8">
                      <input type="password" name="passwordlogin" id="passwordlogin" class="form-control" placeholder="Masukan Password">
                    </div>
                  </div>

                </div>
                <div class="col-12 mt-5 mb-3" style="font-size: 12px;">
                  <a href=""></a>
                </div>

                <div class="col-12 mb-3" style="font-size: 12px;">
                  <a href="#" class="show-form-registrasi">Belum Punya Akun? Daftar Sekarang</a>
                </div>

                <div class="col-12" style="font-size: 12px;" id="divAlert">

                </div>

                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary float-end" id="btnLogin">Login</button>
                  <button type="button" class="btn btn-secondary float-end me-2" data-bs-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>

          </form>


        </div>

      </div>
    </div>
  </div> -->



  <!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-sm">

      <div class="modal-body px-5 py-4 text-center">
        <form action="<?php echo site_url('login/cek_login') ?>" method="post" id="formLogin">

          <img src="<?php echo base_url('myesc.id/images/icon.png') ?>" alt="Logo" width="50" class="mb-3">
          <h4 class="fw-bold text-orange">MYESC</h4>
          <p class="text-muted small mb-4"></p>

          <div class="form-group position-relative mb-3">
            <input type="text" name="emaillogin" id="emaillogin" class="form-control rounded-pill ps-5" placeholder="Masukan Email atau Nomor Whatsapp">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-user"></i>
            </span>
          </div>

          <!-- <div class="form-group position-relative mb-4">
            <input type="password" name="passwordlogin" id="passwordlogin" class="form-control rounded-pill ps-5" placeholder="Masukan Password">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-lock"></i>
            </span>
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted" style="cursor: pointer;">
              <i class="fas fa-eye"></i>
            </span>
          </div> -->

          <div class="form-group position-relative mb-4">
            <input type="password" name="passwordlogin" id="passwordlogin" class="form-control rounded-pill ps-5" placeholder="Masukan Password">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-orange">
              <i class="fas fa-lock"></i>
            </span>
            <span class="position-absolute top-50 end-0 translate-middle-y pe-3 text-muted" style="cursor: pointer;">
              <i class="fas fa-eye" id="togglePassword"></i>
            </span>
          </div>


          <div id="divAlert" class="mb-3"></div>

          <button type="submit" class="btn btn-orange rounded-pill w-100 mb-2" id="btnLogin">LOGIN</button>

          <p class="small mt-2">Belum Punya Akun? <a href="#" class="show-form-registrasi text-decoration-none fw-bold">Daftar Sekarang</a></p>

          <div class="d-flex align-items-center my-3">
            <hr class="flex-grow-1">
            <span class="mx-2 small text-muted"></span>
            <hr class="flex-grow-1">
          </div>

          <p class="small text-muted mb-2"></p>
          <div class="d-flex justify-content-center gap-3">
            <!-- <a href="#" class="text-orange"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-orange"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-orange"><i class="fab fa-twitter"></i></a> -->
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
    $("#formLogin").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        emaillogin: {
          validators: {
            notEmpty: {
              message: "Silahkan masukan email atau nomor whatsapp yang terverifikasi"
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
      var email = $("#emaillogin").val();
      var password = $("#passwordlogin").val();

      // console.log(password);

      $.ajax({
          url: '<?php echo site_url('login/cekLoginAjax') ?>',
          type: 'POST',
          dataType: 'json',
          data: {
            'email': email,
            'password': password
          },
        })
        .done(function(cekLoginResult) {
          console.log("success");
          if (cekLoginResult.success) {
            window.open("<?php echo site_url() ?>", "_self");
          } else {
            swal('Informasi', cekLoginResult.msg, 'info');
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


    document.getElementById("togglePassword").addEventListener("click", function () {
      const passwordInput = document.getElementById("passwordlogin");
      const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
      passwordInput.setAttribute("type", type);

      // Toggle icon
      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });


    // $('#btnLogin').click(function(event) {
    //   e.preventDefault();
    //   var email = $("#emaillogin").val();
    //   var password = $("#password").val();
    //   $.ajax({
    //     url: '<?php echo site_url('login/cekLogin') ?>',
    //     type: 'POST',
    //     dataType: 'json',
    //     data: {'email': email, 'password': password},
    //   })
    //   .done(function(cekLoginResult) {
    //     console.log("success");
    //     if (cekLoginResult.success) {

    //     }else{
    //       $('#divAlert').empty();
    //       var addText = `
    //                 <div class="alert alert-danger d-flex align-items-center" role="alert">
    //                   <i class="fas fa-exclamation-triangle"></i> 
    //                   <div>
    //                     `+cekLoginResult.msg+`
    //                   </div>
    //                 </div>
    //       `;
    //       $('#divAlert').html(addText)
    //     }
    //   })
    //   .fail(function() {
    //     console.log("error");
    //   })

    // });
  </script>