<?php $this->load->view('template/festavalive/header'); ?>

<body>
  <main>
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <?php
    // ================================================
    // LOGIKA QR CODE BERDASARKAN STATUS JEMAAT
    // ================================================
    // - Umum / Simpatisan  -> QR hanya idjemaat
    // - Jemaat (+ noaj)    -> QR = idjemaat-noaj (permanen)
    if ($rowProfil->statusjemaat == 'Jemaat' && !empty($rowProfil->noaj)) {
        $qrContent = $rowProfil->idjemaat . '-' . $rowProfil->noaj;
    } else {
        $qrContent = $rowProfil->idjemaat;
    }
    ?>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

      * { box-sizing: border-box; }

      html, body {
        margin: 0;
        padding: 0;
        background: #f5f5f5;
        font-family: 'Figtree', sans-serif;
        color: #111;
        line-height: 1.6;
      }

      /* Padding agar tidak tertimpa navbar */
      .page-content {
        padding-top: 80px !important;
        padding-bottom: 80px !important;
      }
      @media (min-width: 768px) {
        .page-content {
          padding-top: 120px !important;
          padding-bottom: 100px !important;
        }
      }
      @media (min-width: 1200px) {
        .page-content {
          padding-top: 160px !important;
          padding-bottom: 151px !important;
        }
      }

      /* ===== HERO SECTION ===== */
      .profile-hero {
        background: linear-gradient(135deg, #e04607 0%, #ff6b35 55%, #ffb347 100%);
        border-radius: 20px;
        padding: 32px 28px 60px;
        position: relative;
        overflow: hidden;
        margin-bottom: -40px;
      }

      .profile-hero::before {
        content: '';
        position: absolute;
        top: -50px; right: -50px;
        width: 180px; height: 180px;
        border-radius: 50%;
        background: rgba(255,255,255,0.07);
        pointer-events: none;
      }

      .profile-hero::after {
        content: '';
        position: absolute;
        bottom: -30px; left: -10px;
        width: 120px; height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        pointer-events: none;
      }

      .hero-brand {
        font-size: 12px;
        font-weight: 600;
        color: rgba(255,255,255,0.85);
        letter-spacing: 0.8px;
        text-transform: uppercase;
        margin-bottom: 20px;
      }

      .hero-body {
        display: flex;
        align-items: center;
        gap: 18px;
      }

      /* Avatar */
      .avatar-wrapper {
        flex-shrink: 0;
        width: 76px; height: 76px;
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.55);
        overflow: hidden;
        background: rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
      }

      .avatar-wrapper img {
        width: 100%; height: 100%;
        object-fit: cover;
      }

      .avatar-placeholder {
        width: 40px; height: 40px;
        opacity: 0.85;
        fill: white;
      }

      .hero-info { flex: 1; }

      .hero-name {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
        margin: 0 0 4px;
        line-height: 1.3;
      }

      .hero-noaj {
        font-size: 12px;
        color: rgba(255,255,255,0.7);
        margin: 0 0 10px;
      }

      .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.35);
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.3px;
      }

      .status-pill-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: #b8ffb8;
      }

      /* ===== MAIN CARD ===== */
      .profile-main-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        padding: 52px 24px 24px;
        position: relative;
        z-index: 2;
      }

      /* ===== INFO GRID ===== */
      .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 14px;
        margin-bottom: 20px;
      }

      .info-item {
        background: #fafafa;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 12px 14px;
      }

      .info-item.full-width {
        grid-column: 1 / -1;
      }

      .info-lbl {
        font-size: 10px;
        font-weight: 600;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        margin-bottom: 4px;
      }

      .info-val {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a1a;
      }

      /* ===== QR CODE CARD (di dalam hero) ===== */
      .qr-card {
        background: rgba(255,255,255,0.14);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 16px;
        padding: 18px;
        margin-top: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        z-index: 1;
      }

      .qr-card-title {
        font-size: 11px;
        font-weight: 700;
        color: rgba(255,255,255,0.85);
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 12px;
      }

      #qrcode-box {
        background: #fff;
        padding: 12px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        display: inline-flex;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.15s;
      }

      #qrcode-box:hover {
        transform: scale(1.03);
        box-shadow: 0 6px 20px rgba(0,0,0,0.22);
      }

      #qrcode-box:active {
        transform: scale(0.98);
      }

      #qrcode-box img,
      #qrcode-box canvas {
        display: block;
        border-radius: 4px;
      }

      .qr-card-caption {
        margin-top: 10px;
        font-size: 12px;
        color: rgba(255,255,255,0.75);
      }

      .qr-card-id {
        margin-top: 2px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.5px;
      }

      .qr-card-download-hint {
        margin-top: 8px;
        font-size: 10px;
        color: rgba(255,255,255,0.55);
        display: flex;
        align-items: center;
        gap: 4px;
      }

      .qr-card-download-hint svg {
        width: 11px;
        height: 11px;
        opacity: 0.8;
      }

      /* ===== ACTION BUTTONS ===== */
      .action-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }

      .action-link {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 14px;
        text-decoration: none !important;
        transition: transform 0.15s, box-shadow 0.15s;
        font-weight: 600;
        font-size: 14px;
      }

      .action-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
      }

      .action-link.primary {
        background: linear-gradient(135deg, #e04607, #ff7c42);
        color: #fff !important;
      }

      .action-link.secondary {
        background: #fffbea;
        color: #7a5c00 !important;
        border: 1px solid #ffe08a;
      }

      .action-icon-box {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
      }

      .action-link.primary .action-icon-box {
        background: rgba(255,255,255,0.2);
      }

      .action-link.secondary .action-icon-box {
        background: #fff3c4;
      }

      .action-icon-box svg {
        width: 16px; height: 16px;
      }

      .action-label { flex: 1; }

      .action-arrow {
        font-size: 18px;
        opacity: 0.5;
      }

      /* Responsive: di desktop foto dan data side-by-side */
      @media (min-width: 768px) {
        .profile-hero {
          padding: 36px 40px 40px;
          margin-bottom: 0;
          border-radius: 20px 0 0 20px;
        }
        .profile-main-card {
          padding: 32px;
          border-radius: 0 20px 20px 0;
        }
        .profile-layout {
          display: flex;
          align-items: stretch;
          border-radius: 20px;
          overflow: hidden;
          box-shadow: 0 6px 32px rgba(0,0,0,0.1);
        }
        .profile-hero { flex: 0 0 280px; margin-bottom: 0 !important; }
        .profile-main-card { flex: 1; box-shadow: none; }
        .hero-body { flex-direction: column; align-items: flex-start; }
        .avatar-wrapper { width: 90px; height: 90px; }
        .hero-name { font-size: 20px; }
      }
    </style>

    <section class="page-content">
      <div class="container">
        <div class="profile-layout">

          <!-- ===== HERO / FOTO ===== -->
          <div class="profile-hero">
            <div class="hero-brand">El Shaddai Church</div>
            <div class="hero-body">

              <!-- Foto Profil (logika sama seperti sebelumnya) -->
              <div class="avatar-wrapper">
                <?php if (!empty($rowProfil->foto)) { ?>
                  <img src="<?php echo base_url('myesc.id/admin/uploads/jemaat/' . $rowProfil->foto) ?>"
                       alt="Foto Profil">
                <?php } else { ?>
                  <svg class="avatar-placeholder" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                  </svg>
                <?php } ?>
              </div>

              <div class="hero-info">
                <p class="hero-name"><?php echo $rowProfil->namalengkap; ?></p>
                <p class="hero-noaj">No. Anggota Jemaat: <?php echo $rowProfil->noaj ? $rowProfil->noaj : '—'; ?></p>
                <div class="status-pill">
                  <span class="status-pill-dot"></span>
                  <?php echo $rowProfil->statusjemaat; ?>
                </div>
              </div>

            </div>

            <!-- ===== QR CODE (di bawah foto profil) ===== -->
            <div class="qr-card">
              <div class="qr-card-title">QR Code Anggota</div>
              <div id="qrcode-box" title="Klik untuk download"></div>
              <!-- <div class="qr-card-caption">
                <?php echo ($rowProfil->statusjemaat == 'Jemaat') ? 'ID Jemaat + No. AJ' : 'ID Jemaat'; ?>
              </div> -->
              <!-- <div class="qr-card-id"><?php echo $qrContent; ?></div> -->
              <div class="qr-card-download-hint">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                  <polyline points="7 10 12 15 17 10"/>
                  <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Ketuk QR untuk unduh
              </div>
            </div>

          </div>

          <!-- ===== DATA PROFIL + TOMBOL ===== -->
          <div class="profile-main-card">

            <div class="info-grid">
              <!-- No AJ -->
              <div class="info-item">
                <div class="info-lbl">No. AJ</div>
                <div class="info-val"><?php echo $rowProfil->noaj ? $rowProfil->noaj : '—'; ?></div>
              </div>

              <!-- Status Jemaat -->
              <div class="info-item">
                <div class="info-lbl">Status Jemaat</div>
                <div class="info-val"><?php echo $rowProfil->statusjemaat; ?></div>
              </div>

              <!-- Nama Lengkap -->
              <div class="info-item full-width">
                <div class="info-lbl">Nama Lengkap</div>
                <div class="info-val"><?php echo $rowProfil->namalengkap; ?></div>
              </div>

              <!-- Jenis Kelamin -->
              <div class="info-item">
                <div class="info-lbl">Jenis Kelamin</div>
                <div class="info-val"><?php echo $rowProfil->jeniskelamin; ?></div>
              </div>

              <!-- Kewarganegaraan -->
              <div class="info-item">
                <div class="info-lbl">Kewarganegaraan</div>
                <div class="info-val"><?php echo $rowProfil->kewarganegaraan; ?></div>
              </div>
            </div>

            <!-- Tombol aksi (href sama seperti sebelumnya) -->
            <div class="action-list">
              <a href="<?php echo site_url('akun/ubahprofil') ?>" class="action-link primary">
                <div class="action-icon-box">
                  <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                  </svg>
                </div>
                <span class="action-label">Ubah Profil</span>
                <span class="action-arrow">›</span>
              </a>

              <a href="<?php echo site_url('akun/gantipassword') ?>" class="action-link secondary">
                <div class="action-icon-box">
                  <svg viewBox="0 0 24 24" fill="none" stroke="#a07800" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                  </svg>
                </div>
                <span class="action-label">Ubah Password</span>
                <span class="action-arrow">›</span>
              </a>
            </div>

          </div><!-- /.profile-main-card -->
        </div><!-- /.profile-layout -->
      </div><!-- /.container -->
    </section>

    <!-- Library QR Code (client-side, ringan, tidak perlu install apapun di server) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
      // Data QR sudah ditentukan di PHP sesuai status jemaat (Umum/Simpatisan -> idjemaat saja,
      // Jemaat -> idjemaat-noaj). json_encode dipakai agar aman dari karakter khusus.
      var qrContent = <?php echo json_encode($qrContent); ?>;
      var namaJemaat = <?php echo json_encode($rowProfil->namalengkap); ?>;

      new QRCode(document.getElementById("qrcode-box"), {
        text: qrContent,
        width: 160,
        height: 160,
        colorDark: "#1a1a1a",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.M
      });

      // ================================================
      // FITUR DOWNLOAD QR CODE SAAT DIKLIK
      // Nama file diambil dari nama lengkap jemaat, dibersihkan
      // dari karakter yang tidak valid untuk nama file.
      // ================================================
      function sanitizeFileName(name) {
        return name
          .trim()
          .toLowerCase()
          .replace(/[^a-z0-9\s-]/g, '')   // buang karakter selain huruf/angka/spasi/strip
          .replace(/\s+/g, '_');          // spasi jadi underscore
      }

      document.getElementById('qrcode-box').addEventListener('click', function () {
        // qrcodejs merender <canvas> (utama) dan <img> (fallback). Kita ambil canvas dulu.
        var canvas = this.querySelector('canvas');
        var fileName = sanitizeFileName(namaJemaat || 'qrcode-jemaat') + '.png';

        if (canvas) {
          var link = document.createElement('a');
          link.download = fileName;
          link.href = canvas.toDataURL('image/png');
          link.click();
        } else {
          // fallback kalau browser hanya render <img> (jarang terjadi)
          var img = this.querySelector('img');
          if (img) {
            var link2 = document.createElement('a');
            link2.download = fileName;
            link2.href = img.src;
            link2.target = '_blank';
            link2.click();
          }
        }
      });

      $(document).on('change', '#foto', function(e) {
        $('#formUpload').submit();
      });
    </script>

    <?php $this->load->view('template/festavalive/footer'); ?>