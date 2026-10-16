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

    // URL foto profil (kosong jika belum ada foto)
    $fotoUrl = !empty($rowProfil->foto)
        ? base_url('myesc.id/admin/uploads/jemaat/' . $rowProfil->foto)
        : '';
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
                <div class="info-lbl">No. Anggota Jemaat</div>
                <div class="info-val"><?php echo $rowProfil->noaj ? $rowProfil->noaj : '—'; ?></div>
              </div>

              <!-- Status Jemaat -->
              <div class="info-item">
                <div class="info-lbl">Status Keanggotaan</div>
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
      // ================================================
      // DATA DARI PHP (json_encode supaya aman dari karakter khusus)
      // ================================================
      var qrContent    = <?php echo json_encode($qrContent); ?>;
      var namaJemaat   = <?php echo json_encode($rowProfil->namalengkap); ?>;
      var noajJemaat   = <?php echo json_encode($rowProfil->noaj ? $rowProfil->noaj : '—'); ?>;
      var statusJemaat = <?php echo json_encode($rowProfil->statusjemaat); ?>;
      var fotoUrl      = <?php echo json_encode($fotoUrl); ?>;

      // QR untuk TAMPILAN di halaman (ukuran kecil, tidak berubah)
      new QRCode(document.getElementById("qrcode-box"), {
        text: qrContent,
        width: 160,
        height: 160,
        colorDark: "#1a1a1a",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.M
      });

      // ================================================
      // FITUR DOWNLOAD: KARTU ANGGOTA (foto + nama + QR)
      // Kartu digambar di <canvas> 1080 x 1450 px.
      // QR hitam pekat di atas kotak putih dengan margin lebar
      // supaya tetap mudah di-scan.
      // ================================================
      function sanitizeFileName(name) {
        return name
          .trim()
          .toLowerCase()
          .replace(/[^a-z0-9\s-]/g, '')   // buang karakter selain huruf/angka/spasi/strip
          .replace(/\s+/g, '_');          // spasi jadi underscore
      }

      // Helper: gambar persegi dengan sudut membulat
      function roundRectPath(ctx, x, y, w, h, r) {
        ctx.beginPath();
        ctx.moveTo(x + r, y);
        ctx.lineTo(x + w - r, y);
        ctx.quadraticCurveTo(x + w, y, x + w, y + r);
        ctx.lineTo(x + w, y + h - r);
        ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h);
        ctx.lineTo(x + r, y + h);
        ctx.quadraticCurveTo(x, y + h, x, y + h - r);
        ctx.lineTo(x, y + r);
        ctx.quadraticCurveTo(x, y, x + r, y);
        ctx.closePath();
      }

      // Helper: muat gambar, hasilnya null kalau gagal
      function loadImage(src) {
        return new Promise(function (resolve) {
          if (!src) { resolve(null); return; }
          var img = new Image();
          img.crossOrigin = 'anonymous';
          img.onload  = function () { resolve(img); };
          img.onerror = function () { resolve(null); };
          img.src = src;
        });
      }

      // Helper: buat canvas QR hitam-putih berukuran persis `size` px
      function makeQRCanvas(text, size) {
        var tmp = document.createElement('div');
        tmp.style.position = 'absolute';
        tmp.style.left = '-9999px';
        tmp.style.top = '-9999px';
        document.body.appendChild(tmp);

        new QRCode(tmp, {
          text: text,
          width: size,
          height: size,
          colorDark: "#000000",
          colorLight: "#ffffff",
          correctLevel: QRCode.CorrectLevel.M
        });

        var c = tmp.querySelector('canvas');
        // salin ke canvas baru supaya aman setelah elemen sementara dihapus
        var copy = document.createElement('canvas');
        copy.width = size;
        copy.height = size;
        copy.getContext('2d').drawImage(c, 0, 0);

        document.body.removeChild(tmp);
        return copy;
      }

      async function buildMemberCard() {
        var W = 1080, H = 1450;

        // Pastikan font Figtree sudah siap dipakai canvas
        try {
          await Promise.all([
            document.fonts.load('700 40px Figtree'),
            document.fonts.load('600 30px Figtree')
          ]);
        } catch (e) { /* kalau gagal, pakai font cadangan */ }

        var FONT = 'Figtree, Arial, sans-serif';
        var photo = await loadImage(fotoUrl);

        var cv = document.createElement('canvas');
        cv.width = W;
        cv.height = H;
        var ctx = cv.getContext('2d');

        // ---------- Latar gradien oranye ----------
        var g = ctx.createLinearGradient(0, 0, W, H);
        g.addColorStop(0, '#e04607');
        g.addColorStop(0.55, '#ff6b35');
        g.addColorStop(1, '#ffb347');
        ctx.fillStyle = g;
        ctx.fillRect(0, 0, W, H);

        // Lingkaran dekorasi
        ctx.fillStyle = 'rgba(255,255,255,0.07)';
        ctx.beginPath(); ctx.arc(W - 40, 20, 260, 0, Math.PI * 2); ctx.fill();
        ctx.fillStyle = 'rgba(255,255,255,0.05)';
        ctx.beginPath(); ctx.arc(60, H - 40, 200, 0, Math.PI * 2); ctx.fill();

        // ---------- Brand ----------
        ctx.textBaseline = 'alphabetic';
        ctx.textAlign = 'left';
        ctx.fillStyle = 'rgba(255,255,255,0.9)';
        ctx.font = '700 30px ' + FONT;
        ctx.fillText('EL SHADDAI CHURCH', 80, 120);

        // ---------- Foto profil (lingkaran) ----------
        var ax = 80 + 100, ay = 300, ar = 100;   // pusat x, pusat y, radius
        ctx.save();
        ctx.beginPath();
        ctx.arc(ax, ay, ar, 0, Math.PI * 2);
        ctx.closePath();
        ctx.clip();
        if (photo) {
          // object-fit: cover
          var s = Math.max((ar * 2) / photo.width, (ar * 2) / photo.height);
          var dw = photo.width * s, dh = photo.height * s;
          ctx.drawImage(photo, ax - dw / 2, ay - dh / 2, dw, dh);
        } else {
          ctx.fillStyle = 'rgba(255,255,255,0.18)';
          ctx.fillRect(ax - ar, ay - ar, ar * 2, ar * 2);
          // ikon orang sederhana
          ctx.fillStyle = 'rgba(255,255,255,0.9)';
          ctx.beginPath(); ctx.arc(ax, ay - 20, 32, 0, Math.PI * 2); ctx.fill();
          ctx.beginPath(); ctx.ellipse(ax, ay + 55, 55, 38, 0, Math.PI, 0); ctx.fill();
        }
        ctx.restore();
        // Border foto
        ctx.beginPath();
        ctx.arc(ax, ay, ar, 0, Math.PI * 2);
        ctx.lineWidth = 7;
        ctx.strokeStyle = 'rgba(255,255,255,0.55)';
        ctx.stroke();

        // ---------- Nama, No. AJ, status ----------
        var tx = ax + ar + 45;            // posisi teks (x)
        var maxTextW = W - 80 - tx;       // lebar maksimal teks

        // Nama: kecilkan font otomatis kalau terlalu panjang
        var nameSize = 56;
        ctx.fillStyle = '#ffffff';
        ctx.font = '700 ' + nameSize + 'px ' + FONT;
        while (ctx.measureText(namaJemaat).width > maxTextW && nameSize > 30) {
          nameSize -= 2;
          ctx.font = '700 ' + nameSize + 'px ' + FONT;
        }
        ctx.fillText(namaJemaat, tx, 270);

        ctx.fillStyle = 'rgba(255,255,255,0.8)';
        ctx.font = '500 30px ' + FONT;
        ctx.fillText('No. Anggota Jemaat: ' + noajJemaat, tx, 325);

        // Pill status
        ctx.font = '700 28px ' + FONT;
        var pillText = String(statusJemaat);
        var pillTextW = ctx.measureText(pillText).width;
        var pillX = tx, pillY = 355, pillH = 60;
        var pillW = 28 + 22 + 14 + pillTextW + 28;
        roundRectPath(ctx, pillX, pillY, pillW, pillH, pillH / 2);
        ctx.fillStyle = 'rgba(255,255,255,0.2)';
        ctx.fill();
        ctx.lineWidth = 2;
        ctx.strokeStyle = 'rgba(255,255,255,0.4)';
        ctx.stroke();
        ctx.fillStyle = '#b8ffb8';
        ctx.beginPath(); ctx.arc(pillX + 28 + 9, pillY + pillH / 2, 9, 0, Math.PI * 2); ctx.fill();
        ctx.fillStyle = '#ffffff';
        ctx.fillText(pillText, pillX + 28 + 22 + 14, pillY + pillH / 2 + 10);

        // ---------- Kartu QR (transparan) ----------
        var cardX = 80, cardY = 470, cardW = W - 160, cardH = 900;
        roundRectPath(ctx, cardX, cardY, cardW, cardH, 40);
        ctx.fillStyle = 'rgba(255,255,255,0.14)';
        ctx.fill();
        ctx.lineWidth = 2;
        ctx.strokeStyle = 'rgba(255,255,255,0.3)';
        ctx.stroke();

        ctx.fillStyle = 'rgba(255,255,255,0.9)';
        ctx.font = '700 28px ' + FONT;
        ctx.textAlign = 'center';
        ctx.fillText('QR CODE ANGGOTA', W / 2, cardY + 75);

        // ---------- Kotak putih + QR ----------
        var qrSize = 600;                 // ukuran QR (px)
        var pad = 60;                     // margin putih di sekeliling QR (quiet zone)
        var boxSize = qrSize + pad * 2;   // 720 px
        var boxX = (W - boxSize) / 2;
        var boxY = cardY + 120;

        ctx.save();
        ctx.shadowColor = 'rgba(0,0,0,0.2)';
        ctx.shadowBlur = 30;
        ctx.shadowOffsetY = 10;
        roundRectPath(ctx, boxX, boxY, boxSize, boxSize, 36);
        ctx.fillStyle = '#ffffff';
        ctx.fill();
        ctx.restore();

        var qrCanvas = makeQRCanvas(qrContent, qrSize);
        ctx.imageSmoothingEnabled = false;  // jaga kotak QR tetap tajam
        ctx.drawImage(qrCanvas, boxX + pad, boxY + pad, qrSize, qrSize);

        return cv;
      }

      document.getElementById('qrcode-box').addEventListener('click', async function () {
        var fileName = sanitizeFileName(namaJemaat || 'qrcode-jemaat') + '.png';
        var cv = await buildMemberCard();

        var link = document.createElement('a');
        link.download = fileName;
        link.href = cv.toDataURL('image/png');
        document.body.appendChild(link); // supaya jalan juga di Firefox
        link.click();
        document.body.removeChild(link);
      });

      $(document).on('change', '#foto', function(e) {
        $('#formUpload').submit();
      });
    </script>

    <?php $this->load->view('template/festavalive/footer'); ?>