<?php $this->load->view('template/festavalive/header'); ?>

<body>
<main>
  <?php $this->load->view('template/festavalive/topmenu'); ?>

  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Figtree', sans-serif;
      background: #111;
      color: #f0f0f0;
      line-height: 1.7;
    }

    /* ===== HERO ===== */
    .js-hero {
      position: relative;
      min-height: 70vh;
      background: url('<?php echo base_url('myesc.id/assets/gambar/jesus2.jpg'); ?>') center/cover no-repeat;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      padding-bottom: 60px;
    }
    .js-hero::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(17,17,17,1) 0%, rgba(17,17,17,0.4) 60%, transparent 100%);
    }
    .js-hero__inner {
      position: relative;
      z-index: 1;
      text-align: center;
      padding: 0 24px;
    }
    .js-hero__eyebrow {
      font-size: 12px;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 16px;
    }
    .js-hero__title {
      font-size: clamp(3rem, 10vw, 7rem);
      font-weight: 700;
      color: #fff;
      line-height: 1;
      letter-spacing: -1px;
    }
    .js-hero__sub {
      font-size: 16px;
      color: #aaa;
      margin-top: 16px;
      max-width: 480px;
      margin-left: auto;
      margin-right: auto;
    }

    /* ===== SIAPA YESUS ===== */
    .js-who {
      background: #111;
      padding: 80px 24px;
      text-align: center;
    }
    .js-who__inner {
      max-width: 700px;
      margin: 0 auto;
    }
    .js-who__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 14px;
    }
    .js-who__title {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 700;
      color: #fff;
      margin-bottom: 40px;
    }
    .js-poem {
      display: flex;
      flex-direction: column;
      gap: 20px;
      text-align: left;
    }
    .js-poem__line {
      padding: 20px 24px;
      border-left: 3px solid #ef5008;
      background: rgba(255,255,255,0.03);
      border-radius: 0 8px 8px 0;
    }
    .js-poem__line p {
      font-size: 16px;
      color: #ccc;
      line-height: 1.9;
      font-style: italic;
      margin: 0;
    }
    .js-poem__line p em {
      color: #ebd7a9;
      font-style: normal;
      font-weight: 600;
    }

    /* ===== TENTANG YESUS ===== */
    .js-about {
      background: #f5f0e8;
      padding: 80px 24px;
    }
    .js-about__inner {
      max-width: 800px;
      margin: 0 auto;
    }
    .js-about__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 14px;
      text-align: center;
    }
    .js-about__title {
      font-size: clamp(1.8rem, 4vw, 2.6rem);
      font-weight: 700;
      color: #111;
      margin-bottom: 40px;
      text-align: center;
    }
    .js-about__body p {
      font-size: 16px;
      color: #444;
      line-height: 1.9;
      margin-bottom: 20px;
    }
    .js-about__body p:last-child { margin-bottom: 0; }

    /* ===== AYAT ===== */
    .js-verse {
      background: #1a1a1a;
      padding: 80px 24px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .js-verse::before {
      content: '\201C';
      position: absolute;
      top: -20px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 200px;
      color: rgba(239,80,8,0.06);
      font-family: Georgia, serif;
      line-height: 1;
      pointer-events: none;
    }
    .js-verse__inner {
      max-width: 680px;
      margin: 0 auto;
      position: relative;
    }
    .js-verse__divider {
      width: 40px;
      height: 2px;
      background: #ef5008;
      margin: 20px auto;
    }
    .js-verse__text {
      font-size: clamp(1.1rem, 2.5vw, 1.4rem);
      color: #ebd7a9;
      line-height: 1.9;
      font-style: italic;
      margin-bottom: 16px;
    }
    .js-verse__ref {
      font-size: 13px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
    }

    /* ===== CTA ===== */
    .js-cta {
      background: #111;
      padding: 80px 24px;
      text-align: center;
    }
    .js-cta__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 14px;
    }
    .js-cta__title {
      font-size: clamp(1.8rem, 4vw, 2.6rem);
      font-weight: 700;
      color: #fff;
      margin-bottom: 12px;
    }
    .js-cta__sub {
      font-size: 15px;
      color: #aaa;
      margin-bottom: 40px;
      max-width: 480px;
      margin-left: auto;
      margin-right: auto;
    }
    .js-cta__btn {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 16px 40px;
      background: #ef5008;
      color: #fff;
      font-size: 16px;
      font-weight: 700;
      border-radius: 99px;
      text-decoration: none;
      transition: all .25s ease;
    }
    .js-cta__btn:hover {
      background: #c73e00;
      color: #fff;
      transform: scale(1.03);
      text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .js-hero { min-height: 55vh; padding-bottom: 40px; }
      .js-who, .js-about, .js-verse, .js-cta { padding: 60px 20px; }
      .js-poem__line { padding: 16px 18px; }
    }
  </style>

  <!-- HERO -->
  <section class="js-hero">
    <div class="js-hero__inner">
      <div class="js-hero__eyebrow"></div>
      <h1 class="js-hero__title">YESUS</h1>
      <p class="js-hero__sub">Mengenal pribadi Yesus Kristus<br>Jalan Kebenaran, dan Hidup</p>
    </div>
  </section>

  <!-- SIAPA YESUS -->
  <section class="js-who">
    <div class="js-who__inner">
      <div class="js-who__eyebrow"></div>
      <h2 class="js-who__title">Siapa Itu Yesus?</h2>
      <div class="js-poem">
        <div class="js-poem__line">
          <p>Kebenaran yang kekal. Penggenapan janji. Pribadi yang lahir untuk memberikan <em>keselamatan</em>.</p>
        </div>
        <div class="js-poem__line">
          <p>Terang yang melenyapkan segala kegelapan. Penebus yang ajaib. Pribadi yang mati untuk menghapuskan semua dosa.</p>
        </div>
        <div class="js-poem__line">
          <p>Dia lah yang berjalan di atas air. Dia lah yang berkata kepada badai, <em>"Diam! Tenanglah!"</em> Dia lah yang berjalan di dalam api bersamaku.</p>
        </div>
        <div class="js-poem__line">
          <p>Dia mengaum seperti singa, tapi berdarah seperti anak domba. Dia membawa <em>kesembuhan</em> di dalam tangan-Nya.</p>
        </div>
        <div class="js-poem__line">
          <p><em>Mesias. Juru Selamat ku. Nama yang penuh kuasa.</em> Batu karang yang teguh. Kota benteng dan perisai ku. Penyelamat yang bangkit dan hidup.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- TENTANG YESUS -->
  <section class="js-about">
    <div class="js-about__inner">
      <div class="js-about__eyebrow">Mengenal Lebih Dalam</div>
      <h2 class="js-about__title">Tentang Yesus</h2>
      <div class="js-about__body">
        <p>Yesus Kristus adalah pribadi Allah yang mengambil rupa manusia, Mesias yang dijanjikan, dan Juruselamat dunia. Ia lahir sekitar 2.000 tahun yang lalu di kota Betlehem dari seorang perawan bernama Maria melalui karya Roh Kudus (Matius 1:18–25).</p>
        <p>Yesus dibesarkan di Nazaret sebagai anak seorang tukang kayu bernama Yusuf. Ia mulai pelayanan publik-Nya pada usia sekitar 30 tahun setelah dibaptis oleh Yohanes Pembaptis. Pada saat baptisan, suara dari surga menyatakan, "Inilah Anak-Ku yang Kukasihi, kepada-Nyalah Aku berkenan" (Matius 3:17).</p>
        <p>Selama tiga tahun pelayanan-Nya, Yesus mengajar tentang kasih, pertobatan, dan Kerajaan Allah. Ia menyembuhkan orang sakit, mengusir roh jahat, membangkitkan orang mati, dan menjangkau semua kalangan dengan penuh belas kasih.</p>
        <p>Yesus berkata bahwa Ia adalah "Jalan, Kebenaran, dan Hidup" (Yohanes 14:6). Ia disalibkan di Golgota sebagai korban yang sempurna untuk menebus dosa manusia agar kita dapat diperdamaikan dengan Allah.</p>
        <p>Pada hari ketiga, Yesus bangkit dari antara orang mati. Kebangkitan-Nya adalah bukti bahwa Ia sungguh Allah dan bahwa kuasa dosa serta maut telah dikalahkan. Ia kini duduk di sebelah kanan Allah Bapa dan akan datang kembali kelak.</p>
      </div>
    </div>
  </section>

  <!-- AYAT YOHANES 3:16 -->
  <section class="js-verse">
    <div class="js-verse__inner">
      <div class="js-verse__divider"></div>
      <p class="js-verse__text">
        Karena begitu besar kasih Allah akan dunia ini, sehingga Ia telah mengaruniakan Anak-Nya yang tunggal, supaya setiap orang yang percaya kepada-Nya tidak binasa, melainkan beroleh hidup yang kekal.
      </p>
      <div class="js-verse__ref">Yohanes 3:16</div>
      <div class="js-verse__divider"></div>
    </div>
  </section>

  <!-- CTA -->
  <section class="js-cta">
    <div class="js-cta__eyebrow">Langkah Awal</div>
    <h2 class="js-cta__title"></h2>
    <p class="js-cta__sub">Mulailah perjalanan iman Anda</p>
    <a class="js-cta__btn" href="<?php echo site_url('https://myesc.id/nextstep/kelas/foundation_class_1'); ?>">
      Daftar Fc 1 →
    </a>
  </section>

<?php $this->load->view('template/festavalive/footer'); ?>