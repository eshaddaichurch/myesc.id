<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <style>
      /* Import Fonts */
      @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');
      
      /* Reset & Base Styles */
      * { margin: 0; padding: 0; box-sizing: border-box; }

      body {
        font-family: 'Figtree', sans-serif !important;
        background-color: #0a0a0a !important;
        color: #ffffff !important;
        line-height: 1.6;
      }

      /* --- DESIGN OVERRIDES FOR EXISTING SECTIONS --- */

      /* 1. Styling untuk Section Deskripsi (Membership Section) */
      .membership-section {
        padding: 100px 20px 60px !important;
        max-width: 1200px;
        margin: 0 auto;
      }

      .membership-section h1 {
        font-size: 48px !important;
        font-weight: 700 !important;
        margin-bottom: 24px !important;
        color: #fff !important;
        text-transform: capitalize;
      }

      .membership-section p {
        color: rgba(255, 255, 255, 0.7) !important;
        font-size: 18px !important;
        margin-bottom: 20px !important;
        line-height: 1.8;
      }

      /* 2. Styling untuk Container Jadwal (Page Content) */
      .page-content {
        padding: 40px 20px 80px !important;
      }

      .page-content .container {
        max-width: 1200px;
      }

      /* 3. Styling Card Jadwal (Menggunakan class .card yang sudah ada) */
      .page-content .card {
        background: #1a1a1a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 16px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3) !important;
        margin-bottom: 24px !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
      }

      .page-content .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(255, 107, 53, 0.15) !important;
        border-color: rgba(255, 107, 53, 0.3) !important;
      }

      /* Header Card */
      .page-content .card h5 {
        font-size: 20px !important;
        font-weight: 600 !important;
        color: #fff !important;
        margin-bottom: 16px !important;
        display: flex;
        align-items: center;
        gap: 10px;
      }

      /* Info Text dalam Card */
      .page-content .card .col-12:not(:has(h5)) {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 14px !important;
        margin-bottom: 8px !important;
        display: flex;
        align-items: center;
        gap: 10px;
      }
      
      .page-content .card i {
        color: #ff6b35 !important;
        width: 20px;
        text-align: center;
      }

      /* Badge Status */
      .badge-status {
        font-size: 11px !important;
        padding: 4px 10px !important;
        border-radius: 20px !important;
        margin-left: 10px !important;
        font-weight: 500;
      }
      .bg-success { background: rgba(40, 167, 69, 0.2) !important; color: #28a745 !important; }
      .bg-secondary { background: rgba(255, 255, 255, 0.1) !important; color: rgba(255,255,255,0.7) !important; }

      /* Tombol Daftar */
      .btn-success {
        background: #ff6b35 !important;
        border-color: #ff6b35 !important;
        color: #fff !important;
        font-weight: 600 !important;
        padding: 10px 20px !important;
        border-radius: 8px !important;
        transition: all 0.3s ease;
      }
      .btn-success:hover {
        background: #ff5722 !important;
        border-color: #ff5722 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 107, 53, 0.3);
      }

      /* Alert Box */
      .alert {
        background: rgba(255, 255, 255, 0.05) !important;
        border-left: 4px solid #ff6b35 !important;
        color: rgba(255,255,255,0.9) !important;
        border-radius: 0 8px 8px 0;
        font-size: 13px !important;
      }
      .alert-warning { border-color: #ffc107 !important; color: #ffc107 !important; }
      .alert-danger { border-color: #dc3545 !important; color: #dc3545 !important; }

      /* 4. Styling untuk Desktop View (Promo Section) */
      .promo-section {
        padding: 40px 20px 80px !important;
        background: #0a0a0a;
      }
      
      .promo-title {
        color: #fff !important;
        font-size: 32px !important;
        font-weight: 700 !important;
        margin-bottom: 10px !important;
      }

      .promo-section .card {
        background: #1a1a1a !important;
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4) !important;
      }

      .promo-section .card-img-top {
        height: 200px !important;
        object-fit: cover !important;
      }

      .promo-section .card-body {
        padding: 24px !important;
      }

      .promo-section h4 {
        color: #fff !important;
        font-size: 18px !important;
        font-weight: 600 !important;
      }
      
      .promo-section p, 
      .promo-section strong {
        color: rgba(255,255,255,0.8) !important;
        font-size: 14px !important;
      }

      /* Responsive Adjustments */
      @media (max-width: 768px) {
        .membership-section h1 { font-size: 32px !important; }
        .membership-section p { font-size: 16px !important; }
        .page-content .card h5 { font-size: 18px !important; }
      }
    </style>

    <!-- 
      KONTEN HTML ASLI DIPERTAHANKAN 
      Kita hanya menambahkan class utilitas Bootstrap jika diperlukan, 
      tapi tidak mengubah struktur ID atau Name yang dipakai JS/PHP.
    -->

    <!-- Section Deskripsi -->
    <section class="membership-section">
      <h1>Foundation Class 1</h1>
      <p>Foundation Class 1 Salvation and Baptism (FC 1) adalah kelas dasar yang bertujuan membantu jemaat memahami secara mendalam arti keselamatan dan baptisan, dua aspek penting dalam kehidupan orang beriman. Kelas ini mengajak jemaat untuk mengenal lebih dalam anugerah keselamatan dari Yesus Kristus serta memahami peran baptisan sebagai langkah iman dalam menerima kasih karunia-Nya.</p>
      
      <p>Topik Pembelajaran :</p>
      
      <p>1. Keselamatan dalam Kristus Membahas firman Tuhan mengenai keselamatan sebagai anugerah dari Allah, bukan hasil usaha manusia, dengan dasar ayat dari Efesus 2:8-9.</p>
      
      <p>2. Baptisan Air dan Roh Kudus Memaparkan arti simbolis dan spiritual dari baptisan, sekaligus pentingnya komitmen pribadi dalam menerima baptisan sebagai wujud iman, sesuai Roma 6:3-4 dan Kisah Para Rasul 2:38.</p>
      
      <p>Kelas ini dikemas secara interaktif dengan diskusi dan tanya jawab, memungkinkan setiap jemaat untuk menggali konsep-konsep penting, bertanya, dan berbagi pengalaman guna memperdalam iman. Setelah mengikuti kelas ini, jemaat diharapkan semakin siap melangkah dalam iman dan menerima baptisan sebagai bentuk ketaatan perubahan hidup dalam Kristus.</p>
    </section>

    <!-- Section Mobile (Original Structure) -->
    <section class="page-content section-padding d-md-none d-sm-block">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card" data-aos="zoom-in">
              <div class="card-body">
                <div class="row">
                  <?php
                  // LOGIKA PHP ASLI DIPERTAHANKAN PENUH
                  if ($rsJadwal->num_rows() > 0) {
                    foreach ($rsJadwal->result() as $rowJadwal) {
                      $tglmulai = date('d-m-Y', strtotime($rowJadwal->tglmulai));
                      $tglselesai = date('d-m-Y', strtotime($rowJadwal->tglselesai));

                      $jamMulai = date('H:i', strtotime($rowJadwal->tglmulai));
                      $jamSelesai = date('H:i', strtotime($rowJadwal->tglselesai));

                      $tglEvent = ($tglmulai == $tglselesai) ? $tglmulai : "$tglmulai s/d $tglselesai";
                      $jamEvent = ($jamMulai == $jamSelesai) ? $jamMulai : "$jamMulai WIB s/d $jamSelesai WIB";

                      $maxJemaat = $rowJadwal->jumlahjemaat ?: 0;

                      $nJumlah = $this->db->query("
                        SELECT COUNT(*) AS jlh FROM jadwaleventregistrasi
                        WHERE idjadwalevent='" . $rowJadwal->idjadwalevent . "' AND statuskonfirmasi<>'Ditolak'
                      ")->row()->jlh;

                      $jumlahPeserta = ($maxJemaat == 0) ? $nJumlah : (
                        $nJumlah == $maxJemaat
                          ? '<span class="text-danger">' . $nJumlah . '/' . $maxJemaat . '</span>'
                          : $nJumlah . '/' . $maxJemaat
                      );

                      $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar($rowJadwal->idjadwalevent, $this->session->userdata('idjemaat'));

                      $button = $sudahPernahDaftar ? '' : '<a href="#" class="btn btn-success btn-sm" data-idjadwalevent="' . $rowJadwal->idjadwalevent . '" id="btnDaftar">Daftar Sekarang</a>';

                      $rsLokasi = $this->db->query("SELECT * FROM jadwaleventdetailtanggal WHERE idjadwalevent = '" . $rowJadwal->idjadwalevent . "' LIMIT 1");
                      $namaLokasi = ($rsLokasi->num_rows() > 0) ? $rsLokasi->row()->lokasievent : '';

                      echo '
                        <div class="col-12" data-aos="fade-up">
                          <h5>' . $rowJadwal->namaevent . '
                            ' . ($sudahPernahDaftar ? '<span class="badge bg-success badge-status">Sudah Daftar</span>' : '<span class="badge bg-secondary badge-status">Baru</span>') . '
                          </h5>
                        </div>
                        <div class="col-12"><i class="fas fa-map-marker-alt me-2"></i> ' . $namaLokasi . '</div>
                        <div class="col-12"><i class="fa fa-calendar me-2"></i> ' . $tglEvent . '</div>
                        <div class="col-12"><i class="far fa-clock me-2"></i> ' . $jamEvent . '</div>
                        <div class="col-12"><i class="fas fa-user-check me-2"></i> ' . $jumlahPeserta . '</div>
                      ';

                      if ($sudahPernahDaftar) {
                        $rsDaftar = $this->db->query("SELECT * FROM v_jadwaleventregistrasi WHERE idjadwalevent='" . $rowJadwal->idjadwalevent . "' AND idjemaat='" . $this->session->userdata('idjemaat') . "'");
                        if ($rsDaftar->num_rows() > 0) {
                          foreach ($rsDaftar->result() as $rowDaftar) {
                            $status = $rowDaftar->statuskonfirmasi;
                            $alertClass = $status == 'Menunggu' ? 'warning' : ($status == 'Disetujui' ? 'success' : 'danger');
                            $pesan = '';

                            if ($status == 'Menunggu') {
                              $pesan = 'Pengajuan pendaftaran kelas anda masih dalam proses <strong>Menunggu</strong>!';
                            } elseif ($status == 'Disetujui') {
                              $pesan = 'Pengajuan pendaftaran kelas sudah <strong>Disetujui</strong>!<br>Silahkan datang pada waktu jadwal yang telah ditentukan.';
                            } elseif ($status == 'Ditolak') {
                              $pesan = 'Pengajuan pendaftaran kelas <strong>Ditolak</strong>!<br>' . $rowDaftar->keterangankonfirmasi;
                            }

                            echo '
                              <div class="col-12 mt-3 ps-3">
                                <div class="alert alert-' . $alertClass . '" role="alert">
                                  <strong>Status Pengajuan : ' . $status . '</strong><br><br>' . $pesan . '
                                </div>
                              </div>';
                          }
                        }
                      }

                      echo '
                        <div class="col-12 mt-3">' . $button . '</div>
                        <hr class="my-4" style="border-color: rgba(255,255,255,0.1)">';
                    }
                  } else {
                    echo '<div class="text-center" style="color: rgba(255,255,255,0.6); padding: 20px;">Jadwal kelas belum dibuka...</div>';
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Section Desktop (Original Structure) -->
    <section class="page-content promo-section d-none d-md-block">
      <div class="container">
        <div class="row justify-content-center">

          <div class="col-12 mb-4 text-center">
            <h2 class="promo-title">Jadwal Pendaftaran Kelas</h2>
            <hr class="w-25 mx-auto" style="border-color: #ff6b35; opacity: 0.5">
          </div>

          <?php
          // LOGIKA PHP ASLI DIPERTAHANKAN PENUH
          if ($rsJadwal->num_rows() > 0) {
            foreach ($rsJadwal->result() as $rowJadwal) {
              $tglmulai = date('d-m-Y', strtotime($rowJadwal->tglmulai));
              $tglselesai = date('d-m-Y', strtotime($rowJadwal->tglselesai));
              $jamMulai = date('H:i', strtotime($rowJadwal->tglmulai));
              $jamSelesai = date('H:i', strtotime($rowJadwal->tglselesai));

              $tglEvent = ($tglmulai == $tglselesai) ? $tglmulai : "$tglmulai <br><small class='text-muted'>s/d</small><br> $tglselesai";
              $jamEvent = ($jamMulai == $jamSelesai) ? $jamMulai : "$jamMulai WIB <br><small class='text-muted'>s/d</small><br> $jamSelesai WIB";

              $maxJemaat = $rowJadwal->jumlahjemaat ?: 0;
              $nJumlah = $this->db->query("SELECT COUNT(*) as jlh FROM jadwaleventregistrasi WHERE idjadwalevent='{$rowJadwal->idjadwalevent}' AND statuskonfirmasi<>'Ditolak'")->row()->jlh;
              $jumlahPeserta = ($maxJemaat == 0) ? $nJumlah : ($nJumlah == $maxJemaat ? "<span class='text-danger'>$nJumlah/$maxJemaat</span>" : "$nJumlah/$maxJemaat");

              $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar($rowJadwal->idjadwalevent, $this->session->userdata('idjemaat'));

              $button = !$sudahPernahDaftar
                ? '<a href="#" class="btn btn-success btn-lg w-100" id="btnDaftar" data-idjadwalevent="' . $rowJadwal->idjadwalevent . '">Daftar Sekarang</a>'
                : '';
              ?>
              <div class="col-md-6 col-lg-5 mb-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                  <img src="<?php echo base_url('myesc.id/assets/gambar/bgkelas.jpg'); ?>" class="card-img-top" alt="Banner Event">
                  <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h4 class="fw-bold"><i class="bi bi-calendar-event me-2"></i> <?php echo $rowJadwal->namaevent ?></h4>
                      <span class="badge bg-secondary fs-6">Peserta: <?php echo $jumlahPeserta ?></span>
                    </div>
                    <p class="fs-5 mb-2"><strong>📆 Tanggal:</strong><br><?php echo $tglEvent ?></p>
                    <p class="fs-5 mb-2"><strong>⏰ Jam:</strong><br><?php echo $jamEvent ?></p>
                    <div class="mt-4"><?php echo $button ?></div>
                  </div>

                  <?php if ($sudahPernahDaftar): ?>
                    <?php
                    $rsDaftar = $this->db->query("SELECT * FROM v_jadwaleventregistrasi WHERE idjadwalevent='{$rowJadwal->idjadwalevent}' AND idjemaat='{$this->session->userdata('idjemaat')}'");
                    if ($rsDaftar->num_rows() > 0):
                      foreach ($rsDaftar->result() as $rowDaftar):
                        $status = $rowDaftar->statuskonfirmasi;
                        $tglDaftar = date('d-m-Y H:i:s', strtotime($rowDaftar->tglregistrasi));
                        $alertClass = $status == 'Menunggu' ? 'warning' : ($status == 'Disetujui' ? 'success' : 'danger');
                        $pesan = $status == 'Menunggu'
                          ? 'Pengajuan pendaftaran kelas anda masih dalam proses <strong>Menunggu</strong>!'
                          : ($status == 'Disetujui'
                            ? 'Pengajuan pendaftaran kelas sudah <strong>Disetujui</strong>! Silahkan datang pada waktu jadwal yang telah ditentukan.'
                            : 'Pengajuan pendaftaran kelas <strong>Ditolak</strong>!<br>' . $rowDaftar->keterangankonfirmasi);
                        ?>
                        <div class="card-footer bg-light border-0">
                          <div class="alert alert-<?php echo $alertClass ?> mb-0" style="font-size: 0.9rem;">
                            <strong>👤 Nama Jemaat:</strong> <?php echo $rowDaftar->namalengkap ?><br>
                            <strong>🗓️ Tgl Pengajuan:</strong> <?php echo $tglDaftar ?><br>
                            <strong>Status:</strong> <?php echo $status ?><br><br>
                            <?php echo $pesan ?>
                          </div>
                        </div>
                    <?php endforeach;
                    endif; ?>
                  <?php endif; ?>
                </div>
              </div>
          <?php
            }
          } else {
            echo '
              <div class="col-12 text-center">
                <div class="alert alert-info" style="background: rgba(255,255,255,0.1); border:none; color: #fff;">Jadwal kelas ' . $rowKelas->namakelas . ' belum dibuka.</div>
              </div>';
          }
          ?>
        </div>
      </div>
    </section>

    <!-- jQuery & SweetAlert -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
      // LOGIKA JAVASCRIPT ASLI DIPERTAHANKAN (FIXED SYNTAX)
      $(document).on('click', '#btnDaftar', function(e) {
        var idjadwalevent = $(this).attr('data-idjadwalevent');

        e.preventDefault();

        $.ajax({
          url: '<?= site_url('nextstep/ajaxCeStatusWhatsAPP') ?>',
          type: 'GET',
          dataType: 'json',
        })
        .done(function(response) {

          if (response.statusverifikasiwa) {

            swal({
              title: "Daftar Kelas?",
              text: "Anda ingin mendaftar di kelas ini? Pastikan anda sudah memenuhi persyaratan untuk mendaftar.",
              icon: "info",
              buttons: ["Batal!", "Ya!"],
              dangerMode: true,
            })
            .then((daftarkelas) => {
              if (daftarkelas) {

                $.ajax({
                    url: '<?php echo site_url('nextstep/daftar') ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: { // <--- FIX: Menambahkan key 'data:' yang sebelumnya hilang
                      'idjadwalevent': idjadwalevent
                    },
                  })
                  .done(function(daftarResult) {
                    console.log(daftarResult);

                    if (daftarResult.success) {
                      swal("Berhasil", "Pengajuan pendaftaran kelas next step anda berhasil disimpan. Periksa kembali status pengajuan pendaftaran anda dalam 2x24 Jam", "success")
                        .then(function() {
                          window.open("<?php echo site_url('nextstep/kelas/' . $kelas_slug . '/' . $this->encrypt->encode($menu)) ?>", "_self");
                        });
                    } else {
                      swal("Gagal", daftarResult.msg, "info");
                    }
                  })
                  .fail(function() {
                    console.log("error");
                  });

              }
            });

          } else {
            swal({
              title: "Nomor WhatsApp Belum Terverifikasi",
              text: "Silahkan verifikasi nomor whatsapp terlebih dahulu!",
              icon: "info",            
            })
            .then(() => {
              window.location.href = '<?php echo site_url('akun/ubahprofil') ?>';
            });
          }
        })
        .fail(function() {
          console.log('error');
          swal("Gagal", "Terjadi kesalahan", "error");
        });
      });
    </script>

    <?php $this->load->view('template/festavalive/footer'); ?>