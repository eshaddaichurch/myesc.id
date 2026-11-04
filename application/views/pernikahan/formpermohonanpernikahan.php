<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap');

  :root {
    --pf-orange: #ea580c;
    --pf-orange-dark: #c2410c;
    --pf-black: #111111;
    --pf-text: #1f2937;
    --pf-muted: #6b7280;
    --pf-border: #e5e7eb;
    --pf-bg: #f4f6fa;
  }

  body {
    font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
    background: var(--pf-bg);
    color: var(--pf-text);
    margin: 0;
    position: relative;
  }

  /* Hero band hitam ke oranye di belakang navbar */
  body::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 280px;
    background: linear-gradient(135deg, #111111 0%, #1f1f1f 60%, #ea580c 100%);
    z-index: 0;
  }
  .page-wrapper {
    position: relative;
    z-index: 1;
  }

  .pf-page {
    padding: 110px 0 80px;
    min-height: 100vh;
  }

  .pf-header {
    margin-bottom: 28px;
  }
  .pf-header h2 {
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 6px;
    letter-spacing: -0.3px;
  }
  .pf-header p {
    color: rgba(255, 255, 255, 0.85);
    margin: 0;
    font-size: 15px;
  }

  .pf-card {
    background: #fff;
    border: 1px solid var(--pf-border);
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 10px 30px rgba(16, 24, 40, 0.08);
  }

  .pf-section {
    border: 1px solid var(--pf-border);
    border-radius: 14px;
    padding: 20px;
    height: 100%;
    background: #fff;
  }
  .pf-section-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--pf-text);
    margin: 0 0 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid var(--pf-orange);
    display: inline-block;
  }

  .form-label {
    font-size: 14px;
    font-weight: 600;
    color: var(--pf-text);
    margin-bottom: 6px;
  }

  .form-control {
    border-radius: 10px;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    font-size: 15px;
    color: var(--pf-text);
    background: #fff;
  }
  .form-control::placeholder {
    color: #9ca3af;
  }
  .form-control:focus {
    border-color: var(--pf-orange);
    box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.15);
  }
  .form-control[readonly] {
    background: #f9fafb;
    color: var(--pf-muted);
  }

  .pf-field {
    margin-bottom: 16px;
  }
  .pf-field:last-child {
    margin-bottom: 0;
  }

  .pf-download {
    background: #fff7ed;
    border: 1px solid #fed7aa;
    border-radius: 14px;
    padding: 18px 20px;
    margin-top: 24px;
  }
  .pf-download h5 {
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 4px;
  }
  .pf-download small {
    color: var(--pf-muted);
    display: block;
    margin-bottom: 12px;
  }
  .pf-download a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--pf-orange-dark);
    font-weight: 600;
    text-decoration: none;
    padding: 6px 0;
  }
  .pf-download a:hover {
    text-decoration: underline;
  }

  .pf-actions {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-top: 28px;
    flex-wrap: wrap;
  }
  .btn-pf-primary {
    background: var(--pf-orange);
    color: #fff;
    border: none;
    padding: 12px 26px;
    font-weight: 700;
    border-radius: 10px;
    transition: background 0.2s ease;
  }
  .btn-pf-primary:hover {
    background: var(--pf-orange-dark);
    color: #fff;
  }
  .btn-pf-primary:disabled {
    background: #fdba74;
  }
  .btn-pf-outline {
    background: transparent;
    color: var(--pf-black);
    border: 1px solid var(--pf-black);
    padding: 12px 26px;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.2s ease;
  }
  .btn-pf-outline:hover {
    background: var(--pf-black);
    color: #fff;
  }

  @media (max-width: 576px) {
    .pf-page { padding-top: 90px; }
    .pf-header h2 { font-size: 24px; }
    .pf-card { padding: 20px; }
    .btn-pf-primary, .btn-pf-outline { width: 100%; text-align: center; }
  }
</style>

