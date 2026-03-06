<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');
      
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: 'Figtree', sans-serif;
        background-color: #0a0a0a;
        color: #ffffff;
        line-height: 1.6;
      }

      /* Header Section */
      .equip-header {
        padding: 80px 20px 40px;
        max-width: 1200px;
        margin: 0 auto;
      }

      .equip-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 20px;
        color: #fff;
      }

      .equip-badge::before {
        content: "🎓";
      }

      .equip-title {
        font-size: 56px;
        font-weight: 700;
        margin-bottom: 20px;
        line-height: 1.2;
      }

      .equip-description {
        font-size: 18px;
        color: rgba(255, 255, 255, 0.7);
        max-width: 800px;
        line-height: 1.8;
      }

      /* Schedule Section */
      .schedule-section {
        padding: 40px 20px 80px;
        max-width: 1200px;
        margin: 0 auto;
      }

      .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 30px;
      }

      .section-title::before {
        content: "📅";
        font-size: 28px;
      }

      .schedule-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 24px;
      }

      .schedule-card {
        background: #1a1a1a;
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }

      .schedule-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
      }

      .card-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
      }

      .card-content {
        padding: 24px;
      }

      .card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
      }

      .card-title {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
      }

      .capacity-badge {
        text-align: right;
      }

      .capacity-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }

      .capacity-value {
        font-size: 14px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
      }

      .capacity-value.full {
        color: #ff4757;
      }

      .card-info {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 24px;
      }

      .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
      }

      .info-icon {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff6b35;
      }

      .btn-daftar {
        width: 100%;
        background: #ff6b35;
        color: #fff;
        border: none;
        padding: 16px 24px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
      }

      .btn-daftar:hover {
        background: #ff5722;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
      }

      .btn-daftar:disabled {
        background: #333;
        cursor: not-allowed;
        transform: none;
      }

      /* Help Section */
      .help-section {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 80px;
      }

      .help-card {
        background: #1a1a1a;
        border-radius: 16px;
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
      }

      .help-content {
        display: flex;
        align-items: center;
        gap: 20px;
        flex: 1;
      }

      .help-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 107, 53, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
      }

      .help-text h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 4px;
      }

      .help-text p {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        margin: 0;
      }

      .btn-hubungi {
        background: transparent;
        border: 2px solid #ff6b35;
        color: #ff6b35;
        padding: 14px 28px;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
      }

      .btn-hubungi:hover {
        background: #ff6b35;
        color: #fff;
      }

      /* Alert Styles */
      .alert-custom {
        padding: 16px;
        border-radius: 8px;
        margin-top: 16px;
        font-size: 14px;
      }

      .alert-warning {
        background: rgba(255, 193, 7, 0.1);
        border-left: 4px solid #ffc107;
        color: #ffc107;
      }

      .alert-success {
        background: rgba(40, 167, 69, 0.1);
        border-left: 4px solid #28a745;
        color: #28a745;
      }

      .alert-danger {
        background: rgba(220, 53, 69, 0.1);
        border-left: 4px solid #dc3545;
        color: #dc3545;
      }

      .badge-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-left: 10px;
      }

      .badge-success {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
      }

      .badge-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.7);
      }

      /* Responsive */
      @media (max-width: 768px) {
        .equip-title {
          font-size: 36px;
        }

        .equip-description {
          font-size: 16px;
        }

        .schedule-grid {
          grid-template-columns: 1fr;
        }

        .help-card {
          flex-direction: column;
          text-align: center;
        }

        .help-content {
          flex-direction: column;
        }

        .btn-hubungi {
          width: 100%;
          justify-content: center;
        }
      }

      /* Hide original sections */
      .membership-section {
        display: none !important;
      }

      .page-content {
        display: none !important;
      }
    </style>

    <!-- Header Section -->
    <section class="equip-header">
      <div class="equip-badge">EQUIP PROGRAM</div>
      <h1 class="equip-title">Foundation Class 1</h1>
      <p class="equip-description">
        Temukan makna mendalam dari keselamatan dan langkah ketaatan melalui baptisan. Mari bertumbuh bersama dalam fondasi iman yang kuat dalam perjalanan spiritual Anda.
      </p>
    </section>

    <!-- Schedule Section -->
    <section class="schedule-section">
      <h2 class="section-title">Jadwal Kelas Mendatang</h2>
      
      <div class="schedule-grid">
        <?php
        if ($rsJadwal->num_rows() > 0) {
          $cardCount = 0;
          foreach ($rsJadwal->result() as $rowJadwal) {
            $cardCount++;
            $tglmulai = date('d-m-Y', strtotime($rowJadwal->tglmulai));
            $tglselesai = date('d-m-Y', strtotime($rowJadwal->tglselesai));
            $jamMulai = date('H:i', strtotime($rowJadwal->tglmulai));
            $jamSelesai = date('H:i', strtotime($rowJadwal->tglselesai));

            $hari = date('l', strtotime($rowJadwal->tglmulai));
            $hariIndonesia = [
              'Sunday' => 'Minggu',
              'Monday' => 'Senin',
              'Tuesday' => 'Selasa',
              'Wednesday' => 'Rabu',
              'Thursday' => 'Kamis',
              'Friday' => 'Jumat',
              'Saturday' => 'Sabtu'
            ];
            $hariID = $hariIndonesia[$hari] ?? $hari;

            $tglEvent = ($tglmulai == $tglselesai) ? "$hariID, $tglmulai" : "$tglmulai s/d $tglselesai";
            $jamEvent = ($jamMulai == $jamSelesai) ? "$jamMulai WIB" : "$jamMulai-$jamSelesai WIB";

            $maxJemaat = $rowJadwal->jumlahjemaat ?: 30;
            $nJumlah = $this->db->query("
              SELECT COUNT(*) AS jlh FROM jadwaleventregistrasi
              WHERE idjadwalevent='" . $rowJadwal->idjadwalevent . "' AND statuskonfirmasi<>'Ditolak'
            ")->row()->jlh;

            $isFull = $nJumlah >= $maxJemaat;
            $jumlahPeserta = "$nJumlah/$maxJemaat";

            $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar($rowJadwal->idjadwalevent, $this->session->userdata('idjemaat'));

            $rsLokasi = $this->db->query("SELECT * FROM jadwaleventdetailtanggal WHERE idjadwalevent = '" . $rowJadwal->idjadwalevent . "' LIMIT 1");
            $namaLokasi = ($rsLokasi->num_rows() > 0) ? $rsLokasi->row()->lokasievent : 'Main Hall';

            // Alternate images
            $imageClass = ($cardCount % 2 == 1) ? 'person' : 'classroom';
            $imageUrl = base_url('myesc.id/assets/gambar/bgkelas.jpg');
            ?>
          <div class="schedule-card">
            <img src="<?php echo $imageUrl; ?>" alt="Foundation Class 1" class="card-image">
            <div class="card-content">
              <div class="card-header">
                <h3 class="card-title"><?php echo $rowJadwal->namaevent; ?>
                  <?php if ($sudahPernahDaftar): ?>
                    <span class="badge-status badge-success">Sudah Daftar</span>
                  <?php else: ?>
                    <span class="badge-status badge-secondary">Baru</span>
                  <?php endif; ?>
                </h3>
                <div class="capacity-badge">
                  <div class="capacity-label">Kapasitas</div>
                  <div class="capacity-value <?php echo $isFull ? 'full' : ''; ?>">Peserta: <?php echo $jumlahPeserta; ?></div>
                </div>
              </div>

              <div class="card-info">
                <div class="info-item">
                  <span class="info-icon">📅</span>
                  <span><?php echo $tglEvent; ?></span>
                </div>
                <div class="info-item">
                  <span class="info-icon">🕐</span>
                  <span><?php echo $jamEvent; ?></span>
                </div>
                <div class="info-item">
                  <span class="info-icon">📍</span>
                  <span><?php echo $namaLokasi; ?></span>
                </div>
              </div>

              <?php if ($sudahPernahDaftar): ?>
                <?php
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
                    ?>
                    <div class="alert-custom alert-<?php echo $alertClass; ?>">
                      <strong>Status: <?php echo $status; ?></strong><br>
                      <?php echo $pesan; ?>
                    </div>
                <?php
                  }
                }
                ?>
              <?php else: ?>
                <?php if (!$isFull): ?>
                  <button class="btn-daftar" data-idjadwalevent="<?php echo $rowJadwal->idjadwalevent; ?>" id="btnDaftar">
                    Daftar Sekarang
                  </button>
                <?php else: ?>
                  <button class="btn-daftar" disabled>
                    Kelas Penuh
                  </button>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        <?php
          }
        } else {
          echo '<div class="col-12 text-center" style="color: rgba(255,255,255,0.6); padding: 60px;">Jadwal kelas belum dibuka...</div>';
        }
        ?>
      </div>
    </section>

    <!-- Help Section -->
    <section class="help-section">
      <div class="help-card">
        <div class="help-content">
          <div class="help-icon">❓</div>
          <div class="help-text">
            <h3>Butuh bantuan pendaftaran?</h3>
            <p>Hubungi sekretariat gereja jika Anda mengalami kesulitan saat mendaftar kelas Equip.</p>
          </div>
        </div>
        <a href="#" class="btn-hubungi" onclick="window.location.href='<?php echo site_url('akun/ubahprofil'); ?>'; return false;">
          💬 Hubungi Kami
        </a>
      </div>
    </section>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
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
                    data: {
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