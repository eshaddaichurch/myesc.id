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
    /* ===== GLOBAL VARIABLES & RESET ===== */
    :root {
      --primary-orange: #F59E0B; /* Warna Oranye seperti gambar */
      --primary-hover: #D97706;
      --text-dark: #111827;
      --text-gray: #6B7280;
      --bg-light: #F3F4F6;
      --white: #ffffff;
      --radius-card: 24px;
      --radius-btn: 12px;
    }

    *, *::before, *::after { box-sizing: border-box; }
    
    body {
      font-family: 'Figtree', sans-serif;
      background-color: var(--bg-light);
      color: var(--text-dark);
      margin: 0;
      padding: 0;
      -webkit-font-smoothing: antialiased;
    }

    img { max-width: 100%; height: auto; display: block; }
    a { text-decoration: none; color: inherit; transition: 0.3s; }

    /* ===== LAYOUT WRAPPER ===== */
    .page-wrapper {
      max-width: 1100px;
      margin: 40px auto;
      padding: 0 20px;
    }

    /* ===== MAIN CARD DESIGN ===== */
    .profile-card {
      background: var(--white);
      border-radius: var(--radius-card);
      box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08);
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    /* ===== TOP SECTION (Image + Profile Info) ===== */
    .top-section {
      display: flex;
      flex-wrap: wrap;
      border-bottom: 1px solid #E5E7EB;
    }

    /* Left: Gallery */
    .gallery-col {
      flex: 1 1 400px;
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

    /* Custom Owl Nav */
    .gallery-col .owl-nav button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255,255,255,0.8) !important;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      color: var(--text-dark) !important;
      font-size: 18px;
      transition: 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .gallery-col .owl-nav button:hover { background: #fff !important; }
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
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .section-label {
      font-size: 12px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--primary-orange);
      margin-bottom: 8px;
    }

    .church-title {
      font-size: 32px;
      font-weight: 700;
      color: var(--text-dark);
      margin: 0 0 30px 0;
      line-height: 1.2;
    }

    .info-list {
      list-style: none;
      padding: 0;
      margin: 0 0 30px 0;
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
      margin-top: 2px;
    }

    .info-content h4 {
      margin: 0 0 4px 0;
      font-size: 16px;
      font-weight: 600;
      color: var(--text-dark);
    }

    .info-content p {
      margin: 0;
      font-size: 15px;
      color: var(--text-gray);
      line-height: 1.5;
    }

    .action-area {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .btn-route {
      background-color: var(--primary-orange);
      color: white;
      padding: 12px 24px;
      border-radius: var(--radius-btn);
      font-weight: 600;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      transition: 0.3s;
      box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
    }
    .btn-route:hover {
      background-color: var(--primary-hover);
      transform: translateY(-2px);
      color: white;
    }

    .social-btns {
      display: flex;
      gap: 10px;
    }
    .social-btn {
      width: 44px;
      height: 44px;
      background: #F3F4F6;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-dark);
      font-size: 18px;
      transition: 0.3s;
    }
    .social-btn:hover {
      background: var(--text-dark);
      color: white;
    }

    /* ===== BOTTOM SECTION (Schedule + Desc) ===== */
    .bottom-section {
      display: flex;
      flex-wrap: wrap;
      padding: 40px;
      gap: 40px;
    }

    .bottom-col {
      flex: 1 1 300px;
    }

    .section-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .section-header i {
      color: var(--primary-orange);
      font-size: 20px;
    }

    .section-header h3 {
      margin: 0;
      font-size: 20px;
      font-weight: 700;
      color: var(--text-dark);
    }

    /* Schedule List Styling */
    .schedule-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .schedule-item {
      background: #F9FAFB;
      border: 1px solid #F3F4F6;
      padding: 16px 20px;
      border-radius: 12px;
      margin-bottom: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: 0.2s;
    }
    .schedule-item:hover {
      border-color: var(--primary-orange);
      background: #FFFBEB;
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
      background: rgba(245, 158, 11, 0.1);
      padding: 4px 10px;
      border-radius: 6px;
    }

    /* Description Text */
    .desc-text {
      color: var(--text-gray);
      font-size: 15px;
      line-height: 1.7;
      text-align: justify;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .page-wrapper { margin: 20px auto; padding: 0 15px; }
      .top-section { flex-direction: column; }
      .gallery-col { min-height: 250px; }
      .gallery-col .item { height: 250px; }
      .profile-col { padding: 30px 20px; }
      .bottom-section { padding: 30px 20px; flex-direction: column; gap: 30px; }
      .church-title { font-size: 24px; }
    }

    /* Utility for old code compatibility if needed */
    .hidden { display: none; }
  </style>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <div class="page-wrapper">
      <div class="profile-card">
        
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
                <?php if (!empty($rowCabang->urltwitter)) { ?>
                  <a href="<?php echo $rowCabang->urltwitter ?>" target="_blank" class="social-btn"><i class="fab fa-twitter"></i></a>
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
              <!-- 
                 CATATAN: Karena database Anda menyimpan jadwal dalam satu field teks ($rowCabang->jadwalibadah),
                 saya menampilkannya di sini. Agar mirip gambar, idealnya data di database dipisah per baris.
                 Jika data di database sudah berisi HTML <br> atau list, ini akan muncul rapi.
              -->
              <?php 
                // Contoh hardcoded sesuai gambar jika data database kosong atau ingin dipaksa tampil seperti gambar:
                // Hapus komentar di bawah jika ingin硬coding tampilan seperti gambar referensi
                /*
                ?>
                <div class="schedule-item">
                  <span class="schedule-name">Ibadah Raya 1</span>
                  <span class="schedule-time">07.30 - 09.00</span>
                </div>
                <div class="schedule-item">
                  <span class="schedule-name">Ibadah Raya 2</span>
                  <span class="schedule-time">10.30 - 12.00</span>
                </div>
                <div class="schedule-item">
                  <span class="schedule-name">Ibadah Raya 3</span>
                  <span class="schedule-time">16.00 - 17.30</span>
                </div>
                <div class="schedule-item">
                  <span class="schedule-name">Ibadah Raya 4</span>
                  <span class="schedule-time">19.00 - 21.00</span>
                </div>
                <?php 
                */
                
                // Tampilan Dinamis dari Database
                echo '<div style="color:var(--text-gray); line-height:1.6;">' . nl2br($rowCabang->jadwalibadah) . '</div>';
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
                <p>GBI El Shaddai Pontianak adalah tempat di mana perjalanan pelayanan El Shaddai dimulai dan terus berkembang. Kami mengundang Anda untuk bergabung bersama kami dalam ibadah setiap hari Minggu.</p>
              <?php } ?>
            </div>
          </div>

        </div>

      </div>
    </div>

    <!-- Sidebar List Cabang (Fungsi Asli Dipertahankan tapi disembunyikan secara visual agar sesuai desain kartu, 
         atau bisa dimunculkan di bawah jika diperlukan) -->
    <div class="hidden">
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
      var sync2 = $("#sync2"); // Note: sync2 thumbnails dihapus dari HTML atas agar lebih clean seperti gambar, 
                               // tapi script ini tetap ada jika Anda ingin mengaktifkannya kembali nanti.
      
      // Inisialisasi Sync1 (Main Image)
      sync1.owlCarousel({
        items: 1,
        slideSpeed: 600,
        nav: true,
        center: false, // Diubah false agar full width
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