<?php $this->load->view('template/festavalive/header'); ?>

<body>

    <main>



        <?php $this->load->view('template/festavalive/topmenu'); ?>


        <section class="about-section section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-12 mb-4 mb-lg-0">
                        <h2 class="text-white text-center mb-4 mt-3">Kelas Saya</h2>
                    </div>

                </div>
            </div>
        </section>



        <section class="about-section section-padding bg-dark text-white">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="mb-3 mt-2">📚 Kelas Saya</h2>
        <p class="text-light">Daftar kelas yang sudah Anda ikuti</p>
      </div>
    </div>
  </div>
</section>

<section class="page-content section-padding">
  <div class="container">
    <div class="row g-4">
      <?php
      if ($rskelas->num_rows() > 0) {
        foreach ($rskelas->result() as $row) {
          $kelas_slug = $this->db->query("SELECT * FROM kelas WHERE idkelas='" . $row->idkelas . "'")->row()->kelas_slug;

          $tglsertifikat = !empty($row->tglsertifikat) ? tglindonesia($row->tglsertifikat) : '—';

          if ($row->statuslulus == '1') {
            $statuslulus = '<span class="badge bg-success px-3 py-2">Lulus</span>';
            $btnAksi = '<a href="' . site_url('akun/sertifikat/' . $row->idregistrasikelas) . '" class="btn btn-sm w-100" style="background-color:#e04607;color:white;" target="_blank">🎓 Lihat Sertifikat</a>';
          } else {
            $statuslulus = '<span class="badge bg-danger px-3 py-2">Belum Lulus</span>';
            $btnAksi = '<a href="' . site_url('nextstep/kelas/' . $kelas_slug . '/') . '" class="btn btn-sm btn-primary w-100">📖 Registrasi Kelas</a>';
          }

          echo "
          <div class='col-12 col-md-6 col-lg-4'>
            <div class='card h-100 shadow-sm border-0'>
              <div class='card-body d-flex flex-column'>
                <h5 class='fw-bold mb-2 text-primary'>{$row->namakelas}</h5>
                <div class='mb-2'>{$statuslulus}</div>
                <p class='mb-3 text-muted'>Tgl Kelulusan: {$tglsertifikat}</p>
                <div class='mt-auto'>{$btnAksi}</div>
              </div>
            </div>
          </div>
          ";
        }
      } else {
        echo "
        <div class='col-12 text-center'>
          <div class='alert alert-info'>Belum ada kelas yang diikuti.</div>
        </div>";
      }
      ?>
    </div>
  </div>
</section>







    </main>


    <?php $this->load->view('template/festavalive/footer'); ?>

    <script>

    </script>

</body>

</html>