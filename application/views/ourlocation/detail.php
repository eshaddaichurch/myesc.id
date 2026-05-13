<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- FONTS & LIBRARIES -->
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" crossorigin="anonymous"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous"/>

  <style>
    /* ===== RESET & BASE ===== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; width: 100%; }
    body {
      font-family: 'Figtree', system-ui, -apple-system, sans-serif;
      background: #f5f0e8; /* konsisten dgn semua halaman ESC */
      color: #111827;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      overflow-x: hidden;
    }
    img { max-width: 100%; height: auto; display: block; }
    a, a:hover { text-decoration: none; }

    /* ===== PAGE WRAPPER ===== */
    .page-wrapper {
      min-height: 100vh;
      padding: 190px 0 60px;
    }

    /* ===== BACK BUTTON ===== */
    .back-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      font-weight: 600;
      color: #666;
      margin-bottom: 20px;
      transition: color .2s;
    }
    .back-btn:hover { color: #ef5008; }
    .back-btn i { font-size: 12px; }

    /* ===== MAIN CARD ===== */
    .location-card {
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 8px 40px rgba(0,0,0,0.10);
      overflow: hidden;
      max-width: 980px;
      margin: 0 auto;
    }

    /* ===== TOP SECTION: carousel + info ===== */
    .location-top {
      display: flex;
      flex-wrap: wrap;
      align-items: stretch;
    }

    /* ---- CAROUSEL SIDE ---- */
    .carousel-side {
      flex: 0 0 54%;
      max-width: 54%;
      position: relative;
      background: #111;
      border-radius: 24px 0 0 0;
      overflow: hidden;
    }

    #sync1.owl-carousel { position: relative; height: 100%; }
    #sync1 .owl-stage-outer { overflow: hidden !important; height: 100%; }
    #sync1 .owl-stage { height: 100%; }
    #sync1 .item { height: 100%; }
    #sync1 .frame {
      display: block;
      width: 100%;
      height: 420px;
    }
    #sync1 .frame img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Arrows */
    #sync1.owl-theme .owl-nav { margin: 0; }
    #sync1.owl-theme .owl-prev,
    #sync1.owl-theme .owl-next {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255,255,255,0.92) !important;
      width: 40px;
      height: 40px;
      border-radius: 50% !important;
      display: flex !important;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 14px rgba(0,0,0,0.15);
      z-index: 20;
      transition: background .2s;
    }
    #sync1.owl-theme .owl-prev:hover,
    #sync1.owl-theme .owl-next:hover { background: #fff !important; }
    #sync1.owl-theme .owl-prev { left: 16px; }
    #sync1.owl-theme .owl-next { right: 16px; }
    #sync1.owl-theme .owl-prev span,
    #sync1.owl-theme .owl-next span { font-size: 20px; color: #333; line-height: 1; }

    /* Dots — oranye ESC */
    #sync1.owl-theme .owl-dots {
      position: absolute;
      bottom: 14px;
      left: 50%;
      transform: translateX(-50%);
    }
    #sync1.owl-theme .owl-dots .owl-dot span {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: rgba(255,255,255,0.5);
      margin: 4px;
      transition: background .2s, transform .2s;
    }
    #sync1.owl-theme .owl-dots .owl-dot.active span {
      background: #ef5008;
      transform: scale(1.2);
    }

    /* ---- INFO SIDE ---- */
    .info-side {
      flex: 0 0 46%;
      max-width: 46%;
      padding: 32px 32px 28px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .location-label {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #ef5008;
      margin-bottom: 10px;
    }

    .location-name {
      font-size: 1.55rem;
      font-weight: 800;
      color: #0f172a;
      line-height: 1.2;
      margin-bottom: 24px;
    }

    /* Info rows */
    .info-row {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      margin-bottom: 16px;
    }
    .info-row:last-of-type { margin-bottom: 0; }
    .info-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #fff2ed;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 2px;
    }
    .info-icon i { font-size: 14px; color: #ef5008; }
    .info-text .info-label {
      font-size: 12px;
      font-weight: 700;
      color: #374151;
      margin-bottom: 2px;
    }
    .info-text .info-value {
      font-size: 13px;
      color: #4B5563;
      line-height: 1.5;
    }

    /* Action row */
    .action-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 24px;
      flex-wrap: wrap;
    }

    .btn-route {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #ef5008;
      color: #fff;
      font-weight: 700;
      font-size: 13px;
      padding: 11px 20px;
      border-radius: 12px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: background .2s, transform .15s;
      box-shadow: 0 4px 14px rgba(239,80,8,0.3);
    }
    .btn-route:hover {
      background: #c73e00;
      transform: translateY(-1px);
      color: #fff;
    }
    .btn-route i { font-size: 13px; }

    .social-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 12px;
      background: #f9f9f9;
      border: 1.5px solid #e5e7eb;
      color: #374151;
      font-size: 16px;
      transition: background .2s, transform .15s, border-color .2s;
      text-decoration: none;
    }
    .social-btn:hover {
      background: #fff2ed;
      border-color: #ef5008;
      color: #ef5008;
      transform: translateY(-2px);
    }

    /* ===== BOTTOM SECTION: jadwal + deskripsi ===== */
    .location-bottom {
      border-top: 1px solid #F3F4F6;
      display: flex;
      flex-wrap: wrap;
      padding: 32px;
      gap: 32px;
    }

    .bottom-left { flex: 1; min-width: 240px; }
    .bottom-right { flex: 1; min-width: 240px; }

    .section-title {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 20px;
    }
    .section-title .title-icon {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      background: #fff2ed;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .section-title .title-icon i { color: #ef5008; font-size: 15px; }
    .section-title h3 { font-size: 1.05rem; font-weight: 800; color: #0f172a; }

    /* Schedule */
    .schedule-list { list-style: none; padding: 0; margin: 0; }
    .schedule-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 16px;
      border-radius: 10px;
      background: #f9f9f9;
      margin-bottom: 8px;
      transition: background .2s;
    }
    .schedule-item:last-child { margin-bottom: 0; }
    .schedule-item:hover { background: #fff2ed; }
    .schedule-name { font-size: 13px; font-weight: 600; color: #374151; }
    .schedule-time { font-size: 13px; font-weight: 700; color: #ef5008; }

    /* Description */
    .desc-text { font-size: 14px; line-height: 1.8; color: #4B5563; }
    .desc-text p { margin-bottom: 12px; }
    .desc-text p:last-child { margin-bottom: 0; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .page-wrapper { padding: 80px 12px 40px; }
      .location-top { flex-direction: column; }
      .carousel-side, .info-side { flex: 0 0 100%; max-width: 100%; }
      .carousel-side { border-radius: 24px 24px 0 0; }
      #sync1 .frame { height: 240px; }
      .info-side { padding: 24px 20px; }
      .location-name { font-size: 1.3rem; }
      .location-bottom { padding: 24px 20px; flex-direction: column; gap: 24px; }
      .action-row { flex-direction: row; flex-wrap: wrap; }
    }

    @media (max-width: 480px) {
      .page-wrapper { padding: 70px 10px 40px; }
      #sync1 .frame { height: 200px; }
    }
  </style>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <div class="page-wrapper">
      <div class="container">

        <!-- BACK BUTTON -->
        <!-- <a class="back-btn" href="javascript:history.back()">
          <i class="fas fa-arrow-left"></i> Kembali ke Semua Lokasi
        </a> -->

        <div class="location-card">

          <!-- ===== TOP ===== -->
          <div class="location-top">

            <!-- Carousel -->
            <div class="carousel-side">
              <?php
              $gambarsampul = base_url('myesc.id/images/nofoto.png');
              if (!empty($rowCabang->gambarsampul)) {
                $gambarsampul = base_url('myesc.id/admin/uploads/cabanggereja/' . $rowCabang->gambarsampul);
              }
              ?>
              <div id="sync1" class="owl-carousel owl-theme">
                <div class="item">
                  <span class="frame">
                    <img src="<?php echo $gambarsampul ?>" loading="lazy"
                         alt="<?php echo htmlspecialchars($rowCabang->namacabang, ENT_QUOTES) ?>">
                  </span>
                </div>
                <?php
                if ($rsGallery->num_rows() > 0) {
                  foreach ($rsGallery->result() as $rowGallery) {
                    if (!empty($rowGallery->filegallery)) {
                      $filegallery = base_url('myesc.id/admin/uploads/cabanggereja/gallery/' . $rowGallery->filegallery);
                      ?>
                      <div class="item">
                        <span class="frame">
                          <img src="<?php echo $filegallery ?>" loading="lazy"
                               alt="<?php echo htmlspecialchars($rowCabang->namacabang, ENT_QUOTES) ?>">
                        </span>
                      </div>
                <?php
                    }
                  }
                }
                ?>
              </div>
            </div>

            <!-- Info -->
            <div class="info-side">
              <div class="location-label">Location Profile</div>
              <h1 class="location-name"><?php echo htmlspecialchars($rowCabang->namacabang, ENT_QUOTES) ?></h1>

              <!-- Address -->
              <?php if (!empty($rowCabang->alamatlengkap)) { ?>
              <div class="info-row">
                <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div class="info-text">
                  <div class="info-label">Alamat Gereja</div>
                  <div class="info-value"><?php echo nl2br(htmlspecialchars($rowCabang->alamatlengkap, ENT_QUOTES)) ?></div>
                </div>
              </div>
              <?php } ?>

              <!-- Phone -->
              <?php if (!empty($rowCabang->notelp)) { ?>
              <div class="info-row">
                <div class="info-icon"><i class="fas fa-phone"></i></div>
                <div class="info-text">
                  <div class="info-label">No Telepon</div>
                  <div class="info-value"><?php echo htmlspecialchars($rowCabang->notelp, ENT_QUOTES) ?></div>
                </div>
              </div>
              <?php } ?>

              <!-- Pastor -->
              <?php if (!empty($rowCabang->namagembala)) { ?>
              <div class="info-row">
                <div class="info-icon"><i class="fas fa-user"></i></div>
                <div class="info-text">
                  <div class="info-label">Nama Gembala</div>
                  <div class="info-value"><?php echo htmlspecialchars($rowCabang->namagembala, ENT_QUOTES) ?></div>
                </div>
              </div>
              <?php } ?>

              <!-- Action row -->
              <div class="action-row">
                <?php
                $mapsUrl = '#';
                if (!empty($rowCabang->latitude) && !empty($rowCabang->longitude)) {
                  $mapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . $rowCabang->latitude . ',' . $rowCabang->longitude;
                } elseif (!empty($rowCabang->alamatlengkap)) {
                  $mapsUrl = 'https://www.google.com/maps/search/' . urlencode($rowCabang->alamatlengkap);
                }
                ?>
                <a href="<?php echo $mapsUrl ?>" target="_blank" class="btn-route">
                  Dapatkan Rute <i class="fas fa-location-dot"></i>
                </a>

                <?php if (!empty($rowCabang->urlfacebook)) { ?>
                  <a href="<?php echo $rowCabang->urlfacebook ?>" target="_blank" class="social-btn" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                  </a>
                <?php } ?>
                <?php if (!empty($rowCabang->urlinstagram)) { ?>
                  <a href="<?php echo $rowCabang->urlinstagram ?>" target="_blank" class="social-btn" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                  </a>
                <?php } ?>
                <?php if (!empty($rowCabang->urlyoutube)) { ?>
                  <a href="<?php echo $rowCabang->urlyoutube ?>" target="_blank" class="social-btn" aria-label="YouTube">
                    <i class="fab fa-youtube"></i>
                  </a>
                <?php } ?>
                <?php if (!empty($rowCabang->urltwitter)) { ?>
                  <a href="<?php echo $rowCabang->urltwitter ?>" target="_blank" class="social-btn" aria-label="Twitter/X">
                    <i class="fab fa-x-twitter"></i>
                  </a>
                <?php } ?>
                <?php if (!empty($rowCabang->urllinkedin)) { ?>
                  <a href="<?php echo $rowCabang->urllinkedin ?>" target="_blank" class="social-btn" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                  </a>
                <?php } ?>
              </div>

            </div>
          </div><!-- /.location-top -->

          <!-- ===== BOTTOM ===== -->
          <?php
          $jadwal = $rowCabang->jadwalibadah ?? '';
          $jadwalItems = [];
          if (!empty($jadwal)) {
            $decoded = json_decode($jadwal, true);
            if (is_array($decoded)) {
              $jadwalItems = $decoded;
            }
          }
          ?>
          <?php if (!empty($jadwal) || !empty($rowCabang->deskripsi)) { ?>
          <div class="location-bottom">

            <!-- Jadwal Ibadah -->
            <?php if (!empty($jadwal)) { ?>
            <div class="bottom-left">
              <div class="section-title">
                <div class="title-icon"><i class="fas fa-calendar-check"></i></div>
                <h3>Jadwal Ibadah</h3>
              </div>
              <?php
              $jadwalClean = strip_tags($jadwal);
              $jadwalLines = explode("\n", $jadwalClean);
              ?>
              <ul class="schedule-list">
                <?php
                foreach ($jadwalLines as $line) {
                  $line = trim($line);
                  if (!empty($line)) {
                    $timePattern = '/(?:Pukul\s*)?(\d{2}[.:]\d{2}\s*[-–]\s*\d{2}[.:]\d{2})/';
                    preg_match($timePattern, $line, $matches);
                    $timeDisplay = '';
                    $nameDisplay = $line;
                    if (isset($matches[1])) {
                      $timeDisplay = $matches[1];
                      $nameDisplay = trim(preg_replace($timePattern, '', $line));
                      $nameDisplay = str_replace('Pukul', '', $nameDisplay);
                      $nameDisplay = trim($nameDisplay);
                    }
                    ?>
                    <li class="schedule-item">
                      <span class="schedule-name"><?php echo htmlspecialchars($nameDisplay, ENT_QUOTES); ?></span>
                      <span class="schedule-time"><?php echo $timeDisplay ?: '-'; ?></span>
                    </li>
                <?php
                  }
                }
                ?>
              </ul>
            </div>
            <?php } ?>

            <!-- Deskripsi Gereja -->
            <?php if (!empty($rowCabang->deskripsi)) { ?>
            <div class="bottom-right">
              <div class="section-title">
                <div class="title-icon"><i class="fas fa-circle-info"></i></div>
                <h3>Deskripsi Gereja</h3>
              </div>
              <div class="desc-text"><?php echo $rowCabang->deskripsi ?></div>
            </div>
            <?php } ?>

          </div>
          <?php } ?>

        </div><!-- /.location-card -->

      </div><!-- /.container -->
    </div><!-- /.page-wrapper -->

  </main>

  <?php $this->load->view('template/festavalive/footer'); ?>

  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" crossorigin="anonymous"></script>

  <script>
    $(document).ready(function () {

      // Main carousel
      $("#sync1").owlCarousel({
        items      : 1,
        slideSpeed : 600,
        nav        : true,
        dots       : true,
        loop       : true,
        autoplay   : false,
        autoHeight : false,
        navText    : [
          '<i class="fas fa-chevron-left"></i>',
          '<i class="fas fa-chevron-right"></i>'
        ],
      });

      // Fallback jika koordinat tidak ada
      var routeBtn = document.querySelector('.btn-route');
      if (routeBtn && routeBtn.getAttribute('href') === '#') {
        routeBtn.addEventListener('click', function(e) {
          e.preventDefault();
          alert('Koordinat lokasi belum tersedia.');
        });
      }

    });
  </script>

  <!-- Load cabang list di background (opsional) -->
  <script>
    var idcabang = "<?php echo $idcabang ?>";
    var idmenu   = "<?php echo $this->encrypt->encode($menu) ?>";

    function loadCabangList() {
      $.ajax({
        url      : '<?php echo site_url('ourlocation/getcabang') ?>',
        type     : 'GET',
        dataType : 'json',
      }).done(function (data) {
        // data tersedia jika sidebar diaktifkan
      }).fail(function () {
        console.log("error getcabang");
      });
    }

    $(document).ready(function () { loadCabangList(); });
  </script>

</body>