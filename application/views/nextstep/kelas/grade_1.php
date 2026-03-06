<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header');
?>

<body>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #0f0f0f;
        color: #ffffff;
        line-height: 1.6;
      }

      .equip-hero {
        padding: 160px 0 60px 0;
        background-color: #0f0f0f;
        border-bottom: 1px solid #1e1e1e;
      }

      .equip-hero .container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 24px;
      }

      .equip-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 107, 0, 0.15);
        border: 1px solid rgba(255, 107, 0, 0.3);
        color: #ff6b00;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 100px;
        margin-bottom: 20px;
      }

      .equip-badge svg {
        width: 14px;
        height: 14px;
        fill: #ff6b00;
      }

      .equip-hero h1 {
        font-size: 56px;
        font-weight: 800;
        color: #ffffff;
        line-height: 1.1;
        margin-bottom: 20px;
        letter-spacing: -1px;
      }

      .equip-hero p.subtitle {
        font-size: 16px;
        color: #888;
        max-width: 600px;
        line-height: 1.7;
      }

      .equip-divider {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 24px;
      }

      .equip-divider hr {
        border: none;
        border-top: 1px solid #1e1e1e;
        margin: 40px 0 0 0;
      }

      .equip-schedule {
        max-width: 1100px;
        margin: 0 auto;
        padding: 60px 24px 80px;
      }

      .section-heading {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 36px;
      }

      .section-heading .icon-box {
        width: 36px;
        height: 36px;
        background: rgba(255, 107, 0, 0.15);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .section-heading .icon-box svg {
        width: 18px;
        height: 18px;
        fill: #ff6b00;
      }

      .section-heading h2 {
        font-size: 26px;
        font-weight: 700;
        color: #fff;
      }

      .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
      }

      .schedule-card {
        background: #181818;
        border: 1px solid #242424;
        border-radius: 16px;
        overflow: hidden;
        transition: transform 0.25s ease, border-color 0.25s ease;
      }

      .schedule-card:hover {
        transform: translateY(-4px);
        border-color: #ff6b00;
      }

      .schedule-card .card-thumb {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
      }

      .schedule-card .card-thumb-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #1e1e1e, #2a2a2a);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #333;
      }

      .schedule-card .card-body {
        padding: 24px;
        background: #000;
      }

      .card-top-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
      }

      .card-top-row h4 {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
      }

      .kapasitas-badge { text-align: right; }

      .kapasitas-badge .label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #555;
        margin-bottom: 2px;
      }

      .kapasitas-badge .value {
        font-size: 15px;
        font-weight: 700;
        color: #ff6b00;
      }

      .kapasitas-badge .value.full { color: #e53e3e; }

      .card-meta {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 24px;
      }

      .meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #bbb;
      }

      .meta-item .meta-icon {
        width: 28px;
        height: 28px;
        background: rgba(255, 107, 0, 0.12);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }

      .meta-item .meta-icon svg {
        width: 14px;
        height: 14px;
        fill: #ff6b00;
      }

      .btn-daftar {
        display: block;
        width: 100%;
        background: #ff6b00;
        color: #fff;
        text-align: center;
        padding: 14px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.15s ease;
      }

      .btn-daftar:hover {
        background: #e05a00;
        transform: scale(1.01);
        color: #fff;
        text-decoration: none;
      }

      .card-footer-status {
        padding: 16px 24px;
        border-top: 1px solid #242424;
      }

      .status-alert {
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 13px;
        line-height: 1.6;
      }

      .status-alert.warning {
        background: rgba(237, 137, 54, 0.1);
        border: 1px solid rgba(237, 137, 54, 0.3);
        color: #f6ad55;
      }

      .status-alert.success {
        background: rgba(72, 187, 120, 0.1);
        border: 1px solid rgba(72, 187, 120, 0.3);
        color: #68d391;
      }

      .status-alert.danger {
        background: rgba(245, 101, 101, 0.1);
        border: 1px solid rgba(245, 101, 101, 0.3);
        color: #fc8181;
      }

      .status-alert .status-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
      }

      .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
      }

      .warning .status-dot { background: #f6ad55; }
      .success .status-dot { background: #68d391; }
      .danger  .status-dot { background: #fc8181; }

      .help-banner {
        max-width: 1100px;
        margin: 0 auto 80px;
        padding: 0 24px;
      }

      .help-banner-inner {
        background: #181818;
        border: 1px solid #242424;
        border-radius: 16px;
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        flex-wrap: wrap;
      }

      .help-left {
        display: flex;
        align-items: center;
        gap: 20px;
      }

      .help-icon-circle {
        width: 52px;
        height: 52px;
        background: #ff6b00;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
      }

      .help-icon-circle svg {
        width: 24px;
        height: 24px;
        fill: #fff;
      }

      .help-text h5 {
        font-size: 17px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
      }

      .help-text p {
        font-size: 14px;
        color: #777;
        margin: 0;
      }

      .btn-hubungi {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 2px solid #ff6b00;
        color: #ff6b00;
        background: transparent;
        padding: 12px 22px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.2s ease;
      }

      .btn-hubungi:hover {
        background: rgba(255, 107, 0, 0.1);
        color: #ff6b00;
        text-decoration: none;
      }

      .btn-hubungi svg {
        width: 18px;
        height: 18px;
        fill: #ff6b00;
      }

      .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #555;
        font-size: 15px;
        grid-column: 1 / -1;
      }

      .badge-sudah {
        display: inline-block;
        background: rgba(72, 187, 120, 0.15);
        border: 1px solid rgba(72, 187, 120, 0.3);
        color: #68d391;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 3px 10px;
        border-radius: 100px;
        margin-left: 8px;
        vertical-align: middle;
      }

      @media (max-width: 768px) {
        .equip-hero h1 { font-size: 36px; }
        .equip-hero { padding: 120px 0 40px; }
        .help-banner-inner { flex-direction: column; align-items: flex-start; }
        .btn-hubungi { width: 100%; justify-content: center; }
      }
    </style>

    <!-- ─── HERO ─── -->
    <section class="equip-hero">
      <div class="container">
        <div class="equip-badge">
          <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17h2V9L12 3zM5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82z"/></svg>
          Equip Program
        </div>
        <h1>Grade 1</h1>
        <p class="subtitle">Grade 1 The Cross adalah kelas pengajaran dasar yang bertujuan untuk memberikan pemahaman tentang doktrin inti kekristenan yang berkaitan dengan iman dan karya keselamatan melalui Yesus Kristus. 
          Melalui kelas ini, peserta akan diajak untuk memahami dasar-dasar iman yang terdapat dalam Alkitab dan diperkuat dengan doktrin-doktrin utama.</p>
      </div>
      <div class="equip-divider"><hr></div>
    </section>

    <!-- ─── SCHEDULE SECTION ─── -->
    <section class="equip-schedule">
      <div class="section-heading">
        <div class="icon-box">
          <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 18H5V8h14v13zM7 10h5v5H7z"/></svg>
        </div>
        <h2>Jadwal Kelas Mendatang</h2>
      </div>

      <div class="cards-grid">
        <?php
        if ($rsJadwal->num_rows() > 0) {
          foreach ($rsJadwal->result() as $rowJadwal) {
            $tglmulai = date('d-m-Y', strtotime($rowJadwal->tglmulai));
            $tglselesai = date('d-m-Y', strtotime($rowJadwal->tglselesai));
            $jamMulai = date('H:i', strtotime($rowJadwal->tglmulai));
            $jamSelesai = date('H:i', strtotime($rowJadwal->tglselesai));

            $days_id = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
            $months_id = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
            $dayName = $days_id[date('l', strtotime($rowJadwal->tglmulai))];
            $monthName = $months_id[date('F', strtotime($rowJadwal->tglmulai))];
            $tglFormatted = $dayName . ', ' . date('d', strtotime($rowJadwal->tglmulai)) . ' ' . $monthName . ' ' . date('Y', strtotime($rowJadwal->tglmulai));

            $tglEvent = ($tglmulai == $tglselesai) ? $tglFormatted : "$tglmulai s/d $tglselesai";
            $jamEvent = ($jamMulai == $jamSelesai) ? "$jamMulai WIB" : "$jamMulai-$jamSelesai WIB";

            $maxJemaat = $rowJadwal->jumlahjemaat ?: 0;
            $nJumlah = $this->db->query("
              SELECT COUNT(*) AS jlh FROM jadwaleventregistrasi
              WHERE idjadwalevent='" . $rowJadwal->idjadwalevent . "' AND statuskonfirmasi<>'Ditolak'
            ")->row()->jlh;

            $isFull = ($maxJemaat > 0 && $nJumlah >= $maxJemaat);

            if ($maxJemaat == 0) {
              $pesertaDisplay = $nJumlah;
              $pesertaClass = '';
            } elseif ($isFull) {
              $pesertaDisplay = $nJumlah . '/' . $maxJemaat;
              $pesertaClass = 'full';
            } else {
              $pesertaDisplay = $nJumlah . '/' . $maxJemaat;
              $pesertaClass = '';
            }

            $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar($rowJadwal->idjadwalevent, $this->session->userdata('idjemaat'));

            $rsLokasi = $this->db->query("SELECT * FROM jadwaleventdetailtanggal WHERE idjadwalevent = '" . $rowJadwal->idjadwalevent . "' LIMIT 1");
            $namaLokasi = ($rsLokasi->num_rows() > 0) ? $rsLokasi->row()->lokasievent : '-';
            ?>
          <div class="schedule-card">
            <img
              src="<?php echo base_url('myesc.id/assets/gambar/bgkelas.jpg'); ?>"
              class="card-thumb"
              alt="Banner Kelas"
              onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="card-thumb-placeholder" style="display:none;">🎓</div>

            <div class="card-body">
              <div class="card-top-row">
                <h4>
                  <?php echo $rowJadwal->namaevent ?>
                  <?php if ($sudahPernahDaftar): ?>
                    <span class="badge-sudah">Sudah Daftar</span>
                  <?php endif; ?>
                </h4>
                <div class="kapasitas-badge">
                  <span class="label">Kapasitas</span>
                  <span class="value <?php echo $pesertaClass ?>">Peserta: <?php echo $pesertaDisplay ?></span>
                </div>
              </div>

              <div class="card-meta">
                <div class="meta-item">
                  <div class="meta-icon">
                    <svg viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 18H5V8h14v13z"/></svg>
                  </div>
                  <?php echo $tglEvent ?>
                </div>
                <div class="meta-item">
                  <div class="meta-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67V7z"/></svg>
                  </div>
                  <?php echo $jamEvent ?>
                </div>
                <div class="meta-item">
                  <div class="meta-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
                  </div>
                  <?php echo $namaLokasi ?>
                </div>
              </div>

              <?php if (!$sudahPernahDaftar): ?>
                <a href="#" class="btn-daftar" id="btnDaftar" data-idjadwalevent="<?php echo $rowJadwal->idjadwalevent ?>">
                  Daftar Sekarang
                </a>
              <?php endif; ?>
            </div>

            <?php if ($sudahPernahDaftar): ?>
              <?php
              $rsDaftar = $this->db->query("SELECT * FROM v_jadwaleventregistrasi WHERE idjadwalevent='{$rowJadwal->idjadwalevent}' AND idjemaat='{$this->session->userdata('idjemaat')}'");
              if ($rsDaftar->num_rows() > 0):
                foreach ($rsDaftar->result() as $rowDaftar):
                  $status = $rowDaftar->statuskonfirmasi;
                  $tglDaftar = date('d-m-Y H:i', strtotime($rowDaftar->tglregistrasi));
                  $alertClass = $status == 'Menunggu' ? 'warning' : ($status == 'Disetujui' ? 'success' : 'danger');
                  $pesan = $status == 'Menunggu'
                    ? 'Pengajuan pendaftaran kelas anda masih dalam proses <strong>Menunggu</strong>.'
                    : ($status == 'Disetujui'
                      ? 'Pengajuan sudah <strong>Disetujui</strong>. Silahkan datang pada jadwal yang ditentukan.'
                      : 'Pengajuan <strong>Ditolak</strong>.<br>' . $rowDaftar->keterangankonfirmasi);
                  ?>
                <div class="card-footer-status">
                  <div class="status-alert <?php echo $alertClass ?>">
                    <div class="status-row">
                      <div class="status-dot"></div>
                      <strong>Status: <?php echo $status ?></strong>
                    </div>
                    <div><strong>Nama:</strong> <?php echo $rowDaftar->namalengkap ?></div>
                    <div><strong>Tgl Daftar:</strong> <?php echo $tglDaftar ?></div>
                    <div style="margin-top:8px;"><?php echo $pesan ?></div>
                  </div>
                </div>
              <?php endforeach;
              endif; ?>
            <?php endif; ?>
          </div>
        <?php
          }
        } else {
          echo '<div class="empty-state">Jadwal kelas ' . $rowKelas->namakelas . ' belum dibuka.</div>';
        }
        ?>
      </div>
    </section>

    <!-- ─── HELP BANNER ─── -->
    <div class="help-banner">
      <div class="help-banner-inner">
        <div class="help-left">
          <div class="help-icon-circle">
            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/></svg>
          </div>
          <div class="help-text">
            <h5>Butuh bantuan pendaftaran?</h5>
            <p>Hubungi sekretariat gereja jika Anda mengalami kesulitan saat mendaftar kelas Equip.</p>
          </div>
        </div>
        <a href="https://wa.me/6285183023883" target="_blank" class="btn-hubungi">
          <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/></svg>
          Hubungi Kami
        </a>
      </div>
    </div>

    <?php $this->load->view('nextstep/kelas/js'); ?>

    <?php $this->load->view('template/festavalive/footer'); ?>