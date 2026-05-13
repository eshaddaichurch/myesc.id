<?php
$this->load->view('template/festavalive/header');
?>

<body>
  <main>
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap');

      *, *::before, *::after { box-sizing: border-box; }

      :root {
        --orange:        #ff5008;
        --orange-soft:   rgba(255,80,8,0.08);
        --orange-border: rgba(255,80,8,0.20);
        --bg:            #ffffff;
        --bg-2:          #f7f5f2;
        --bg-3:          #f0ede8;
        --bg-dark:       #0d0d0d;
        --text:          #1a1a1a;
        --text-mid:rgb(0, 0, 0);
        --text-light:    #999999;
        --border:        rgba(0,0,0,0.08);
        --sans: 'Figtree', sans-serif;
        --radius: 16px;
        --radius-sm: 8px;
        --transition: 0.3s ease;
      }

      body {
        font-family: var(--sans);
        background: var(--bg);
        color: var(--text);
        margin: 0; padding: 0;
        overflow-x: hidden;
      }

      h1,h2,h3,h4,h5,h6,p,a,span,div,li,strong,em {
        font-family: var(--sans) !important;
      }

      a, a:hover { text-decoration: none; transition: color var(--transition); }

      /* ── SECTION LABEL ── */
      .esc-label {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 11px; font-weight: 600; letter-spacing: 3px;
        text-transform: uppercase; color: var(--orange);
        margin-bottom: 14px;
      }
      .esc-label::before {
        content: ''; display: block;
        width: 18px; height: 1px; background: var(--orange);
      }

      /* ══════════════════════════════════
         HERO / REDISCOVER SECTION
      ══════════════════════════════════ */
      .rediscover-section {
        position: relative;
        background-image: url('<?php echo base_url('myesc.id/assets/gambar/about.jpg'); ?>');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
        display: flex; align-items: center; justify-content: center;
        text-align: center;
        padding: 140px 24px 100px;
        color: white;
      }
      .rediscover-section::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(
          to bottom,
          rgba(0,0,0,0.50) 0%,
          rgba(0,0,0,0.65) 60%,
          rgba(0,0,0,0.80) 100%
        );
      }
      .rediscover-section .content {
        position: relative; z-index: 2;
        max-width: 700px; margin: 0 auto;
      }
      .rediscover-section .content .esc-eyebrow {
        display: inline-block;
        font-size: 11px; font-weight: 600;
        letter-spacing: 3px; text-transform: uppercase;
        color: var(--orange);
        border: 1px solid var(--orange-border);
        padding: 6px 18px; border-radius: 100px;
        margin-bottom: 28px;
      }
      .rediscover-section .subtitle {
        font-size: clamp(60px, 10vw, 110px) !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        letter-spacing: -2px;
        line-height: 1.0;
        margin-bottom: 20px;
        text-transform: none !important;
      }
      .rediscover-section > .content > p {
        font-size: 17px;
        color: rgba(255,255,255,0.70);
        line-height: 1.8;
        margin-bottom: 40px;
        max-width: 480px; margin-left: auto; margin-right: auto;
      }
      .btn-learn {
        display: inline-flex; align-items: center; gap: 8px;
        background: var(--orange); color: #ffffff !important;
        font-size: 14px; font-weight: 600;
        padding: 14px 30px; border-radius: 100px;
        transition: transform var(--transition), box-shadow var(--transition), opacity var(--transition);
        border: none;
      }
      .btn-learn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(255,80,8,0.35);
        opacity: 0.92;
        color: #ffffff !important;
      }
      .hero-scroll-hint {
        position: absolute; bottom: 36px; left: 50%;
        transform: translateX(-50%);
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        color: rgba(255,255,255,0.35);
        font-size: 10px; letter-spacing: 3px; text-transform: uppercase;
        animation: scrollBounce 2s infinite;
      }
      .hero-scroll-hint-line { width: 1px; height: 36px; background: rgba(255,255,255,0.25); }
      @keyframes scrollBounce {
        0%,100%{ transform: translateX(-50%) translateY(0); }
        50%    { transform: translateX(-50%) translateY(6px); }
      }
      @media (max-width: 768px) {
        .rediscover-section { background-attachment: scroll; padding: 120px 20px 80px; }
      }


      /* ══════════════════════════════════
         PROFIL GEREJA SECTION
      ══════════════════════════════════ */
      .profil-gereja-section {
        background: var(--bg) !important;
        padding: 100px 24px !important;
        display: flex; justify-content: center;
        border-top: none;
      }
      .profil-container {
        display: flex; flex-direction: row;
        gap: 80px; max-width: 1100px;
        align-items: flex-start; flex-wrap: wrap;
        width: 100%;
      }
      .profil-left { flex: 1; min-width: 260px; }

      .profil-left h2:first-of-type {
        font-size: clamp(72px, 10vw, 108px) !important;
        font-weight: 800 !important;
        color: var(--text) !important;
        line-height: 1 !important;
        margin-bottom: 8px !important;
        letter-spacing: -3px;
      }
      .profil-left h2:nth-of-type(2) {
        font-size: 12px !important;
        font-weight: 600 !important;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--text-light) !important;
        margin-bottom: 28px !important;
      }
      .profil-left-card {
        background: var(--orange-soft);
        border: 1px solid var(--orange-border);
        border-radius: var(--radius-sm);
        padding: 18px 20px;
        margin-top: 20px;
      }
      .profil-left-card p {
        font-size: 13px !important;
        color: #555 !important;
        line-height: 1.7 !important;
        margin: 0 !important;
      }
      .profil-left-card p span { color: var(--orange) !important; font-weight: 700 !important; }
      .profil-stat-row {
        display: flex; gap: 28px; flex-wrap: wrap;
        margin-top: 36px; padding-top: 32px;
        border-top: 1px solid var(--border);
      }
      .profil-stat strong {
        display: block;
        font-size: 36px !important; font-weight: 800 !important;
        color: var(--orange) !important;
        line-height: 1; margin-bottom: 4px;
        letter-spacing: -1px;
      }
      .profil-stat span { font-size: 12px !important; color: var(--text-light) !important; letter-spacing: 1px; font-weight: 500 !important; }

      .profil-right {
        flex: 2; min-width: 300px;
        max-width: 680px; padding: 0 !important;
      }
      .profil-divider {
        width: 40px; height: 3px;
        background: var(--orange);
        border-radius: 2px;
        margin-bottom: 32px;
      }
      .paragraf-profil {
        font-size: 15px !important;
        color: var(--text-mid) !important;
        line-height: 1.85 !important;
        margin-bottom: 16px !important;
        text-align: left !important;
      }
      .paragraf-profil:first-of-type {
        font-size: 17px !important;
        color: var(--text) !important;
        font-weight: 500 !important;
      }


      /* ══════════════════════════════════
         VISION / MISSION
      ══════════════════════════════════ */
      .vision-mission-section {
        background: var(--bg-dark) !important;
        border-top: none;
        padding: 100px 24px !important;
        color: #ffffff !important;
      }
      .container-vm {
        display: flex; flex-wrap: wrap;
        justify-content: center;
        gap: 2px;
        max-width: 1100px; margin: 0 auto;
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: var(--radius);
        overflow: hidden;
      }
      .vm-box {
        flex: 1 1 400px; max-width: 100%;
        background: #161616;
        padding: 52px 48px;
        transition: background var(--transition);
      }
      .vm-box:first-child { border-right: 1px solid rgba(255,255,255,0.07); }
      .vm-box:hover { background: #1c1c1c; }
      .vm-label {
        font-size: 11px !important; font-weight: 600 !important;
        letter-spacing: 3px !important; color: #888 !important;
        text-transform: uppercase !important; margin-bottom: 24px !important;
        display: flex; align-items: center; gap: 10px;
      }
      .vm-label::after {
        content: ''; height: 1px;
        background: rgba(255,255,255,0.10);
        flex: 1; max-width: 40px;
      }
      .vm-title {
        font-size: 20px !important; font-weight: 600 !important;
        line-height: 1.55 !important;
        color: #ffffff !important;
        transition: opacity 0.5s ease;
      }
      .vm-mission-items { margin-top: 4px; }
      .vm-mission-item { display: flex; gap: 14px; margin-bottom: 18px; }
      .vm-dot {
        width: 22px; height: 22px; flex-shrink: 0;
        background: var(--orange-soft);
        border: 1px solid var(--orange-border);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin-top: 2px;
      }
      .vm-dot::after {
        content: ''; width: 6px; height: 6px;
        background: var(--orange); border-radius: 50%;
      }
      .vm-mission-label {
        font-size: 13px !important; font-weight: 700 !important;
        color: var(--orange) !important; display: block; margin-bottom: 3px;
        letter-spacing: 0.5px;
      }
      .vm-mission-text {
        font-size: 14px !important; color: rgba(255,255,255,0.55) !important;
        line-height: 1.65 !important;
      }
      @media (max-width: 768px) {
        .vm-box:first-child { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.07); }
      }


      /* ══════════════════════════════════
         VALUES / NILAI
      ══════════════════════════════════ */
      .values-section, .section.fade-in.values-section {
        background: var(--bg-2) !important;
        border-top: none;
        padding: 100px 24px !important;
        max-width: 100% !important;
      }
      .section-title {
        font-size: clamp(32px, 5vw, 52px) !important;
        font-weight: 800 !important;
        color: var(--text) !important;
        height: auto !important;
        margin-bottom: 48px !important;
        display: block !important;
        text-align: left;
        letter-spacing: -1px;
        max-width: 1100px; margin-left: auto; margin-right: auto;
      }
      /* Override section-title inside dark leadership section */
      .leadership-section .section-title {
        color: var(--text) !important;
      }
      .value-accordion {
        max-width: 1100px; margin: 0 auto;
        display: flex; height: 340px; overflow: hidden;
        border-radius: var(--radius);
        border: 1px solid var(--border) !important;
        flex-direction: row;
        box-shadow: 0 2px 24px rgba(0,0,0,0.06);
      }
      .value-panel {
        flex: 1;
        display: flex; flex-direction: column;
        align-items: flex-start; justify-content: flex-end;
        background: var(--bg) !important;
        color: var(--text) !important;
        cursor: pointer;
        transition: flex 0.6s ease, background var(--transition);
        position: relative; overflow: hidden;
        border-right: 1px solid var(--border) !important;
        padding: 0;
      }
      .value-panel:last-child { border-right: none !important; }
      .value-panel::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0;
        height: 3px; background: var(--orange);
        transform: scaleX(0); transform-origin: left;
        transition: transform 0.3s;
      }
      .value-panel:hover::before,
      .value-panel.active::before { transform: scaleX(1); }
      .value-panel.active {
        flex: 3;
        background: #fff9f7 !important;
      }
      .panel-title {
        position: absolute !important;
        top: 20px !important; left: 20px !important;
        font-size: 48px !important; font-weight: 800 !important;
        color: rgba(255,80,8,0.12) !important;
        background: transparent !important;
        box-shadow: none !important;
        padding: 0 !important; border-radius: 0 !important;
        letter-spacing: -2px;
        transition: color 0.3s;
        pointer-events: none; z-index: 2;
      }
      .value-panel:hover .panel-title,
      .value-panel.active .panel-title { color: rgba(255,80,8,0.80) !important; }
      .panel-content {
        opacity: 0;
        transform: translateY(12px);
        transition: opacity 0.4s ease, transform 0.4s ease;
        padding: 24px !important;
        padding-top: 80px !important;
        position: relative; z-index: 1; width: 100%;
      }
      .value-panel.active .panel-content { opacity: 1; transform: translateY(0); }
      .panel-content h3 p,
      .panel-content h3 {
        font-size: 15px !important; font-weight: 700 !important;
        color: var(--text) !important; margin-bottom: 8px !important;
      }
      .panel-content p {
        font-size: 13px !important;
        color: var(--text-mid) !important;
        line-height: 1.65 !important;
      }
      @media (max-width: 768px) {
        .value-accordion {
          flex-direction: column !important; height: auto !important;
        }
        .value-panel {
          border-right: none !important;
          border-bottom: 1px solid var(--border) !important;
          min-height: 72px;
        }
        .value-panel.active { min-height: 200px; }
        .panel-content { padding-top: 72px !important; }
      }


      /* ══════════════════════════════════
         LEADERSHIP SECTION
      ══════════════════════════════════ */
      .leadership-section {
        background: var(--bg) !important;
        padding: 80px 24px 100px !important;
        border-top: 1px solid var(--border);
      }
      .leadership-section .section-title {
        color: var(--text) !important;
      }

      .profile-card {
        display: flex;
        background: var(--bg) !important;
        border-radius: var(--radius) !important;
        overflow: hidden;
        border: 1px solid var(--border) !important;
        box-shadow: 0 2px 16px rgba(0,0,0,0.06) !important;
        max-width: 1000px; width: 100%;
        transition: box-shadow var(--transition), transform var(--transition), border-color var(--transition);
        margin: auto;
      }
      .profile-card:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 12px 40px rgba(0,0,0,0.10) !important;
        border-color: var(--orange-border) !important;
      }

      /* ── DESKTOP: gambar fix 280px ── */
      .profile-image {
        flex: 0 0 280px;
        min-width: 280px;
        overflow: visible; /* Ubah dari hidden agar tidak memotong */
        background: var(--bg-3);
        position: relative;
      }
      .profile-image img {
         /* Ubah dari absolute ke static agar tinggi mengikuti konten */
        position: static !important;
        width: 140%;
        height: auto !important; /* Tinggi otomatis sesuai rasio asli */
        object-fit: contain; /* Tampilkan seluruh gambar, tidak dipotong */
        object-position: top center;
        display: block;
        transition: transform 0.5s ease;
        background: 
        linear-gradient(135deg, var(--bg-3) 0%, var(--orange-soft) 100%),
        url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 0L40 20L20 40L0 20z' fill='%23ff5008' fill-opacity='0.03'/%3E%3C/svg%3E");
        background-size: cover;
      }
      .profile-card:hover .profile-image img { transform: scale(1.02); }

      .profile-content {
        flex: 1;
        padding: 36px 125px !important;
        background: var(--bg) !important;
        display: flex; flex-direction: column; justify-content: center;
        border-left: 1px solid var(--border);
      }
      .profile-content .role-badge {
        display: inline-block;
        background: var(--orange-soft);
        color: var(--orange) !important;
        font-size: 11px !important; font-weight: 700 !important;
        letter-spacing: 1.5px; text-transform: uppercase;
        padding: 5px 12px; border-radius: 100px;
        border: 1px solid var(--orange-border);
        margin-bottom: 14px;
      }
      .profile-content h3 {
        font-size: 20px !important; font-weight: 700 !important;
        color: var(--text) !important;
        margin-bottom: 6px !important; line-height: 1.3;
      }
      .profile-content blockquote {
        font-size: 12px !important; font-style: normal !important;
        color: var(--text-light) !important;
        letter-spacing: 1px; text-transform: uppercase;
        border: none; margin: 0 0 16px !important; padding: 0 !important;
        font-weight: 600 !important;
      }
      .profile-content p {
        font-size: 14px !important;
        color: var(--text-mid) !important;
        line-height: 1.8 !important;
        margin: 0 !important;
      }

      /* ── MOBILE: layout column, foto FULL tanpa terpotong ── */
      @media (max-width: 768px) {
        .profile-card {
          flex-direction: column !important;
        }

        /* Hapus fixed flex & min-width supaya gambar bisa full */
        .profile-image {
          flex: none !important;
          min-width: unset !important;
          width: 100% !important;
          /* Tinggi auto mengikuti rasio foto asli */
          height: auto !important;
          position: static !important;  /* keluar dari absolute context */
        }

        /* Img kembali ke normal-flow agar tingginya mengikuti konten */
        .profile-image img {
          position: static !important;
          width: 100% !important;
          height: auto !important;         /* FULL, tidak terpotong */
          object-fit: cover !important;
          object-position: top center !important;
        }

        .profile-content {
          padding: 24px !important;
          border-left: none !important;
          border-top: 1px solid var(--border);
        }
        .profile-content h3 { font-size: 17px !important; }
        .profile-content p  { font-size: 14px !important; }
      }

      @media (max-width: 480px) {
        .profile-content { padding: 20px !important; }
        .profile-content h3 { font-size: 16px !important; }
      }


      /* ══════════════════════════════════
         FADE-IN ANIMATIONS
      ══════════════════════════════════ */
      .fade-in {
        opacity: 0; transform: translateY(28px);
        transition: opacity 0.7s ease, transform 0.7s ease;
      }
      .fade-in.visible { opacity: 1; transform: none; }

      .fade-in-section {
        opacity: 0; transform: translateY(36px);
        transition: opacity 0.8s ease, transform 0.8s ease;
      }
      .fade-in-section.visible { opacity: 1; transform: none; }


      /* ══════════════════════════════════
         BREADCRUMBS
      ══════════════════════════════════ */
      .breadcrumbs {
        padding: 140px 0 60px 0; min-height: 30vh; position: relative;
        background-size: cover; background-position: center; background-repeat: no-repeat;
      }
      .breadcrumbs::before {
        content: ""; background-color: rgba(0,0,0,0.65); position: absolute; inset: 0;
      }
      .breadcrumbs h2 { font-size: 56px; font-weight: 700; color: #fff; }
      .breadcrumbs ol {
        display: flex; flex-wrap: wrap; list-style: none;
        padding: 0 0 10px; margin: 0;
        font-size: 16px; font-weight: 600; color: var(--orange);
      }
      .breadcrumbs ol a { color: rgba(255,255,255,0.8); transition: 0.3s; }
      .breadcrumbs ol a:hover { text-decoration: underline; }
      .breadcrumbs ol li+li { padding-left: 10px; }
      .breadcrumbs ol li+li::before {
        display: inline-block; padding-right: 10px; color: #fff; content: "/";
      }
    </style>


    <!-- ═══════════ HERO ═══════════ -->
    <section class="rediscover-section">
      <div class="content">
        
        <h2 class="subtitle">YESUS</h2>
        <span class="esc-eyebrow">El Shaddai Church</span>
        <p>Pemilik dari ESC adalah Tuhan Yesus Kristus.</p>
        <a href="<?php echo site_url('jesus/index'); ?>" class="btn-learn">Lebih Mengenal Yesus →</a>
      </div>
      <div class="hero-scroll-hint">
        <div class="hero-scroll-hint-line"></div>
        scroll
      </div>
    </section>


    <!-- ═══════════ PROFIL GEREJA ═══════════ -->
    <section class="profil-gereja-section fade-in-section">
      <div class="profil-container">
        <div class="profil-left">
          <div class="esc-label"></div>
          <h2 style="font-size: 5.2rem; margin-bottom: 20px; color: #000000; font-weight: bold;">ESC</h2>
          <h2 style="font-size: 1.2rem; margin-bottom: 20px; color: #000000; font-weight: bold;">EL SHADDAI CHURCH</h2>
          <!-- <div class="profil-left-card">
            <p><span>El Shaddai</span> — nama Tuhan ketika memperkenalkan diri kepada Abraham (Kejadian 17). <em style="color:#555;">Shaddai</em> = Maha Kuasa. Allah yang sanggup membangun Gereja-Nya.</p>
          </div> -->
          <div class="profil-stat-row">
            <div class="profil-stat"><strong>1996</strong><span>Tahun Berdiri</span></div>
            <!-- <div class="profil-stat"><strong>5000+</strong><span>Jemaat</span></div>
            <div class="profil-stat"><strong>20</strong><span>Gereja Cabang</span></div> -->
          </div>
        </div>
        <div class="profil-right">
          <div class="profil-divider"></div>
          <p class="paragraf-profil">
            ESC diawali dengan datangnya Ps. Yehezkiel Wilan dan Keluarga ke kota Pontianak untuk merintis pelayanan baru dari Gereja lokal GBI Bethany Jakarta pada bulan Juni 1996.
          </p>
          <p class="paragraf-profil">
            Gereja yang masih muda dimulai dengan 3 keluarga di sebuah ruko yang disewa di jalan Nusa Indah 1, sekitar area supermarket Pontisari. Dengan jiwa-jiwa yang Tuhan kirimkan, ibadah raya minggu pindah ke hotel Kapuas Palace, lalu pindah ke gedung Pelni, kemudian pindah lagi ke restoran Gajah Mada,
          </p>
          <p class="paragraf-profil">
            hingga pada akhirnya dengan bertambahnya jiwa-jiwa yang Tuhan percayakan dan atas penyertaan Tuhan, pada tahun 2009 Tuhan izinkan ESC memiliki gedung sendiri yang bertempat di Jln. Prof. M. Yamin No.1a Kota Baru.
          </p>
          <p class="paragraf-profil">
            ESC merupakan singkatan dari EL SHADDAI CHURCH, dimana nama ini dipakai sebagai Jati Diri di dalam era digital atau dunia maya.
          </p>
          <p class="paragraf-profil">
            Pada awal Gereja ini berjalan menggunakan nama GBI Bethany, lalu berubah menjadi GBI Rayon 16 dan pada tahun 2009 menjadi GBI EL SHADDAI hingga sekarang. Nama EL SHADDAI dipilih sebagai nama Tuhan ketika memperkenalkan diri kepada Abraham di kitab Kejadian 17, SHADDAI artinya adalah Maha Kuasa, EL SHADDAI sama dengan Allah Maha Kuasa. Nama El Shaddai menginspirasikan bahwa Allah itu Maha Kuasa dan Dialah yang sanggup membangun Gereja-Nya seperti yang dikehendaki-Nya.
          </p>
        </div>
      </div>
    </section>


    <!-- ═══════════ VISI MISI ═══════════ -->
    <section class="vision-mission-section">
      <div class="container-vm fade-in-section">
        <div class="vm-box">
          <p class="vm-label">OUR VISION</p>
          <h2 class="vm-title" id="vision-text" style="color: #ff5008;">
            Membangun Generasi Yang Menghidupi Amanat Agung
          </h2>
        </div>
        <div class="vm-box">
          <p class="vm-label">OUR MISSION</p>
          <div class="vm-mission-items">
            <div class="vm-mission-item">
              <div class="vm-dot"></div>
              <div><span class="vm-mission-label">Planted</span><span class="vm-mission-text">Tertanam dalam Kristus dan dalam Disciples Community.</span></div>
            </div>
            <div class="vm-mission-item">
              <div class="vm-dot"></div>
              <div><span class="vm-mission-label">Grow</span><span class="vm-mission-text">Bertumbuh dalam pengenalan akan Kristus dan berproses dibentuk sebagai murid.</span></div>
            </div>
            <div class="vm-mission-item">
              <div class="vm-dot"></div>
              <div><span class="vm-mission-label">Fruitful</span><span class="vm-mission-text">Menjadi murid Kristus yang memuridkan dan berdampak bagi orang lain.</span></div>
            </div>
          </div>
          <h2 class="vm-title" id="mission-text" style="display:none;">
            Planted: Tertanam dalam Kristus dan dalam Disciples Community.<br>
            Grow: Bertumbuh dalam pengenalan akan Kristus dan berproses dibentuk sebagai murid.<br>
            Fruitful: Menjadi murid Kristus yang memuridkan dan berdampak bagi orang lain.
          </h2>
        </div>
      </div>
    </section>


    <!-- ═══════════ NILAI-NILAI ═══════════ -->
    <section class="section fade-in values-section">
      <div class="esc-label" style="max-width:1100px;margin:0 auto 12px;"></div>
      <h2 class="section-title">Our Values</h2>
      <div class="value-accordion" style="max-width:1100px;margin:0 auto;">

        <div class="value-panel active">
          <div class="panel-title" style="color: #ff5008;">L</div>
          <div class="panel-content">
            <h3><p>Love</p></h3>
            <p style="font-size: 20px;">"Jika kamu mengasihi Tuhan."</p>
          </div>
        </div>

        <div class="value-panel">
          <div class="panel-title" style="color: #ff5008;">O</div>
          <div class="panel-content">
            <h3><p>Obedience</p></h3>
            <p style="font-size: 20px;">"Ketaatan kepada Yesus Kristus Tuhan dan Firman-Nya adalah keharusan bagi Jemaat ESC."</p>
          </div>
        </div>

        <div class="value-panel">
          <div class="panel-title" style="color: #ff5008;">R</div>
          <div class="panel-content">
            <h3><p>Relevant</p></h3>
            <p style="font-size: 20px;">"Firman Allah tidak berubah selama-lamanya, namun cara Allah berkomunikasi dengan manusia relevan dengan zaman"</p>
          </div>
        </div>

        <div class="value-panel">
          <div class="panel-title" style="color: #ff5008;">D</div>
          <div class="panel-content">
            <h3><p>Discipleship</p></h3>
            <p style="font-size: 20px;">"Jemaat ESC harus melakukan amanat agung dan perintah utama melalui komunitas murid / Disciple Community."</p>
          </div>
        </div>

        <div class="value-panel">
          <div class="panel-title" style="color: #ff5008;">YESUS</div>
          <div class="panel-content">
            <h3><p>Jesus</p></h3>
            <p style="font-size: 20px;">"Yesus Kristus ialah pusat dari segalanya."</p>
          </div>
        </div>

      </div>
    </section>


    <!-- ═══════════ LEADERSHIP ═══════════ -->
    <section class="leadership-section">
      <div class="esc-label" style="max-width:1000px;margin:0 auto 12px;display:flex;"></div>
      <h2 class="section-title">Our Leadership</h2>

      <div style="display:flex;flex-direction:column;gap:20px;align-items:center;max-width:1000px;margin:0 auto;">

        <div class="profile-card">
          <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/gembala.jpg'); ?>" alt="Ps. Yehezkiel Wilan & Ps. Sandra Nappoe">
          </div>
          <div class="profile-content">
            <!-- <span class="role-badge">Senior Pastor</span> -->
            <h3>Ps. Yehezkiel Wilan &amp; Ps. Sandra Nappoe</h3>
            <blockquote>Gembala Senior ESC</blockquote>
            <p>Ps. Wilan dan Ps. Sandra dipercayakan oleh Tuhan untuk membuka pelayanan di Pontianak dan telah melayani sebagai Gembala Senior dari tahun 1996 hingga saat ini. Dimulai dari 3 keluarga sampai sekarang dipercayakan Tuhan 5000 lebih Jemaat dan membina 20 Gereja yang tersebar di Kalimantan Barat. Beliau dikaruniai 2 orang anak, bernama Chara Caroline dan David Ryan Wilando.</p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/GH_David & Istri.jpg'); ?>" alt="Ps. David Ryan Wilando">
          </div>
          <div class="profile-content">
            <!-- <span class="role-badge">Group Head Office</span> -->
            <h3>Ps. David Ryan Wilando &amp; Nindya Elysa</h3>
            <blockquote>Group Head Office</blockquote>
            <p></p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/GH_thian & istri.jpg'); ?>" alt="Ps. Jozethian Watta">
          </div>
          <div class="profile-content">
            <!-- <span class="role-badge">Group Head Creative</span> -->
            <h3>Ps. Jozethian Watta &amp; Dona Dorina</h3>
            <blockquote>Group Head Creative</blockquote>
            <p></p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/GH_Lampos & Istri.jpg'); ?>" alt="Ps. Lampos Rajagukguk">
          </div>
          <div class="profile-content">
            <!-- <span class="role-badge">Group Head Community</span> -->
            <h3>Ps. Lampos Rajagukguk &amp; Shangrila Djehadut</h3>
            <blockquote>Group Head Community</blockquote>
            <p></p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/GH_Johanes & Istri.jpg'); ?>" alt="Ps. Johannes Johari">
          </div>
          <div class="profile-content">
            <!-- <span class="role-badge">Group Head Care</span> -->
            <h3>Ps. Johannes Johari &amp; Erni Suryadi</h3>
            <blockquote>Group Head Care</blockquote>
            <p></p>
          </div>
        </div>

        <div class="profile-card">
          <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/Gh_eiva1.png'); ?>" alt="Eiva Rade Sitio">
          </div>
          <div class="profile-content">
            <!-- <span class="role-badge">Group Head Finance</span> -->
            <h3>Eiva Rade Sitio</h3>
            <blockquote>Group Head Finance</blockquote>
            <p></p>
          </div>
        </div>

      </div>
    </section>


    <!-- ═══════════ SCRIPTS (SEMUA ASLI) ═══════════ -->
    <script>
      function openModal(id) { document.getElementById(id).style.display = 'flex'; }
      function closeModal(id) { document.getElementById(id).style.display = 'none'; }

      let currentIndex = 0;
      function moveCarousel(direction) {
        const track = document.querySelector('.carousel-track');
        const totalItems = track.children.length;
        currentIndex = (currentIndex + direction + totalItems) % totalItems;
        track.style.transform = `translateX(-${currentIndex * 100}%)`;
      }

      document.addEventListener('DOMContentLoaded', function () {
        const elements = document.querySelectorAll('.fade-in');
        const observer = new IntersectionObserver((entries) => {
          entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        elements.forEach(el => observer.observe(el));
      });

      document.addEventListener('DOMContentLoaded', function () {
        const faders = document.querySelectorAll('.fade-in');
        function checkVisibility() {
          const triggerBottom = window.innerHeight * 0.85;
          faders.forEach(fader => {
            if (fader.getBoundingClientRect().top < triggerBottom) fader.classList.add('visible');
          });
        }
        window.addEventListener('scroll', checkVisibility);
        checkVisibility();
      });

      let slideIndex = 0;
      const slides = document.querySelectorAll('.slide');
      const dots   = document.querySelectorAll('.dot');
      function showSlide(index) {
        if (index >= slides.length) slideIndex = 0;
        else if (index < 0) slideIndex = slides.length - 1;
        else slideIndex = index;
        slides.forEach(s => s.classList.remove('active'));
        dots.forEach(d => d.classList.remove('active'));
        if (slides[slideIndex]) slides[slideIndex].classList.add('active');
        if (dots[slideIndex])   dots[slideIndex].classList.add('active');
      }
      function plusSlides(n) { showSlide(slideIndex + n); }
      function currentSlide(n) { showSlide(n); }
      document.addEventListener("DOMContentLoaded", () => showSlide(slideIndex));

      document.addEventListener("DOMContentLoaded", function () {
        const obs = new IntersectionObserver((entries, obs) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) { entry.target.classList.add("visible"); obs.unobserve(entry.target); }
          });
        }, { threshold: 0.3 });
        const target = document.querySelector('.fade-in-section');
        if (target) obs.observe(target);
      });

      document.addEventListener("DOMContentLoaded", function () {
        const vision  = document.getElementById("vision-text");
        const mission = document.getElementById("mission-text");
        const indo = {
          vision: "Membangun Generasi Yang Menghidupi Amanat Agung",
          mission: `Planted: Tertanam dalam Kristus dan dalam Disciples Community.<br>Grow: Bertumbuh dalam pengenalan akan Kristus dan berproses dibentuk sebagai murid.<br>Fruitful: Menjadi murid Kristus yang memuridkan dan berdampak bagi orang lain.`
        };
        const english = {
          vision: "Building Generations that live out the Great Commission",
          mission: `Planted: Rooted in Christ and in the Disciples Community.<br>Grow: Growing in the knowledge of Christ and being shaped as disciples.<br>Fruitful: Becoming disciples of Christ who make disciples and impact others.`
        };
        let isEnglish = false;
        setInterval(() => {
          vision.style.opacity = 0;
          if (mission) mission.style.opacity = 0;
          setTimeout(() => {
            vision.textContent  = isEnglish ? indo.vision   : english.vision;
            if (mission) mission.innerHTML = isEnglish ? indo.mission  : english.mission;
            vision.style.opacity = 1;
            if (mission) mission.style.opacity = 1;
            isEnglish = !isEnglish;
          }, 500);
        }, 5000);
      });

      document.addEventListener('DOMContentLoaded', function () {
        const fadeInSection = document.querySelectorAll('.fade-in-section');
        const appearOnScroll = new IntersectionObserver(function (entries, observer) {
          entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            entry.target.classList.add('visible');
            observer.unobserve(entry.target);
          });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
        fadeInSection.forEach(section => appearOnScroll.observe(section));
      });

      document.querySelectorAll('.value-panel').forEach(panel => {
        panel.addEventListener('mouseenter', () => {
          document.querySelectorAll('.value-panel').forEach(p => p.classList.remove('active'));
          panel.classList.add('active');
        });
      });
    </script>

  </main>
</body>

<?php $this->load->view('template/festavalive/footer'); ?>