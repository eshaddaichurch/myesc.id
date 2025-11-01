<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

  body {
    font-family: 'Figtree', sans-serif;
    background-color: #e8d5a7;
    padding-top: 60px;
    margin: 0;
  }

  .permohonan-form-section {
    /* background: #e8d5a7; */
    background: linear-gradient(63deg, #fffaf5, #ffb347);
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

  .form-control:focus, .form-select:focus {
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

  @media (max-width: 576px) {
    .form-control, .form-select {
      font-size: 0.95rem;
    }
  }
</style>

<body>
  <div class="page-wrapper">
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <section class="permohonan-form-section py-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8 col-md-10">
            <div class="card shadow rounded-4 border-0 p-4">
              <div class="card-body">
                <h4 id="lbljudul" class="mb-4 text-center fw-bold">Tambah Permohonan Kunjungan</h4>

                <form action="<?php echo site_url('kunjunganjemaat/simpan') ?>" method="POST" id="form">
                  <input type="hidden" name="idkunjunganjemaat" id="idkunjunganjemaat">

                  <div class="mb-3">
                    <div class="form-group">
                      <label for="idjeniskunjunganjemaat" class="form-label">Jenis Kunjungan</label>
                      <select name="idjeniskunjunganjemaat" id="idjeniskunjunganjemaat" class="form-select select2">
                        <option value="">Pilih jenis kunjungan...</option>
                        <?php
                        $rsJenisKunjungan = $this->db->query("select * from carekunjunganjemaatjenis where statusaktif='Aktif'");
                        foreach ($rsJenisKunjungan->result() as $row) {
                            echo '<option value="' . $row->idjeniskunjunganjemaat . '">' . $row->namajeniskunjunganjemaat . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label for="alamatjemaat" class="form-label">Alamat Lengkap</label>
                      <textarea name="alamatjemaat" id="alamatjemaat" class="form-control" rows="2" placeholder="Alamat / lokasi tempat yang akan dikunjungi"><?php echo $this->session->userdata('alamatrumah'); ?></textarea>
                    </div>
                  </div>

                  <div class="mb-3">
                    <div class="form-group">
                      <label for="keterangankunjungan" class="form-label">Keterangan Permohonan</label>
                      <textarea name="keterangankunjungan" id="keterangankunjungan" class="form-control" rows="6" placeholder="Jelaskan maksud dan tujuan dari permohonan kunjungan"></textarea>
                    </div>
                  </div>

                  <div class="d-flex flex-column flex-md-row justify-content-center mt-4 gap-2">
                    <a href="<?php echo site_url('kunjunganjemaat') ?>" class="btn btn-outline-secondary px-4">Kembali</a>
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
      var idkunjunganjemaat = "<?php echo $idkunjunganjemaat; ?>";

      $(document).ready(function () {
        $('.select2').select2();

        if (idkunjunganjemaat != "") {
          $.ajax({
            type: 'GET',
            url: '<?php echo site_url("kunjunganjemaat/get_edit_data") ?>',
            data: { idkunjunganjemaat: idkunjunganjemaat },
            dataType: 'json',
            encode: true
          })
          .done(function (result) {
            $("#idkunjunganjemaat").val(result.idkunjunganjemaat);
            $("#idjeniskunjunganjemaat").val(result.idjeniskunjunganjemaat).trigger('change');
            $("#keterangankunjungan").val(result.keterangankunjungan);
            $("#alamatjemaat").val(result.alamatjemaat);
          });

          $("#lbljudul").html("Ubah Permohonan Kunjungan");
        }

        $("#form").bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    idjeniskunjunganjemaat: {
                        validators: {
                            notEmpty: {
                                message: "Jenis kunjungan tidak boleh kosong"
                            },
                        }
                    },
                    alamatjemaat: {
                        validators: {
                            notEmpty: {
                                message: "Alamat tidak boleh kosong"
                            },
                        }
                    },
                    keterangankunjungan: {
                        validators: {
                            notEmpty: {
                                message: "Keterangan tidak boleh kosong"
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
