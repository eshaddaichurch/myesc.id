<?php $this->load->view('template/festavalive/header'); ?>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
  @import url(' https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

  /* Vars CSS (simulasi SCSS) */
  :root {
    --main-green: #79dd09;
    --main-green-rgb-015: rgba(121, 221, 9, 0.1);
    --main-yellow: #bdbb49;
    --main-yellow-rgb-015: rgba(189, 187, 73, 0.1);
    --main-red: #bd150b;
    --main-red-rgb-015: rgba(189, 21, 11, 0.1);
    --main-blue: #0076bd;
    --main-blue-rgb-015: rgba(0, 118, 189, 0.1);
  }

  /* Breadcrumbs */
  .breadcrumbs {
    padding: 140px 0 60px 0;
    min-height: 30vh;
    position: relative;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    margin-bottom: 2rem;
  }
  .breadcrumbs::before {
    content: "";
    background-color: rgba(0, 0, 0, 0.6);
    position: absolute;
    inset: 0;
  }
  .breadcrumbs h2 {
    font-size: 56px;
    font-weight: 500;
    color: #fff;
    font-family: sans-serif;
  }
  .breadcrumbs ol {
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    padding: 0 0 10px 0;
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: var(--main-blue);
  }
  .breadcrumbs ol a {
    color: rgba(255, 255, 255, 0.8);
    transition: 0.3s;
  }
  .breadcrumbs ol a:hover {
    text-decoration: underline;
  }
  .breadcrumbs ol li + li {
    padding-left: 10px;
  }
  .breadcrumbs ol li + li::before {
    display: inline-block;
    padding-right: 10px;
    color: #fff;
    content: "/";
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Figtree', sans-serif;
    background-color: #e8d5a7;
    margin: 0;
    padding-top: 60px; /* tambahkan untuk menghindari tabrakan dengan navbar */
  }

  .form-card {
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: 0.3s;
  }

  .form-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
  }

  .form-card h5 {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 30px;
    color: #333;
  }

  .form-group label {
    font-weight: 500;
    color: #444;
    margin-bottom: 6px;
  }

  .form-control {
    border-radius: 8px !important;
    padding: 10px 12px;
    border: 1px solid #ccc;
    transition: border-color 0.3s ease;
  }

  .form-control:focus {
    border-color: #0076bd;
    box-shadow: none;
  }

  .btn-primary {
    background-color: #0076bd;
    border-color: #0076bd;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
  }

  .btn-default {
    background-color: #f0f0f0;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
  }

  small#charCount {
    display: block;
    margin-top: 6px;
    color: #666;
    font-size: 0.85rem;
  }

  textarea.form-control {
    resize: vertical;
  }

  .permohonan-form-section {
    background: #e8d5a7;
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
    background-color: #0d6efd;
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
                            <h4 class="mb-4 text-center fw-bold">Ajukan Permohonan Doa</h4>
                            <form action="<?= site_url('permohonandoa/simpan') ?>" method="POST" id="form">
                                <input type="hidden" name="idpermohonan" id="idpermohonan">

                                <div class="mb-3">
                                    <label for="idjenispermohonandoa" class="form-label">Jenis Permohonan Doa</label>
                                    <select name="idjenispermohonandoa" id="idjenispermohonandoa" class="form-select select2">
                                        <option value="">Pilih jenis permohonan doa...</option>
                                        <?php
                                        $rsJenisPermohonan = $this->db->query("select * from carepermohonandoa_jenis where statusaktif='Aktif' order by namajenispermohonandoa");
                                        foreach ($rsJenisPermohonan->result() as $row) {
                                            echo '<option value="' . $row->idjenispermohonandoa . '">' . $row->namajenispermohonandoa . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="nohpyangbisadihubungi" class="form-label">No HP Yang Bisa Dihubungi</label>
                                    <input type="text" name="nohpyangbisadihubungi" id="nohpyangbisadihubungi" class="form-control" placeholder="Nomor HP">
                                </div>

                                <div class="mb-3">
                                    <label for="keteranganpermohonan" class="form-label">Keterangan Permohonan</label>
                                    <textarea name="keteranganpermohonan" maxlength="1000" id="keteranganpermohonan" class="form-control" rows="6" placeholder="Uraikan pokok doa yang ingin didoakan.. (maks. 1000 karakter)"></textarea>
                                    <small id="charCount" class="form-text text-muted">0 / 1000 karakter</small>
                                </div>

                                <div class="d-flex flex-column flex-md-row justify-content-center mt-4 gap-2">
                                    <a href="<?= site_url('permohonandoa') ?>" class="btn btn-outline-secondary px-4">Kembali</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        const textarea = document.getElementById('keteranganpermohonan');
        const charCount = document.getElementById('charCount');

        textarea.addEventListener('input', function () {
            charCount.textContent = `${this.value.length} / 1000 karakter`;
        });
    });
    </script>


  </div>
</body>
</html>