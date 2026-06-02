<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- Import font Figtree -->
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: rgb(0, 0, 0);
      font-family: 'Figtree', sans-serif;
      color: #111;
      line-height: 1.7;
      text-rendering: optimizeLegibility;
    }

    a.btn {
      background: #f5008;
      border-radius: 16px;
      box-shadow: 0 2px 0px 0 rgba(0, 0, 0, 0.25);
      color: #ffffff;
      display: inline-block;
      padding: 20px 50px 20px;
      position: relative;
      text-decoration: none;
      transition: all 0.1s ease-out;
    }

    .no-touch a.btn:hover {
      background: lighten(#0096a0, 2.5);
      box-shadow: 0px 8px 2px 0 rgba(0, 0, 0, 0.075);
      transform: translateY(-2px);
      transition: all 0.25s ease-out;
    }

    .no-touch a.btn:active,
    a.btn:active {
      background: darken(#0096a0, 2.5);
      box-shadow: 0 1px 0px 0 rgba(255, 255, 255, 0.25);
      transform: translate3d(0, 1px, 0);
      transition: all 0.025s ease-out;
    }

    div.cards {
      margin: 80px auto;
      max-width: 960px;
      text-align: center;
    }

    div.card {
      background: #ffffff;
      display: inline-block;
      margin: 8px;
      max-width: 300px;
      perspective: 1000;
      position: relative;
      text-align: left;
      transition: all 0.3s ease-in;
      width: 300px;
      z-index: 1;
    }

    div.card img {
      max-width: 300px;
    }

    .card__image-holder {
      background: rgba(0, 0, 0, 0.1);
      height: 0;
      padding-bottom: 75%;
    }

    div.card-title {
      background: #ffffff;
      padding: 6px 15px 10px;
      position: relative;
      z-index: 0;
    }

    div.card-title a.toggle-info {
      border-radius: 32px;
      height: 32px;
      padding: 0;
      position: absolute;
      right: 15px;
      top: 10px;
      width: 32px;
    }

    div.card-title a.toggle-info span {
      background: #ffffff;
      display: block;
      height: 2px;
      position: absolute;
      top: 16px;
      transition: all 0.15s ease-out;
      width: 12px;
    }

    div.card-title a.toggle-info span.left {
      right: 14px;
      transform: rotate(45deg);
    }

    div.card-title a.toggle-info span.right {
      left: 14px;
      transform: rotate(-45deg);
    }

    div.card-title h2 {
      font-size: 24px;
      font-weight: 700;
      letter-spacing: -0.05em;
      margin: 0;
      padding: 0;
    }

    div.card-title h2 small {
      display: block;
      font-size: 18px;
      font-weight: 600;
      letter-spacing: -0.025em;
    }

    div.card-description {
      padding: 0 15px 10px;
      position: relative;
      font-size: 14px;
    }

    div.card-actions {
      box-shadow: 0 2px 0px 0 rgba(0, 0, 0, 0.075);
      padding: 10px 15px 20px;
      text-align: center;
    }

    div.card-flap {
      background: darken(#ffffff, 15);
      position: absolute;
      width: 100%;
      transform-origin: top;
      transform: rotateX(-90deg);
    }

    div.flap1 {
      transition: all 0.3s 0.3s ease-out;
      z-index: -1;
    }

    div.flap2 {
      transition: all 0.3s ease-out;
      z-index: -2;
    }

    div.cards.showing div.card {
      cursor: pointer;
      opacity: 0.6;
      transform: scale(0.88);
    }

    .no-touch div.cards.showing div.card:hover {
      opacity: 0.94;
      transform: scale(0.92);
    }

    div.card.show {
      opacity: 1 !important;
      transform: scale(1) !important;
    }

    div.card.show div.card-title a.toggle-info {
      background: #ff6666 !important;
    }

    div.card.show div.card-title a.toggle-info span {
      top: 15px;
    }

    div.card.show div.card-title a.toggle-info span.left {
      right: 10px;
    }

    div.card.show div.card-title a.toggle-info span.right {
      left: 10px;
    }

    div.card.show div.card-flap {
      background: #ffffff;
      transform: rotateX(0deg);
    }

    div.card.show div.flap1 {
      transition: all 0.3s ease-out;
    }

    div.card.show div.flap2 {
      transition: all 0.3s 0.2s ease-out;
    }

    /* =============================================
       HERO SECTION — FIXED
    ============================================= */

    #section_1 {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    /* Overlay gelap di atas video */
    #section_1 .section-overlay {
      position: absolute;
      inset: 0;               /* shorthand untuk top/right/bottom/left: 0 */
      z-index: 1;
      background: rgba(0, 0, 0, 0.35); /* sesuaikan kegelapan overlay */
    }

    /* Konten teks & tombol di atas overlay */
    #section_1 .container {
      position: relative;
      z-index: 2;
      height: 100%;
    }

    /* Wrapper video — fullscreen absolute */
    .video-wrap {
      position: absolute;
      inset: 0;
      z-index: 0;
      overflow: hidden;
    }

    /* Video — teknik translate untuk menghindari lag vs object-fit */
    .custom-video {
      position: absolute;
      top: 50%;
      left: 50%;
      /* GPU acceleration — fix patah-patah di mobile */
      -webkit-transform: translate(-50%, -50%) translateZ(0);
      transform: translate(-50%, -50%) translateZ(0);
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      will-change: transform;
      /* Pastikan video selalu menutupi seluruh area */
      min-width: 100%;
      min-height: 100%;
      width: auto;
      height: auto;
      pointer-events: none;
    }

    /* =============================================
       RESPONSIVE HERO TEXT
    ============================================= */

    @media (max-width: 576px) {
      #section_1 {
        height: 100svh; /* fix iOS Safari address bar */
      }
      .hero-section small {
        font-size: 14px;
      }
      .hero-section h1 {
        font-size: 28px;
        margin-bottom: 1.5rem;
      }
      .hero-section .btn {
        padding: 12px 28px;
        font-size: 14px;
      }
    }

    @media (min-width: 577px) and (max-width: 768px) {
      #section_1 {
        height: 100svh;
      }
      .hero-section small {
        font-size: 16px;
      }
      .hero-section h1 {
        font-size: 36px;
      }
      .hero-section .btn {
        padding: 14px 32px;
        font-size: 15px;
      }
    }

    @media (min-width: 769px) {
      .hero-section h1 {
        font-size: 48px;
      }
    }

    /* =============================================
       CTA BUBBLE (dinonaktifkan, CSS tetap ada)
    ============================================= */

    .disciples-cta-bubble {
      position: fixed;
      bottom: 24px;
      left: 24px;
      width: 56px;
      height: 56px;
      border-radius: 50%;
      background: #ff5008;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      font-weight: 700;
      letter-spacing: 1px;
      cursor: pointer;
      z-index: 999;
      box-shadow: 0 10px 28px rgba(0,0,0,0.3);
      transition: transform .25s ease, box-shadow .25s ease;
    }

    .disciples-cta-bubble:hover {
      transform: scale(1.08);
      box-shadow: 0 14px 34px rgba(0,0,0,0.35);
    }

    .disciples-cta-bubble:active {
      transform: scale(0.96);
    }

    .disciples-mini {
      position: fixed;
      bottom: 100px;
      left: 24px;
      width: 280px;
      background: #ffffff;
      border-radius: 14px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.25);
      pointer-events: none;
      z-index: 1000;
      transform: translateY(30px) scale(0.96);
      opacity: 0;
      transition: all 0.25s ease;
    }

    .disciples-mini.active {
      transform: translateY(0) scale(1);
      opacity: 1;
      pointer-events: auto;
    }

    .disciples-mini-header {
      padding: 12px 14px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      border-bottom: 1px solid #eee;
    }

    .disciples-mini-header button {
      border: none;
      background: none;
      font-size: 18px;
      cursor: pointer;
    }

    .disciples-mini-body {
      padding: 16px;
    }

    .disciples-mini-body p {
      font-size: 14px;
      margin-bottom: 16px;
    }

    .disciples-mini-btn {
      display: block;
      text-align: center;
      background: #ff5008;
      color: #fff;
      padding: 10px;
      border-radius: 10px;
      text-decoration: none;
      font-weight: 600;
    }

    .disciples-mini-btn:hover {
      background: #e04607;
    }

    @media (max-width: 576px) {
      .disciples-cta-bubble {
        bottom: 16px;
        left: 16px;
        width: 52px;
        height: 52px;
        font-size: 15px;
      }

      .disciples-mini {
        width: 240px;
        left: 16px;
      }
    }

  </style>

  <main>
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <section class="hero-section" id="section_1">
      <div class="section-overlay"></div>

      <div class="container d-flex justify-content-center align-items-center">
        <div class="row">
          <div class="col-12 mt-auto mb-5 text-center">
            <small><?php echo $rowinfogereja->subjudulhomepage ?></small>
            <h1 class="text-white mb-5"><?php echo $rowinfogereja->judulhomepage ?></h1>
            <a class="btn custom-btn smoothscroll" href="https://myesc.id/disciples_community/index">
              Join DC
            </a>
          </div>
          <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
            <div class="date-wrap"></div>
            <div class="location-wrap mx-auto py-3 py-lg-0"></div>
            <div class="social-share"></div>
          </div>
        </div>
      </div>

      <div class="video-wrap">
        <video
          autoplay
          loop
          muted
          playsinline
          webkit-playsinline
          disablepictureinpicture
          disableremoteplayback
          class="custom-video"
          poster="">
          <source src="<?php echo base_url('myesc.id/admin/uploads/infogereja/') . $rowinfogereja->gambarhomepage ?>" type="video/mp4">
        </video>
      </div>
    </section>

    <?php $this->load->view('template/festavalive/footer'); ?>
  </main>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const video = document.querySelector('.custom-video');

      if (video) {
        video.muted = true;
        video.setAttribute('muted', '');
        video.setAttribute('playsinline', '');

        const playPromise = video.play();

        if (playPromise !== undefined) {
          playPromise.catch(function () {
            document.addEventListener('touchstart', function () {
              video.play();
            }, { once: true });
          });
        }
      }
    });
  </script>

</body>
</html>