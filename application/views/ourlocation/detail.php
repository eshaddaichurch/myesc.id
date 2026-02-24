<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- FONTS -->
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* ===== RESET & BASE ===== */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; width: 100%; }
    body {
      font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
      background: #f0f2f5;
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
      padding: 80px 0 60px;
    }

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
      background: #1a1a2e;
      border-radius: 24px 0 0 0;
      overflow: hidden;
    }

    /* Main carousel */
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

    /* Dots */
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
      background: #F59E0B;
      transform: scale(1.2);
    }

    /* ---- INFO SIDE ---- */
    .info-side {
      flex: 0 0 46%;
      max-width: 46%;
      padding: 36px 36px 32px 36px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .location-label {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: #F59E0B;
      margin-bottom: 10px;
    }

    .location-name {
      font-size: 2rem;
      font-weight: 800;
      color: #0f172a;
      line-height: 1.15;
      margin-bottom: 24px;
      font-family: 'Baloo 2', cursive;
    }

    /* Info rows */
    .info-row {
      display: flex;
      align-items: flex-start;
      gap: 14px;
      margin-bottom: 18px;
    }
    .info-row:last-of-type { margin-bottom: 0; }
    .info-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #FEF3C7;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      margin-top: 2px;
    }
    .info-icon i {
      font-size: 15px;
      color: #D97706;
    }
    .info-text .info-label {
      font-size: 13px;
      font-weight: 700;
      color: #374151;
      margin-bottom: 2px;
    }
    .info-text .info-value {
      font-size: 14px;
      color: #4B5563;
      line-height: 1.5;
    }

    /* Action row */
    .action-row {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-top: 28px;
    }

    .btn-route {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #F59E0B;
      color: #fff;
      font-weight: 700;
      font-size: 14px;
      padding: 12px 22px;
      border-radius: 12px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: background .2s, transform .15s;
      box-shadow: 0 4px 14px rgba(245,158,11,0.35);
    }
    .btn-route:hover {
      background: #D97706;
      transform: translateY(-1px);
      color: #fff;
    }
    .btn-route i { font-size: 13px; }

    .social-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      border-radius: 12px;
      background: #F9FAFB;
      border: 1.5px solid #E5E7EB;
      color: #374151;
      font-size: 18px;
      transition: background .2s, transform .15s, border-color .2s;
      text-decoration: none;
    }
    .social-btn:hover {
      background: #FEF3C7;
      border-color: #FCD34D;
      color: #D97706;
      transform: translateY(-2px);
    }

    /* ===== BOTTOM SECTION: schedule + description ===== */
    .location-bottom {
      border-top: 1px solid #F3F4F6;
      display: flex;
      flex-wrap: wrap;
      padding: 36px;
      gap: 36px;
    }

    .bottom-left { flex: 1; min-width: 260px; }
    .bottom-right { flex: 1; min-width: 260px; }

    .section-title {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
    }
    .section-title .title-icon {
      width: 38px;
      height: 38px;
      border-radius: 10px;
      background: #FEF3C7;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .section-title .title-icon i {
      color: #D97706;
      font-size: 16px;
    }
    .section-title h3 {
      font-size: 1.15rem;
      font-weight: 800;
      color: #0f172a;
    }

    /* Schedule table */
    .schedule-list { list-style: none; padding: 0; margin: 0; }
    .schedule-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 14px 18px;
      border-radius: 10px;
      background: #F9FAFB;
      margin-bottom: 10px;
      transition: background .2s;
    }
    .schedule-item:last-child { margin-bottom: 0; }
    .schedule-item:hover { background: #FEF9EC; }
    .schedule-name {
      font-size: 14px;
      font-weight: 600;
      color: #374151;
    }
    .schedule-time {
      font-size: 14px;
      font-weight: 700;
      color: #F59E0B;
    }

    /* Description */
    .desc-text {
      font-size: 14px;
      line-height: 1.75;
      color: #4B5563;
    }
    .desc-text p { margin-bottom: 12px; }
    .desc-text p:last-child { margin-bottom: 0; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .page-wrapper { padding: 70px 12px 40px; }
      .location-top { flex-direction: column; }
      .carousel-side, .info-side {
        flex: 0 0 100%;
        max-width: 100%;
      }
      .carousel-side { border-radius: 24px 24px 0 0; }
      #sync1 .frame { height: 260px; }
      .info-side { padding: 24px 20px; }
      .location-name { font-size: 1.5rem; }
      .location-bottom { padding: 24px 20px; flex-direction: column; gap: 28px; }
    }
  </style>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <div class="page-wrapper">
      <div class="container">

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
                    <img src="<?php echo $gambarsampul ?>" loading="lazy" alt="<?php echo htmlspecialchars($rowCabang->namacabang, ENT_QUOTES) ?>">
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
                          <img src="<?php echo $filegallery ?>" loading="lazy" alt="<?php echo htmlspecialchars($rowCabang->namacabang, ENT_QUOTES) ?>">
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
                <!-- Dapatkan Rute: link ke Google Maps jika ada koordinat, atau fallback search -->
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
                  <a href="<?php echo $rowCabang->urlfacebook ?>" target="_blank" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <?php } ?>
                <?php if (!empty($rowCabang->urlinstagram)) { ?>
                  <a href="<?php echo $rowCabang->urlinstagram ?>" target="_blank" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <?php } ?>
                <?php if (!empty($rowCabang->urlyoutube)) { ?>
                  <a href="<?php echo $rowCabang->urlyoutube ?>" target="_blank" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                <?php } ?>
                <?php if (!empty($rowCabang->urltwitter)) { ?>
                  <a href="<?php echo $rowCabang->urltwitter ?>" target="_blank" class="social-btn" aria-label="Twitter/X"><i class="fab fa-x-twitter"></i></a>
                <?php } ?>
                <?php if (!empty($rowCabang->urllinkedin)) { ?>
                  <a href="<?php echo $rowCabang->urllinkedin ?>" target="_blank" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <?php } ?>
              </div>

            </div>
          </div>

          <!-- ===== BOTTOM ===== -->
          <?php
            // Parse jadwal ibadah – support JSON array or plain text
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

              <?php if (!empty($jadwalItems)) { ?>
                <!-- JSON array format -->
                <ul class="schedule-list">
                  <?php foreach ($jadwalItems as $item) { ?>
                  <li class="schedule-item">
                    <span class="schedule-name"><?php echo htmlspecialchars($item['nama'] ?? $item['name'] ?? '', ENT_QUOTES) ?></span>
                    <span class="schedule-time"><?php echo htmlspecialchars($item['waktu'] ?? $item['time'] ?? '', ENT_QUOTES) ?></span>
                  </li>
                  <?php } ?>
                </ul>
              <?php } else { ?>
                <!-- Plain text format -->
                <div class="desc-text"><?php echo nl2br(htmlspecialchars($jadwal, ENT_QUOTES)) ?></div>
              <?php } ?>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    $(document).ready(function () {

      // ---- Main carousel ----
      var sync1 = $("#sync1");

      sync1.owlCarousel({
        items       : 1,
        slideSpeed  : 600,
        nav         : true,
        dots        : true,
        loop        : true,
        autoplay    : false,
        autoHeight  : false,
        navText: [
          '<i class="fas fa-chevron-left"></i>',
          '<i class="fas fa-chevron-right"></i>'
        ],
      });

      // ---- Route button fallback (jika koordinat tidak ada di backend) ----
      var routeBtn = document.querySelector('.btn-route');
      if (routeBtn && routeBtn.getAttribute('href') === '#') {
        routeBtn.addEventListener('click', function(e) {
          e.preventDefault();
          alert('Koordinat lokasi belum tersedia.');
        });
      }
    });
  </script>

  <!-- Cabang list (sidebar opsional, diload di background) -->
  <script>
    var idcabang = "<?php echo $idcabang ?>";
    var idmenu   = "<?php echo $this->encrypt->encode($menu) ?>";

    function loadCabangList() {
      $.ajax({
        url      : '<?php echo site_url("ourlocation/getcabang") ?>',
        type     : 'GET',
        dataType : 'json',
      }).done(function (data) {
        // data tersedia untuk digunakan jika sidebar diaktifkan
      }).fail(function () {
        console.log("error getcabang");
      });
    }

    $(document).ready(function () { loadCabangList(); });
  </script>

</body>
</html>