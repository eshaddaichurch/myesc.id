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
    .comm-hero {
      background: #111;
      color: #fff;
      padding: 80px 24px 64px;
      position: relative;
      overflow: hidden;
    }
    .comm-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at 70% 30%, rgba(239,80,8,0.15) 0%, transparent 70%);
      pointer-events: none;
    }
    .comm-hero__inner {
      max-width: 1100px;
      margin: 0 auto;
      position: relative;
    }
    .comm-hero__top {
      text-align: center;
      margin-bottom: 56px;
    }
    .comm-hero__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 14px;
    }
    .comm-hero__title {
      font-size: clamp(2rem, 5vw, 3.5rem);
      font-weight: 700;
      color: #fff;
      line-height: 6.15;
      margin-bottom: -90px;
    }
    .comm-hero__divider {
      width: 48px;
      height: 3px;
      background: #ef5008;
      border-radius: 2px;
      margin: 20px auto 0;
    }
    .comm-hero__content {
      display: flex;
      flex-wrap: wrap;
      gap: 48px;
      align-items: flex-start;
      justify-content: center;
    }
    .comm-hero__text {
      flex: 1 1 340px;
      max-width: 540px;
    }
    .comm-hero__text p {
      font-size: 15px;
      color: #bbb;
      line-height: 1.9;
      margin-bottom: 14px;
    }
    .comm-hero__video {
      flex: 1 1 340px;
      max-width: 520px;
    }
    .comm-video-wrap {
      border-radius: 12px;
      overflow: hidden;
      aspect-ratio: 16/9;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .comm-video-wrap iframe {
      width: 100%;
      height: 100%;
      display: block;
      border: none;
    }

    /* ===== COMMUNITY SECTION ===== */
    .comm-section {
      padding: 80px 24px;
      background: #f5f0e8;
    }
    .comm-section__header {
      text-align: center;
      margin-bottom: 56px;
    }
    .comm-section__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 12px;
    }
    .comm-section__title {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 700;
      color: #111;
      margin-bottom: 12px;
    }
    .comm-section__sub {
      font-size: 15px;
      color: #666;
      max-width: 480px;
      margin: 0 auto;
    }
    .comm-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 24px;
      max-width: 1100px;
      margin: 0 auto;
    }
    .comm-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid rgba(0,0,0,0.07);
      display: flex;
      flex-direction: column;
      transition: transform .25s ease, box-shadow .25s ease;
    }
    .comm-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.1);
    }
    .comm-card__img-wrap {
      aspect-ratio: 4/3;
      overflow: hidden;
      background: #f0ebe0;
    }
    .comm-card__img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform .3s ease;
    }
    .comm-card:hover .comm-card__img-wrap img {
      transform: scale(1.05);
    }
    .comm-card__body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }
    .comm-card__tag {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 6px;
    }
    .comm-card__name {
      font-size: 15px;
      font-weight: 700;
      color: #111;
      margin-bottom: auto;
      padding-bottom: 16px;
    }
    .comm-card__btn {
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
    .comm-card__btn:hover {
      background: #ef5008;
      color: #fff;
      text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .comm-hero { padding: 60px 20px 48px; }
      .comm-section { padding: 60px 16px; }
      .comm-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
      }
      .comm-card__body { padding: 14px; }
      .comm-hero__content { gap: 32px; }
    }
  </style>

  <!-- HERO -->
  <section class="comm-hero">
    <div class="comm-hero__inner">
      <div class="comm-hero__top">
        <div class="comm-hero__eyebrow"></div>
        <h1 class="comm-hero__title">ESC Community</h1>
        <div class="comm-hero__divider"></div>
      </div>
      <div class="comm-hero__content">
        <div class="comm-hero__text">
          <p>ESC Community adalah wadah komunitas di El Shaddai Church yang dirancang untuk menjawab kebutuhan jemaat sesuai dengan demografi usia dan musim kehidupan yang belum dapat disentuh secara spesifik dalam ibadah umum.</p>
          <p>Masing-masing komunitas difokuskan untuk membangun pertumbuhan rohani yang relevan, membentuk karakter Kristus, dan memperlengkapi jemaat agar hidup dalam panggilan mereka.</p>
          <p>Melalui ESC Community, ESC mengaktualisasikan visi: "Membangun Generasi yang Menghidupi Amanat Agung" dengan menciptakan lingkungan komunitas yang membina, mengutus, dan memperlengkapi setiap generasi untuk menjadi murid Kristus yang berdampak.</p>
        </div>
        <div class="comm-hero__video">
          <div class="comm-video-wrap">
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

  <!-- COMMUNITY GRID -->
  <section class="comm-section">
    <div class="comm-section__header">
      <div class="comm-section__eyebrow">Komunitas Gereja</div>
      <h2 class="comm-section__title">Community</h2>
      <p class="comm-section__sub"></p>
    </div>
    <div class="comm-grid">

      <div class="comm-card">
        <div class="comm-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/kids.png'); ?>" alt="ESC Kids">
        </div>
        <div class="comm-card__body">
          <div class="comm-card__tag">Community</div>
          <div class="comm-card__name">ESC Kids</div>
          <a class="comm-card__btn" href="<?= site_url('esckids/index') ?>">Lebih Lanjut →</a>
        </div>
      </div>

      <div class="comm-card">
        <div class="comm-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/youth.png'); ?>" alt="ESC Youth">
        </div>
        <div class="comm-card__body">
          <div class="comm-card__tag">Community</div>
          <div class="comm-card__name">ESC Youth</div>
          <a class="comm-card__btn" href="<?= site_url('youth/index') ?>">Lebih Lanjut →</a>
        </div>
      </div>

      <div class="comm-card">
        <div class="comm-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/ya.png'); ?>" alt="ESC Young Adult">
        </div>
        <div class="comm-card__body">
          <div class="comm-card__tag">Community</div>
          <div class="comm-card__name">ESC Young Adult</div>
          <a class="comm-card__btn" href="<?= site_url('youngadult/index') ?>">Lebih Lanjut →</a>
        </div>
      </div>

      <div class="comm-card">
        <div class="comm-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/women.png'); ?>" alt="ESC Women">
        </div>
        <div class="comm-card__body">
          <div class="comm-card__tag">Community</div>
          <div class="comm-card__name">ESC Women</div>
          <a class="comm-card__btn" href="<?= site_url('escwomen/index') ?>">Lebih Lanjut →</a>
        </div>
      </div>

      <div class="comm-card">
        <div class="comm-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/gold.png'); ?>" alt="ESC Gold">
        </div>
        <div class="comm-card__body">
          <div class="comm-card__tag">Community</div>
          <div class="comm-card__name">ESC Gold</div>
          <a class="comm-card__btn" href="<?= site_url('gold/index') ?>">Lebih Lanjut →</a>
        </div>
      </div>

      <div class="comm-card">
        <div class="comm-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/dc.png'); ?>" alt="ESC Disciples Community">
        </div>
        <div class="comm-card__body">
          <div class="comm-card__tag">Community</div>
          <div class="comm-card__name">ESC Disciples Community</div>
          <a class="comm-card__btn" href="<?= site_url('disciples_community/index') ?>">Lebih Lanjut →</a>
        </div>
      </div>

    </div>
  </section>

<?php $this->load->view('template/festavalive/footer'); ?>