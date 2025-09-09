<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

  body {
    font-family: 'Figtree', sans-serif;
    background-color: #e8d5a7;
    padding-top: 60px;
    margin: 0;
  }

  :root {
    --main-blue: #0076bd;
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
                <h4 id="lbljudul" class="mb-4 text-center fw-bold">Tambah Permohonan Konseling</h4>

                <form action="<?php echo site_url('konseling/simpan') ?>" method="POST" id="form">
                  <input type="hidden" name="idcarekonseling" id="idcarekonseling">

                  <div class="mb-3">
                    <label for="tglpermohonan" class="form-label">Tgl & Jam Permohonan</label>
                    <input type="datetime-local" name="tglpermohonan" id="tglpermohonan" class="form-control">
                  </div>

                  <div class="mb-3">
                    <label for="nohpyangbisadihubungi" class="form-label">No HP Yang Bisa Dihubungi</label>
                    <input type="text" name="nohpyangbisadihubungi" id="nohpyangbisadihubungi" class="form-control" placeholder="Nomor HP">
                  </div>

                  <div class="mb-3">
                    <label for="keteranganpermohonan" class="form-label">Keterangan Permohonan</label>
                    <textarea name="keteranganpermohonan" id="keteranganpermohonan" class="form-control" rows="6" placeholder="Keterangan (Optional)"></textarea>
                  </div>

                  <div class="d-flex flex-column flex-md-row justify-content-center mt-4 gap-2">
                    <a href="<?php echo site_url('konseling') ?>" class="btn btn-outline-secondary px-4">Kembali</a>
                    <button type="submit" class="btn btn-primary px-4"><i class="fa fa-save me-2"></i>Ajukan Permohonan</button>
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
      var idcarekonseling = "<?php echo $idcarekonseling; ?>";

      $(document).ready(function () {
        if (idcarekonseling != "") {
          $.ajax({
            type: 'GET',
            url: '<?php echo site_url("konseling/get_edit_data") ?>',
            data: { idcarekonseling: idcarekonseling },
            dataType: 'json',
            encode: true
          })
          .done(function (result) {
            $("#idcarekonseling").val(result.idcarekonseling);
            $("#tglpermohonan").val(result.tglpermohonan);
            $("#nohpyangbisadihubungi").val(result.nohpyangbisadihubungi);
            $("#keteranganpermohonan").val(result.keteranganpermohonan);
          });

          $("#lbljudul").html("Ubah Permohonan Konseling");
        }
      });
    </script>
  </div>
</body>
</html>
