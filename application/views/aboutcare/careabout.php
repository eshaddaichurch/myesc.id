<?php $this->load->view('template/festavalive/header'); ?>

<body>
<main>
  <?php $this->load->view('template/festavalive/topmenu'); ?>

  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Figtree', sans-serif;
      background: #f5f0e8;
      color: #1a1a1a;
      line-height: 1.7;
    }

    /* ===== HERO SECTION ===== */
    .care-hero {
      background: #111;
      color: #fff;
      padding: 80px 24px 64px;
      position: relative;
      overflow: hidden;
    }
    .care-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at 35% 50%, rgba(239,80,8,0.15) 0%, transparent 70%);
      pointer-events: none;
    }
    .care-hero__inner {
      max-width: 1100px;
      margin: 0 auto;
      position: relative;
    }
    .care-hero__top {
      text-align: center;
      margin-bottom: 56px;
    }
    .care-hero__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 14px;
    }
    .care-hero__title {
      font-size: clamp(2rem, 5vw, 3.5rem);
      font-weight: 700;
      color: #fff;
      line-height: 6.15;
      margin-bottom: -90px;
    }
    .care-hero__divider {
      width: 48px;
      height: 3px;
      background: #ef5008;
      border-radius: 2px;
      margin: 20px auto 0;
    }
    .care-hero__content {
      display: flex;
      flex-wrap: wrap;
      gap: 48px;
      align-items: flex-start;
      justify-content: center;
    }
    .care-hero__text {
      flex: 1 1 340px;
      max-width: 540px;
    }
    .care-hero__text p {
      font-size: 15px;
      color: #bbb;
      line-height: 1.9;
      margin-bottom: 14px;
    }
    .care-quote {
      border-left: 3px solid #ef5008;
      padding-left: 16px;
      margin-top: 24px;
    }
    .care-quote p {
      color: #999;
      font-style: italic;
      font-size: 14px;
    }
    .care-hero__video {
      flex: 1 1 340px;
      max-width: 520px;
    }
    .care-video-wrap {
      border-radius: 12px;
      overflow: hidden;
      aspect-ratio: 16/9;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .care-video-wrap iframe {
      width: 100%;
      height: 100%;
      display: block;
      border: none;
    }

    /* ===== SERVICES SECTION ===== */
    .care-services {
      padding: 80px 24px;
      background: #f5f0e8;
    }
    .care-services__header {
      text-align: center;
      margin-bottom: 56px;
    }
    .care-services__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 12px;
    }
    .care-services__title {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 700;
      color: #111;
      margin-bottom: 12px;
    }
    .care-services__sub {
      font-size: 15px;
      color: #666;
      max-width: 480px;
      margin: 0 auto;
    }
    .care-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 24px;
      max-width: 1100px;
      margin: 0 auto;
    }
    .care-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid rgba(0,0,0,0.07);
      display: flex;
      flex-direction: column;
      transition: transform .25s ease, box-shadow .25s ease;
    }
    .care-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.1);
    }
    .care-card__img-wrap {
      aspect-ratio: 4/3;
      overflow: hidden;
      background: #f0ebe0;
    }
    .care-card__img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform .3s ease;
    }
    .care-card:hover .care-card__img-wrap img {
      transform: scale(1.05);
    }
    .care-card__body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }
    .care-card__tag {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 6px;
    }
    .care-card__name {
      font-size: 15px;
      font-weight: 700;
      color: #111;
      margin-bottom: auto;
      padding-bottom: 16px;
    }
    .care-card__btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      font-weight: 600;
      color: #ef5008;
      border: 1.5px solid #ef5008;
      border-radius: 99px;
      padding: 8px 18px;
      text-decoration: none;
      transition: all .2s ease;
      width: fit-content;
      background: transparent;
    }
    .care-card__btn:hover {
      background: #ef5008;
      color: #fff;
      text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .care-hero { padding: 60px 20px 48px; }
      .care-services { padding: 60px 16px; }
      .care-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
      }
      .care-card__body { padding: 14px; }
      .care-hero__content { gap: 32px; }
    }
  </style>

  <!-- HERO -->
  <section class="care-hero">
    <div class="care-hero__inner">
      <div class="care-hero__top">
        <div class="care-hero__eyebrow"></div>
        <h1 class="care-hero__title">ESC Care</h1>
        <div class="care-hero__divider"></div>
      </div>
      <div class="care-hero__content">
        <div class="care-hero__text">
          <p>Care adalah bentuk pelayanan gereja sebagai kasih nyata kepada jemaat yang sedang mengalami pergumulan hidup. Melalui pelayanan ini, gereja ingin hadir, mendampingi, dan menyatakan kasih Kristus secara praktis.</p>
          <p>Kami percaya bahwa gereja adalah komunitas yang peduli, menopang, dan hadir dalam setiap musim kehidupan jemaat.</p>
          <p>Jika Anda atau orang terdekat sedang membutuhkan pelayanan ini, silahkan pilih sesuai dengan kebutuhan Anda. Kami dengan senang hati akan melayani Anda dalam kasih Kristus.</p>
          <div class="care-quote">
            <p>Tidak ada seorang pun yang dipanggil untuk berjalan sendiri. Dalam kasih Tuhan, kami ingin hadir bagi Anda.</p>
          </div>
        </div>
        <div class="care-hero__video">
          <div class="care-video-wrap">
            <iframe
              src="https://www.youtube.com/embed/ZqULgqLXYz8?mute=1"
              title="YouTube video player"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              referrerpolicy="strict-origin-when-cross-origin"
              allowfullscreen>
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- LAYANAN GRID -->
  <section class="care-services">
    <div class="care-services__header">
      <div class="care-services__eyebrow">Pelayanan Gereja</div>
      <h2 class="care-services__title">Bidang Care</h2>
      <p class="care-services__sub">Pilih layanan sesuai dengan kebutuhan Anda</p>
    </div>
    <div class="care-grid">

      <div class="care-card">
        <div class="care-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/doa.png'); ?>" alt="Permohonan Doa">
        </div>
        <div class="care-card__body">
          <div class="care-card__tag">Care</div>
          <div class="care-card__name">Permohonan Doa</div>
          <a class="care-card__btn" href="<?php echo site_url('permohonandoa/index'); ?>">Selengkapnya →</a>
        </div>
      </div>

      <div class="care-card">
        <div class="care-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/konseling.png'); ?>" alt="Konseling Kerohanian">
        </div>
        <div class="care-card__body">
          <div class="care-card__tag">Care</div>
          <div class="care-card__name">Pelayanan Konseling Kerohanian</div>
          <a class="care-card__btn" href="<?php echo site_url('konselingcare/index'); ?>">Selengkapnya →</a>
        </div>
      </div>

      <div class="care-card">
        <div class="care-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/kunjungan.png'); ?>" alt="Pelayanan Kunjungan">
        </div>
        <div class="care-card__body">
          <div class="care-card__tag">Care</div>
          <div class="care-card__name">Pelayanan Kunjungan</div>
          <a class="care-card__btn" href="<?php echo site_url('kunjunganjemaat/index'); ?>">Selengkapnya →</a>
        </div>
      </div>

      <div class="care-card">
        <div class="care-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan.png'); ?>" alt="Penyerahan Anak">
        </div>
        <div class="care-card__body">
          <div class="care-card__tag">Care</div>
          <div class="care-card__name">Penyerahan Anak</div>
          <a class="care-card__btn" href="<?php echo site_url('penyerahananak/index'); ?>">Selengkapnya →</a>
        </div>
      </div>

      <div class="care-card">
        <div class="care-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/marriage.png'); ?>" alt="Pemberkatan Pernikahan">
        </div>
        <div class="care-card__body">
          <div class="care-card__tag">Care</div>
          <div class="care-card__name">Pemberkatan Pernikahan</div>
          <a class="care-card__btn" href="<?php echo site_url('pernikahan/index'); ?>">Selengkapnya →</a>
        </div>
      </div>

      <div class="care-card">
        <div class="care-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/kedukaan.png'); ?>" alt="Pelayanan Kedukaan">
        </div>
        <div class="care-card__body">
          <div class="care-card__tag">Care</div>
          <div class="care-card__name">Pelayanan Kedukaan</div>
          <a class="care-card__btn" href="<?php echo site_url('kematian/index'); ?>">Selengkapnya →</a>
        </div>
      </div>

      <div class="care-card">
        <div class="care-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/baptis.png'); ?>" alt="Pelayanan Baptisan">
        </div>
        <div class="care-card__body">
          <div class="care-card__tag">Care</div>
          <div class="care-card__name">Pelayanan Baptisan</div>
          <a class="care-card__btn" href="<?php echo site_url('baptisan/index'); ?>">Selengkapnya →</a>
        </div>
      </div>

    </div>
  </section>

<?php $this->load->view('template/festavalive/footer'); ?>