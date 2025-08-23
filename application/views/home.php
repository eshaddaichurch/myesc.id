<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- Import font Figtree -->
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #e9d6a8;
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

    #section_1 {
      height: 100vh;
    }


  
  /* Responsive fix untuk hero section */
  @media (max-width: 576px) {
    .hero-section small {
      font-size: 14px; /* lebih kecil agar proporsional */
    }
    .hero-section h1 {
      font-size: 28px; /* perkecil judul di mobile */
      margin-bottom: 1.5rem;
    }
    .hero-section .btn {
      padding: 12px 28px; /* tombol lebih kecil di mobile */
      font-size: 14px;
    }
  }

  @media (min-width: 577px) and (max-width: 768px) {
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
      font-size: 48px; /* ukuran normal di desktop */
    }
  }


  /* @media screen and (max-width: 480px) {
    .hero-section small {
      font-size: 14px !important;
    }

    .hero-section h1 {
      font-size: 22px !important; 
      line-height: 1.3 !important;
    }

    .hero-section .btn {
      font-size: 14px !important;
      padding: 10px 24px !important;
    }
  } */



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
            <?php
            if (!empty($rowinfogereja->urlbuttonhomepage)) {
              echo '<a class="btn custom-btn smoothscroll" href="' . $rowinfogereja->urlbuttonhomepage . '" target="_blank">Watch</a>';
            }
            ?>
          </div>
          <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
            <div class="date-wrap"></div>
            <div class="location-wrap mx-auto py-3 py-lg-0"></div>
            <div class="social-share"></div>
          </div>
        </div>
      </div>

      <div class="video-wrap">
        <video autoplay loop muted class="custom-video" poster="">
          <source src="<?php echo base_url('myesc.id/admin/uploads/infogereja/') . $rowinfogereja->gambarhomepage ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </section>

    <?php $this->load->view('template/festavalive/footer'); ?>
  </main>

</body>
</html>
