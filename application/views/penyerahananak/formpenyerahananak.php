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

  .form-control, .form-select {
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

  textarea.form-control {
    resize: vertical;
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
                <h4 id="lbljudul" class="mb-4 text-center fw-bold">Form Permohonan Penyerahan Anak</h4>

                <form action="<?php echo site_url('penyerahananak/simpan') ?>" method="POST" id="form">
                  <input type="hidden" name="idpenyerahananak" id="idpenyerahananak">

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">Nama Lengkap Anak</label>
                      <input type="text" name="namaanak" id="namaanak" class="form-control" placeholder="Nama lengkap anak">
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">Tempat / Tanggal Lahir</label>
                      <div class="row g-2">
                        <div class="col-md-7">
                          <input type="text" name="tempatlahir" id="tempatlahir" class="form-control" placeholder="Tempat lahir">
                        </div>
                        <div class="col-md-5">
                          <input type="date" name="tgllahir" id="tgllahir" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">Nama Lengkap Ayah</label>
                      <input type="text" name="namaayah" id="namaayah" class="form-control" placeholder="Nama lengkap ayah">
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">Nama Lengkap Ibu</label>
                      <input type="text" name="namaibu" id="namaibu" class="form-control" placeholder="Nama lengkap ibu">
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">No HP Yang Bisa Dihubungi</label>
                      <input type="text" name="nohpyangbisadihubungi" id="nohpyangbisadihubungi" class="form-control" placeholder="Nomor HP" value="<?php echo $this->session->userdata('nohp'); ?>" readonly>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label class="form-label">Keterangan Permohonan</label>
                      <textarea name="keteranganpermohonan" id="keteranganpermohonan" class="form-control" rows="6" placeholder="Keterangan (Optional)"></textarea>
                    </div>
                  </div>

                  <div class="d-flex flex-column flex-md-row justify-content-center mt-4 gap-2">
                    <a href="<?php echo site_url('penyerahananak') ?>" class="btn btn-outline-secondary px-4">Kembali</a>
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
      var idpenyerahananak = "<?php echo $idpenyerahananak; ?>";

      $(document).ready(function() {
        if (idpenyerahananak != "") {
          $.ajax({
            type: 'GET',
            url: '<?php echo site_url("penyerahananak/get_edit_data") ?>',
            data: { idpenyerahananak: idpenyerahananak },
            dataType: 'json',
            encode: true
          })
          .done(function(result) {
            $("#idpenyerahananak").val(result.idpenyerahananak);
            $("#namaanak").val(result.namaanak);
            $("#tempatlahir").val(result.tempatlahir);
            $("#tgllahir").val(result.tgllahir);
            $("#namaayah").val(result.namaayah);
            $("#namaibu").val(result.namaibu);
            $("#nohpyangbisadihubungi").val(result.nohpyangbisadihubungi);
            $("#keteranganpermohonan").val(result.keteranganpermohonan);
          });

          $("#lbljudul").html("Ubah Form Permohonan Penyerahan Anak");
        }


        $("#form").bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    namaanak: {
                        validators: {
                            notEmpty: {
                                message: "Nama anak tidak boleh kosong"
                            },
                        }
                    },
                    tempatlahir: {
                        validators: {
                            notEmpty: {
                                message: "Tempat lahir tidak boleh kosong"
                            },
                        }
                    },
                    tgllahir: {
                        validators: {
                            notEmpty: {
                                message: "tanggal lahir tidak boleh kosong"
                            },
                        }
                    },
                    namaayah: {
                        validators: {
                            notEmpty: {
                                message: "nama ayah tidak boleh kosong"
                            },
                        }
                    },
                    namaibu: {
                        validators: {
                            notEmpty: {
                                message: "nama ibu tidak boleh kosong"
                            },
                        }
                    },
                    nohpyangbisadihubungi: {
                        validators: {
                            notEmpty: {
                                message: "Nomor hp yang bisa dihubungi tidak boleh kosong"
                            },
                        }
                    },
                    keteranganpermohonan: {
                        validators: {
                            notEmpty: {
                                message: "Keterangan permohonan tidak boleh kosong"
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
