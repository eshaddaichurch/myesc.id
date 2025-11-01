<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

  body {
    font-family: 'Figtree', sans-serif;
    /* background-color: #e8d5a7; */
    background-color: linear-gradient(63deg, #fffaf5, #ffb347);
    padding-top: 60px;
    margin: 0;
  }

  .card {
    background: #ffffff;
    border-radius: 1rem;
  }

  .form-label {
    font-weight: 600;
    margin-bottom: 6px;
  }

  .form-control {
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
    border: 1px solid #ced4da;
    font-size: 1rem;
  }

  .form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.1rem rgba(13, 110, 253, 0.25);
  }

  .btn-primary {
    background-color: #ff5008;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    border-radius: 0.5rem;
  }

  .btn-outline-secondary {
    border: 1px solid #6c757d;
    color: #6c757d;
    background-color: transparent;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
  }

  .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: white;
  }
</style>

<body>
  <div class="page-wrapper">
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <section class="permohonan-form-section py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-11">
            <div class="card shadow rounded-4 border-0 p-4">
              <div class="card-body">
                <h4 id="lbljudul" class="mb-4 text-center fw-bold">Tambah Permohonan Pernikahan</h4>

                <form action="<?php echo site_url('pernikahan/simpan') ?>" method="POST" id="form">
                  <input type="hidden" name="idpernikahan" id="idpernikahan">

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">No HP Yang Bisa Dihubungi</label>
                      <input type="text" name="nohpyangbisadihubungi" id="nohpyangbisadihubungi" class="form-control" placeholder="Nomor HP" value="<?php echo $this->session->userdata('nohp'); ?>" readonly>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">Keterangan Permohonan</label>
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Tulis keterangan singkat, seperti tahun & tanggal pernikahan yang dimohonkan." autofocus></textarea>
                    </div>
                  </div>

                  <div class="row g-3">
                    <div class="col-md-6">
                      <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                          <h5 class="text-muted mb-3">Informasi Mempelai Pria</h5>
                          <div class="mb-3">
                            <div class="form-group">
                              <label class="form-label">Nama Mempelai</label>
                              <input type="text" class="form-control" name="namamempelaipria" id="namamempelaipria" placeholder="Nama mempelai pria">
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="form-group">
                              <label class="form-label">Nama Ayah</label>
                              <input type="text" class="form-control" name="namaayahpria" id="namaayahpria" placeholder="Nama ayah mempelai pria">
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="form-group">
                              <label class="form-label">Nama Ibu</label>
                              <input type="text" class="form-control" name="namaibupria" id="namaibupria" placeholder="Nama ibu mempelai pria">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                          <h5 class="text-muted mb-3">Informasi Mempelai Wanita</h5>
                          <div class="mb-3">
                            <div class="form-group">
                              <label class="form-label">Nama Mempelai</label>
                              <input type="text" class="form-control" name="namamempelaiwanita" id="namamempelaiwanita" placeholder="Nama mempelai wanita">
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="form-group">
                              <label class="form-label">Nama Ayah</label>
                              <input type="text" class="form-control" name="namaayahwanita" id="namaayahwanita" placeholder="Nama ayah mempelai wanita">
                            </div>
                          </div>
                          <div class="mb-3">
                            <div class="form-group">
                              <label class="form-label">Nama Ibu</label>
                              <input type="text" class="form-control" name="namaibuwanita" id="namaibuwanita" placeholder="Nama ibu mempelai wanita">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                      <h5 class="mb-2">Form Permohonan</h5>
                      <small class="d-block mb-2">Silahkan download form berikut dan serahkan kembali ke resepsionis Elshaddai (jam kerja: Selasa - Jumat).</small>
                      <div class="d-flex flex-column gap-2">
                        <a href="" class="text-primary" download=""><i class="far fa-file-archive me-2"></i> Form Pemberkatan Nikah</a>
                        <a href="" class="text-primary" download=""><i class="far fa-file-archive me-2"></i> Form Peneguhan Nikah</a>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex flex-column flex-md-row justify-content-center mt-4 gap-2">
                    <a href="<?php echo site_url('pernikahan') ?>" class="btn btn-outline-secondary px-4">Kembali</a>
                    <button type="submit" class="btn btn-primary px-4" id="btnSimpan"><i class="fa fa-save me-2"></i>Ajukan Permohonan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>
      var idpernikahan = "<?php echo $idpernikahan; ?>";

      $(document).ready(function() {
        if (idpernikahan != "") {
          $.ajax({
            type: 'GET',
            url: '<?php echo site_url("pernikahan/get_edit_data") ?>',
            data: { idpernikahan: idpernikahan },
            dataType: 'json',
            encode: true
          })
          .done(function(result) {
            $("#idpernikahan").val(result.idpernikahan);
            $("#nohpyangbisadihubungi").val(result.nohpyangbisadihubungi);
            $("#keterangan").val(result.keterangan);
            $("#namamempelaipria").val(result.namamempelaipria);
            $("#namaayahpria").val(result.namaayahpria);
            $("#namaibupria").val(result.namaibupria);
            $("#namamempelaiwanita").val(result.namamempelaiwanita);
            $("#namaayahwanita").val(result.namaayahwanita);
            $("#namaibuwanita").val(result.namaibuwanita);
          });

          $("#lbljudul").html("Ubah Permohonan Pernikahan");
        }


        $("#form").bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    keterangan: {
                        validators: {
                            notEmpty: {
                                message: "tanggal permohonan tidak boleh kosong"
                            },
                        }
                    },
                    namamempelaipria: {
                        validators: {
                            notEmpty: {
                                message: "Nama mempelai pria tidak boleh kosong"
                            },
                        }
                    },
                    namamempelaiwanita: {
                        validators: {
                            notEmpty: {
                                message: "Nama mempelai wanita tidak boleh kosong"
                            },
                        }
                    },
                    namaayahpria: {
                        validators: {
                            notEmpty: {
                                message: "Nama ayah tidak boleh kosong"
                            },
                        }
                    },
                    namaayahwanita: {
                        validators: {
                            notEmpty: {
                                message: "Nama ayah tidak boleh kosong"
                            },
                        }
                    },
                    namaibupria: {
                        validators: {
                            notEmpty: {
                                message: "Nama ibu tidak boleh kosong"
                            },
                        }
                    },
                    namaibuwanita: {
                        validators: {
                            notEmpty: {
                                message: "Nama ibu tidak boleh kosong"
                            },
                        }
                    },

                },
                onSuccess: function(e, data) {
                    // e.preventDefault();
                    $('#btnSimpan').prop('disabled', true);

                }
            });

      });
    </script>
  </div>
</body>
</html>
