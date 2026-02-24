<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- FONTS -->
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- FontAwesome for Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* ===== GLOBAL VARIABLES ===== */
    :root {
      --primary-orange: #F59E0B; /* Warna Oranye Kuning */
      --primary-hover: #D97706;
      --text-dark: #111827;
      --text-gray: #4B5563;
      --bg-page: #F3F4F6; /* Background luar abu-abu muda */
      --bg-card: #FFFFFF;
      --bg-item: #F9FAFB; /* Background item jadwal */
      --radius-card: 24px;
      --radius-item: 12px;
    }

    *, *::before, *::after { box-sizing: border-box; }
    
    body {
      font-family: 'Figtree', sans-serif;
      background-color: #aaa;
      color: var(--text-dark);
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
    }

    img { max-width: 100%; height: auto; display: block; }
    a { text-decoration: none; color: inherit; transition: 0.3s; }

    /* ===== MAIN CONTAINER ===== */
    .page-wrapper {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }

    /* ===== CARD DESIGN ===== */
    .main-card {
      background: var(--bg-card);
      border-radius: var(--radius-card);
      box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    /* ===== TOP SECTION (Image Left, Info Right) ===== */
    .top-section {
      display: flex;
      flex-wrap: wrap;
      border-bottom: 1px solid #E5E7EB;
    }

    /* Left: Gallery */
    .gallery-col {
      flex: 1 1 400px; /* Responsive flex basis */
      position: relative;
      background: #000;
      min-height: 400px;
    }

    .gallery-col .owl-carousel {
      height: 100%;
      width: 100%;
    }
    
    .gallery-col .item {
      height: 400px; 
      width: 100%;
    }

    .gallery-col .frame {
      width: 100%;
      height: 100%;
      display: block;
    }

    .gallery-col .frame img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    /* Custom Owl Nav (Simple Arrows) */
    .gallery-col .owl-nav button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255,255,255,0.9) !important;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      color: var(--text-dark) !important;
      font-size: 16px;
      transition: 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .gallery-col .owl-nav button:hover { background: #fff !important; transform: translateY(-50%) scale(1.1); }
    .gallery-col .owl-prev { left: 20px; }
    .gallery-col .owl-next { right: 20px; }
    
    .gallery-col .owl-dots {
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 8px;
    }
    .gallery-col .owl-dot span {
      width: 8px;
      height: 8px;
      background: rgba(255,255,255,0.5);
      border-radius: 50%;
      display: block;
    }
    .gallery-col .owl-dot.active span { background: var(--primary-orange); }

    /* Right: Profile Info */
    .profile-col {
      flex: 1 1 400px;
      padding: 50px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .section-label {
      font-size: 13px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: var(--primary-orange);
      margin-bottom: 12px;
    }

    .church-title {
      font-size: 34px;
      font-weight: 800;
      color: var(--text-dark);
      margin: 0 0 30px 0;
      line-height: 1.2;
    }

    .info-list {
      list-style: none;
      padding: 0;
      margin: 0 0 35px 0;
    }

    .info-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 24px;
    }

    .info-icon {
      width: 24px;
      height: 24px;
      color: var(--primary-orange);
      margin-right: 16px;
      flex-shrink: 0;
      margin-top: 3px;
      font-size: 18px;
    }

    .info-content h4 {
      margin: 0 0 4px 0;
      font-size: 15px;
      font-weight: 700;
      color: var(--text-dark);
    }

    .info-content p {
      margin: 0;
      font-size: 15px;
      color: var(--text-gray);
      line-height: 1.6;
    }

    .action-area {
      display: flex;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
    }

    .btn-route {
      background-color: var(--primary-orange);
      color: white;
      padding: 12px 28px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: 0.3s;
      box-shadow: 0 4px 14px rgba(245, 158, 11, 0.25);
    }
    .btn-route:hover {
      background-color: var(--primary-hover);
      transform: translateY(-2px);
      color: white;
    }

    .social-btns {
      display: flex;
      gap: 12px;
    }
    .social-btn {
      width: 48px;
      height: 48px;
      background: #F3F4F6;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-dark);
      font-size: 20px;
      transition: 0.3s;
    }
    .social-btn:hover {
      background: var(--text-dark);
      color: white;
      transform: translateY(-2px);
    }

    /* ===== BOTTOM SECTION (Schedule + Desc) ===== */
    .bottom-section {
      display: flex;
      flex-wrap: wrap;
      padding: 50px 40px;
      gap: 50px;
    }

    .bottom-col {
      flex: 1 1 300px;
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 12px;
      margin-bottom: 24px;
    }

    .section-header i {
      color: var(--primary-orange);
      font-size: 22px;
    }

    .section-header h3 {
      margin: 0;
      font-size: 22px;
      font-weight: 700;
      color: var(--text-dark);
    }

    /* Schedule List Styling - Exact Match */
    .schedule-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .schedule-item {
      background: var(--bg-item);
      padding: 18px 24px;
      border-radius: var(--radius-item);
      margin-bottom: 16px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: 0.2s;
      border: 1px solid transparent;
    }
    .schedule-item:hover {
      border-color: rgba(245, 158, 11, 0.3);
      background: #fff;
      box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }

    .schedule-name {
      font-weight: 600;
      color: var(--text-dark);
      font-size: 15px;
    }

    .schedule-time {
      font-weight: 700;
      color: var(--primary-orange);
      font-size: 14px;
      background: rgba(245, 158, 11, 0.08); /* Light orange bg */
      padding: 6px 12px;
      border-radius: 8px;
    }

    /* Description Text */
    .desc-text {
      color: var(--text-gray);
      font-size: 15px;
      line-height: 1.8;
      text-align: justify;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
      .top-section { flex-direction: column; }
      .gallery-col { min-height: 300px; }
      .gallery-col .item { height: 300px; }
      .profile-col { padding: 40px 30px; }
    }

    @media (max-width: 768px) {
      .page-wrapper { margin: 20px auto; padding: 0 15px; }
      .bottom-section { padding: 30px 20px; flex-direction: column; gap: 40px; }
      .church-title { font-size: 26px; }
      .profile-col { padding: 30px 20px; }
    }
  </style>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <div class="page-wrapper">
      <div class="main-card">
        
        <!-- TOP ROW: Image & Profile Info -->
        <div class="top-section">
          
          <!-- Left: Gallery (Synced Carousel) -->
          <div class="gallery-col">
            <div id="sync1" class="owl-carousel owl-theme">
              <?php
                $gambarsampul = base_url('myesc.id/images/nofoto.png');
                if (!empty($rowCabang->gambarsampul)) {
                  $gambarsampul = base_url('myesc.id/admin/uploads/cabanggereja/' . $rowCabang->gambarsampul);
                }
              ?>
              <!-- Item 1: Sampul -->
              <div class="item">
                <span class="frame">
                  <img src="<?php echo $gambarsampul ?>" alt="Gereja">
                </span>
              </div>
              
              <!-- Items: Gallery -->
              <?php if ($rsGallery->num_rows() > 0) { foreach ($rsGallery->result() as $rowGallery) { 
                  $filegallery = base_url('myesc.id/images/nofoto.png');
                  if (!empty($rowGallery->filegallery)) {
                    $filegallery = base_url('myesc.id/admin/uploads/cabanggereja/gallery/' . $rowGallery->filegallery);
              ?>
                <div class="item">
                  <span class="frame">
                    <img src="<?php echo $filegallery ?>" alt="Gallery">
                  </span>
                </div>
              <?php } } } ?>
            </div>
          </div>

          <!-- Right: Profile Info -->
          <div class="profile-col">
            <div class="section-label">Location Profile</div>
            <h1 class="church-title"><?php echo $rowCabang->namacabang ?></h1>

            <ul class="info-list">
              <!-- Alamat -->
              <li class="info-item">
                <i class="fas fa-map-marker-alt info-icon"></i>
                <div class="info-content">
                  <h4>Alamat Gereja</h4>
                  <p><?php echo $rowCabang->alamatlengkap ?></p>
                </div>
              </li>

              <!-- Telepon -->
              <li class="info-item">
                <i class="fas fa-phone-alt info-icon"></i>
                <div class="info-content">
                  <h4>No Telepon</h4>
                  <p><?php echo $rowCabang->notelp ?></p>
                </div>
              </li>

              <!-- Gembala -->
              <li class="info-item">
                <i class="fas fa-user-tie info-icon"></i>
                <div class="info-content">
                  <h4>Nama Gembala</h4>
                  <p><?php echo $rowCabang->namagembala ?></p>
                </div>
              </li>
            </ul>

            <div class="action-area">
              <!-- Link Google Maps Dinamis -->
              <a href="https://maps.google.com/?q=<?php echo urlencode($rowCabang->alamatlengkap) ?>" target="_blank" class="btn-route">
                Dapatkan Rute <i class="fas fa-location-arrow"></i>
              </a>
              
              <div class="social-btns">
                <?php if (!empty($rowCabang->urlinstagram)) { ?>
                  <a href="<?php echo $rowCabang->urlinstagram ?>" target="_blank" class="social-btn"><i class="fab fa-instagram"></i></a>
                <?php } ?>
                <?php if (!empty($rowCabang->urlyoutube)) { ?>
                  <a href="<?php echo $rowCabang->urlyoutube ?>" target="_blank" class="social-btn"><i class="fab fa-youtube"></i></a>
                <?php } ?>
                <?php if (!empty($rowCabang->urlfacebook)) { ?>
                  <a href="<?php echo $rowCabang->urlfacebook ?>" target="_blank" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <!-- BOTTOM ROW: Schedule & Description -->
        <div class="bottom-section">
          
          <!-- Left: Jadwal Ibadah -->
          <div class="bottom-col">
            <div class="section-header">
              <i class="far fa-calendar-alt"></i>
              <h3>Jadwal Ibadah</h3>
            </div>
            
            <div class="schedule-list">
              <?php
              // Ambil data jadwal dari database
              $jadwalText = $rowCabang->jadwalibadah;
              
              // Pisahkan teks berdasarkan baris baru (Enter)
              $jadwalLines = explode("\n", $jadwalText);

              foreach ($jadwalLines as $line) {
                  $line = trim($line); // Hapus spasi berlebih
                  if (!empty($line)) {
                      // Opsional: Coba pisahkan Jam secara otomatis jika ada pola angka
                      // Regex ini mencari pola jam seperti 07.30 - 09.00
                      $timePattern = '/(\d{2}\.\d{2}\s*-\s*\d{2}\.\d{2})/';
                      preg_match($timePattern, $line, $matches);
                      
                      $timeDisplay = '';
                      $nameDisplay = $line;

                      if (isset($matches[1])) {
                          $timeDisplay = $matches[1];
                          // Hapus jam dari nama ibadah agar tidak dobel
                          $nameDisplay = trim(preg_replace($timePattern, '', $line));
                      }
                      ?>
                      <!-- Tampilan Kotak Jadwal -->
                      <div class="schedule-item">
                          <span class="schedule-name"><?php echo $nameDisplay; ?></span>
                          <?php if($timeDisplay): ?>
                              <span class="schedule-time"><?php echo $timeDisplay; ?></span>
                          <?php endif; ?>
                      </div>
                      <?php
                  }
              }
              ?>
            </div>
          </div>

          <!-- Right: Deskripsi Gereja -->
          <div class="bottom-col">
            <div class="section-header">
              <i class="far fa-info-circle"></i>
              <h3>Deskripsi Gereja</h3>
            </div>
            
            <div class="desc-text">
              <?php if (!empty($rowCabang->deskripsi)) { 
                  echo $rowCabang->deskripsi; 
              } else { ?>
                <p>GBI El Shaddai Pontianak adalah tempat di mana perjalanan pelayanan El Shaddai dimulai dan terus berkembang sejak tahun 2009. Lokasi ini digembalakan oleh Ps. Yehezkiel Wilan dan Ps. Sandra.</p>
                <p>Visi kami adalah membawa kemuliaan Tuhan ke seluruh kota melalui ibadah yang transformatif, komunitas yang sehat, dan pelayanan yang berdampak. Kami mengundang Anda untuk bergabung bersama kami dalam ibadah setiap hari Minggu.</p>
              <?php } ?>
            </div>
          </div>

        </div>

      </div>
    </div>

    <!-- Hidden List for AJAX Logic (Fungsi Asli Dipertahankan) -->
    <div style="display:none;">
        <div id="divContentCabang">
          <ul id="ulCabang" class="ulCabang"></ul>
        </div>
    </div>

  </main>

  <?php $this->load->view('template/festavalive/footer'); ?>

  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    $(document).ready(function() {
      // Synced Carousel Logic (Dipertahankan)
      var sync1 = $("#sync1");
      
      // Inisialisasi Sync1 (Main Image)
      sync1.owlCarousel({
        items: 1,
        slideSpeed: 600,
        nav: true,
        center: false, 
        autoplay: true,
        dots: true,
        loop: true,
        autoHeight: false,
        responsiveRefreshRate: 200,
        navText: [
          '<i class="fas fa-chevron-left"></i>',
          '<i class="fas fa-chevron-right"></i>'
        ],
      });

      // Fungsi AJAX List Cabang (Dipertahankan)
      var idcabang = "<?php echo $idcabang ?>";
      var idmenu = "<?php echo $this->encrypt->encode($menu) ?>";

      function initMap() {
        $.ajax({
            url: '<?php echo site_url('ourlocation/getcabang') ?>',
            type: 'GET',
            dataType: 'json',
          })
          .done(function(getcabangresult) {
            var dataCabang = getcabangresult;
            $('#ulCabang').empty();

            if (dataCabang && dataCabang.length > 0) {
              for (var i = dataCabang.length - 1; i >= 0; i--) {
                if (idcabang != dataCabang[i]['idcabang']) {
                  var addText = `<li><a href="<?php echo site_url('ourlocation/detail/') ?>${dataCabang[i]['namacabang_slug']}/${idmenu}">${dataCabang[i]['namacabang']}</a></li>`;
                  $('#ulCabang').append(addText);
                } else {
                  var addText = `<li><span>${dataCabang[i]['namacabang']}</span></li>`;
                  $('#ulCabang').append(addText);
                }
              }
            }
          })
          .fail(function() { console.log("error getcabang"); });
      }
      
      initMap();
    });
  </script>

</body>
</html>