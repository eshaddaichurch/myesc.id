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
    .equip-hero {
      background: #111;
      color: #fff;
      padding: 80px 24px 64px;
      position: relative;
      overflow: hidden;
    }
    .equip-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: radial-gradient(ellipse at 65% 40%, rgba(239,80,8,0.15) 0%, transparent 70%);
      pointer-events: none;
    }
    .equip-hero__inner {
      max-width: 1100px;
      margin: 0 auto;
      position: relative;
    }
    .equip-hero__top {
      text-align: center;
      margin-bottom: 56px;
    }
    .equip-hero__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 14px;
    }
    .equip-hero__title {
      font-size: clamp(2rem, 5vw, 3.5rem);
      font-weight: 700;
      color: #fff;
      line-height: 1.15;
      margin-bottom: 0;
    }
    .equip-hero__divider {
      width: 48px;
      height: 3px;
      background: #ef5008;
      border-radius: 2px;
      margin: 20px auto 0;
    }
    .equip-hero__content {
      display: flex;
      flex-wrap: wrap;
      gap: 48px;
      align-items: flex-start;
      justify-content: center;
    }
    .equip-hero__text {
      flex: 1 1 340px;
      max-width: 540px;
    }
    .equip-hero__text p {
      font-size: 15px;
      color: #bbb;
      line-height: 1.9;
      margin-bottom: 16px;
    }
    .equip-pillars {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      margin-top: 24px;
    }
    .equip-pillar {
      background: rgba(239,80,8,0.12);
      border-radius: 8px;
      padding: 12px 16px;
      flex: 1 1 100px;
    }
    .equip-pillar__label {
      font-size: 11px;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 4px;
    }
    .equip-pillar__desc {
      font-size: 9px;
      color: #999;
    }
    .equip-hero__video {
      flex: 1 1 340px;
      max-width: 520px;
    }
    .equip-video-wrap {
      border-radius: 12px;
      overflow: hidden;
      aspect-ratio: 16/9;
      border: 1px solid rgba(255,255,255,0.1);
    }
    .equip-video-wrap iframe {
      width: 100%;
      height: 100%;
      display: block;
      border: none;
    }

    /* ===== CLASSES SECTION ===== */
    .equip-classes {
      padding: 80px 24px;
      background: #f5f0e8;
    }
    .equip-classes__header {
      text-align: center;
      margin-bottom: 56px;
    }
    .equip-classes__eyebrow {
      font-size: 12px;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 12px;
    }
    .equip-classes__title {
      font-size: clamp(1.8rem, 4vw, 2.8rem);
      font-weight: 700;
      color: #111;
      margin-bottom: 12px;
    }
    .equip-classes__sub {
      font-size: 15px;
      color: #666;
      max-width: 480px;
      margin: 0 auto;
    }
    .equip-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 24px;
      max-width: 1100px;
      margin: 0 auto;
    }
    .equip-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      border: 1px solid rgba(0,0,0,0.07);
      display: flex;
      flex-direction: column;
      transition: transform .25s ease, box-shadow .25s ease;
    }
    .equip-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 16px 40px rgba(0,0,0,0.1);
    }
    .equip-card__img-wrap {
      aspect-ratio: 4/3;
      overflow: hidden;
      background: #f0ebe0;
    }
    .equip-card__img-wrap img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform .3s ease;
    }
    .equip-card:hover .equip-card__img-wrap img {
      transform: scale(1.05);
    }
    .equip-card__body {
      padding: 20px;
      display: flex;
      flex-direction: column;
      flex: 1;
    }
    .equip-card__tag {
      font-size: 10px;
      letter-spacing: 2px;
      text-transform: uppercase;
      color: #ef5008;
      font-weight: 600;
      margin-bottom: 6px;
    }
    .equip-card__name {
      font-size: 15px;
      font-weight: 700;
      color: #111;
      margin-bottom: auto;
      padding-bottom: 16px;
    }
    .equip-card__btn {
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
    .equip-card__btn:hover {
      background: #ef5008;
      color: #fff;
      text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 600px) {
      .equip-hero { padding: 60px 20px 48px; }
      .equip-classes { padding: 60px 16px; }
      .equip-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 16px;
      }
      .equip-card__body { padding: 14px; }
      .equip-hero__content { gap: 32px; }
    }
  </style>

  <!-- HERO -->
  <section class="equip-hero">
    <div class="equip-hero__inner">
      <div class="equip-hero__top">
        <!-- <div class="equip-hero__eyebrow">El Shaddai Church</div> -->
        <h1 class="equip-hero__title">ESC Equip</h1>
        <div class="equip-hero__divider"></div>
      </div>
      <div class="equip-hero__content">
        <div class="equip-hero__text">
          <p>ESC Equip adalah Wadah Bidang Pengajaran di El Shaddai Church (ESC) yang bertujuan mempersiapkan jemaat untuk bertumbuh dalam iman, sehingga mereka dapat menjadi serupa dengan Kristus, sebagaimana dinyatakan dalam Roma 8:29, “Sebab semua orang yang dipilih-Nya dari semula, mereka juga ditentukanNya dari semula untuk menjadi serupa dengan gambaran Anak-Nya.</p>
          <!-- <p>Dengan Visi ESC "Menjadi Jemaat yang Serupa dengan Kristus Yesus" dan Misi ESC Planted: Tertanam dalam Kristus dan dalam Disciples Community. Grow: Bertumbuh dalam pengenalan akan Kristus dan berproses dibentuk sebagai murid. Fruitful: Menjadi murid Kristus yang memuridkan dan berdampak bagi orang lain, Equip menawarkan serangkaian Tahap atau Langkah yang terarah untuk menuntun jemaat ke dalam kedewasaan rohani sesuai Visi dan Misi ESC.</p> -->
          <div class="equip-pillars">
            <div class="equip-pillar">
              <div class="equip-pillar__label">Planted</div>
              <div class="equip-pillar__desc">Tertanam dalam Kristus dan dalam Disciples Community</div>
            </div>
            <div class="equip-pillar">
              <div class="equip-pillar__label">Grow</div>
              <div class="equip-pillar__desc">Bertumbuh dalam pengenalan akan Kristus dan berproses dibentuk sebagai murid</div>
            </div>
            <div class="equip-pillar">
              <div class="equip-pillar__label">Fruitful</div>
              <div class="equip-pillar__desc">Menjadi murid Kristus yang memuridkan dan berdampak bagi orang lain</div>
            </div>
          </div>
        </div>
        <div class="equip-hero__video">
          <div class="equip-video-wrap">
            <iframe src="https://www.youtube.com/embed/_YdWDCUCqsY?si=KTQHbm174-iF6Hx1"
              title="YouTube video player"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- KELAS GRID -->
  <section class="equip-classes">
    <div class="equip-classes__header">
      <div class="equip-classes__eyebrow">Program Pengajaran</div>
      <h2 class="equip-classes__title">Kelas Equip</h2>
      <!-- <p class="equip-classes__sub">Temukan kelas yang sesuai dengan tahap perjalanan rohani Anda</p> -->
    </div>
    <div class="equip-grid">

      <div class="equip-card">
        <div class="equip-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/fc1.png'); ?>" alt="Foundation Class 1">
        </div>
        <div class="equip-card__body">
          <div class="equip-card__tag">Foundation</div>
          <div class="equip-card__name">Foundation Class 1</div>
          <a class="equip-card__btn" href="<?= site_url('nextstep/kelas/foundation_class_1') ?>">
            Lebih Lanjut →
          </a>
        </div>
      </div>

      <div class="equip-card">
        <div class="equip-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/fc2.png'); ?>" alt="Foundation Class 2">
        </div>
        <div class="equip-card__body">
          <div class="equip-card__tag">Foundation</div>
          <div class="equip-card__name">Foundation Class 2</div>
          <a class="equip-card__btn" href="<?= site_url('nextstep/kelas/foundation_class_2') ?>">
            Lebih Lanjut →
          </a>
        </div>
      </div>

      <div class="equip-card">
        <div class="equip-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/fc3.png'); ?>" alt="Foundation Class 3">
        </div>
        <div class="equip-card__body">
          <div class="equip-card__tag">Foundation</div>
          <div class="equip-card__name">Foundation Class 3</div>
          <a class="equip-card__btn" href="<?= site_url('nextstep/kelas/foundation_class_3') ?>">
            Lebih Lanjut →
          </a>
        </div>
      </div>

      <div class="equip-card">
        <div class="equip-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/gd1.png'); ?>" alt="Grade 1">
        </div>
        <div class="equip-card__body">
          <div class="equip-card__tag">Grade</div>
          <div class="equip-card__name">Grade 1</div>
          <a class="equip-card__btn" href="<?= site_url('nextstep/kelas/grade_1') ?>">
            Lebih Lanjut →
          </a>
        </div>
      </div>

      <div class="equip-card">
        <div class="equip-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/gd2.png'); ?>" alt="Grade 2">
        </div>
        <div class="equip-card__body">
          <div class="equip-card__tag">Grade</div>
          <div class="equip-card__name">Grade 2</div>
          <a class="equip-card__btn" href="<?= site_url('nextstep/kelas/grade_2') ?>">
            Lebih Lanjut →
          </a>
        </div>
      </div>

      <div class="equip-card">
        <div class="equip-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/gd3.png'); ?>" alt="Grade 3">
        </div>
        <div class="equip-card__body">
          <div class="equip-card__tag">Grade</div>
          <div class="equip-card__name">Grade 3</div>
          <a class="equip-card__btn" href="<?= site_url('nextstep/kelas/grade_3') ?>">
            Lebih Lanjut →
          </a>
        </div>
      </div>

      <div class="equip-card">
        <div class="equip-card__img-wrap">
          <img src="<?php echo base_url('myesc.id/assets/gambar/mc1.png'); ?>" alt="Marriage Class">
        </div>
        <div class="equip-card__body">
          <div class="equip-card__tag">Marriage</div>
          <div class="equip-card__name">Marriage Class</div>
          <a class="equip-card__btn" href="<?= site_url('nextstep/kelas/marriage_class') ?>">
            Lebih Lanjut →
          </a>
        </div>
      </div>

    </div>
  </section>

<?php $this->load->view('template/festavalive/footer'); ?>