<body>
  <div class="page-wrapper">
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <section class="pf-page">
      <div class="container" style="max-width: 960px;">

        <div class="pf-header">
          <h2 id="lbljudul">Tambah Permohonan Pernikahan</h2>
          <p>Lengkapi data berikut dengan benar sebelum mengajukan permohonan.</p>
        </div>

        <div class="pf-card">
          <form action="<?php echo site_url('pernikahan/simpan') ?>" method="POST" id="form">
            <input type="hidden" name="idpernikahan" id="idpernikahan">

            <div class="row g-4">
              <div class="col-12">
                <div class="pf-section">
                  <h5 class="pf-section-title">Informasi Permohonan</h5>

                  <div class="row g-3">
                    <div class="col-md-5 pf-field">
                      <label class="form-label">No HP Yang Bisa Dihubungi</label>
                      <input type="text" name="nohpyangbisadihubungi" id="nohpyangbisadihubungi" class="form-control" placeholder="Nomor HP" value="<?php echo $this->session->userdata('nohp'); ?>" readonly>
                    </div>
                    <div class="col-md-7 pf-field">
                      <label class="form-label">Keterangan Permohonan</label>
                      <textarea name="keterangan" id="keterangan" class="form-control" rows="2" placeholder="Contoh: rencana pernikahan tahun 2027, tanggal menyusul." autofocus></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="pf-section">
                  <h5 class="pf-section-title">Mempelai Pria</h5>
                  <div class="pf-field">
                    <label class="form-label">Nama Mempelai</label>
                    <input type="text" class="form-control" name="namamempelaipria" id="namamempelaipria" placeholder="Nama mempelai pria">
                  </div>
                  <div class="pf-field">
                    <label class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control" name="namaayahpria" id="namaayahpria" placeholder="Nama ayah mempelai pria">
                  </div>
                  <div class="pf-field">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control" name="namaibupria" id="namaibupria" placeholder="Nama ibu mempelai pria">
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="pf-section">
                  <h5 class="pf-section-title">Mempelai Wanita</h5>
                  <div class="pf-field">
                    <label class="form-label">Nama Mempelai</label>
                    <input type="text" class="form-control" name="namamempelaiwanita" id="namamempelaiwanita" placeholder="Nama mempelai wanita">
                  </div>
                  <div class="pf-field">
                    <label class="form-label">Nama Ayah</label>
                    <input type="text" class="form-control" name="namaayahwanita" id="namaayahwanita" placeholder="Nama ayah mempelai wanita">
                  </div>
                  <div class="pf-field">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" class="form-control" name="namaibuwanita" id="namaibuwanita" placeholder="Nama ibu mempelai wanita">
                  </div>
                </div>
              </div>
            </div>

            <!-- <div class="pf-download">
              <h5>Form Permohonan</h5>
              <small>Silahkan download form berikut dan serahkan kembali ke resepsionis Elshaddai (jam kerja: Selasa - Jumat).</small>
              <a href="" download><i class="far fa-file-archive"></i> Form Pemberkatan Nikah</a><br>
              <a href="" download><i class="far fa-file-archive"></i> Form Peneguhan Nikah</a>
            </div> -->

            <div class="pf-actions">
              <a href="<?php echo site_url('pernikahan') ?>" class="btn-pf-outline">Kembali</a>
              <button type="submit" class="btn-pf-primary" id="btnSimpan"><i class="fa fa-save me-2"></i>Ajukan Permohonan</button>
            </div>
          </form>
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
                notEmpty: { message: "Keterangan tidak boleh kosong" }
              }
            },
            namamempelaipria: {
              validators: {
                notEmpty: { message: "Nama mempelai pria tidak boleh kosong" }
              }
            },
            namamempelaiwanita: {
              validators: {
                notEmpty: { message: "Nama mempelai wanita tidak boleh kosong" }
              }
            },
            namaayahpria: {
              validators: {
                notEmpty: { message: "Nama ayah tidak boleh kosong" }
              }
            },
            namaayahwanita: {
              validators: {
                notEmpty: { message: "Nama ayah tidak boleh kosong" }
              }
            },
            namaibupria: {
              validators: {
                notEmpty: { message: "Nama ibu tidak boleh kosong" }
              }
            },
            namaibuwanita: {
              validators: {
                notEmpty: { message: "Nama ibu tidak boleh kosong" }
              }
            }
          },
          onSuccess: function(e, data) {
            $('#btnSimpan').prop('disabled', true);
          }
        });
      });
    </script>
  </div>
</body>
</html>