<?php $this->load->view('template/festavalive/header'); ?>

<body class="bg-gray-50 text-gray-800 antialiased">

  <!-- TAILWIND CSS & FONTS -->
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  
  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* Custom Brand Colors */
    :root {
      --brand-orange: #f59e0b; 
      --brand-orange-light: #fef3c7; 
    }
    body { font-family: 'Inter', sans-serif; }
    
    .text-brand { color: var(--brand-orange); }
    .bg-brand { background-color: var(--brand-orange); }
    .hover-bg-brand:hover { background-color: #d97706; }
    .bg-brand-light { background-color: rgba(245, 158, 11, 0.1); }
    
    /* Owl Carousel Overrides */
    #sync1.owl-carousel, #sync1 .owl-stage-outer, #sync1 .owl-item, #sync1 .item {
      height: 100%;
      width: 100%;
    }
    #sync1 .frame {
      width: 100%;
      height: 100%;
      display: block;
    }
    #sync1 .frame img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    /* Styling Nav Owl */
    #sync1 .owl-nav button {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255,255,255,0.8) !important;
      width: 48px;
      height: 48px;
      border-radius: 50%;
      color: #1f2937 !important;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
      z-index: 10;
    }
    #sync1 .owl-nav button:hover { background: #fff !important; transform: translateY(-50%) scale(1.1); }
    #sync1 .owl-prev { left: 20px; }
    #sync1 .owl-next { right: 20px; }
    
    #sync1 .owl-dots {
      position: absolute;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 8px;
      z-index: 10;
    }
    #sync1 .owl-dot span {
      width: 12px;
      height: 12px;
      background: rgba(255,255,255,0.5);
      border-radius: 50%;
      display: block;
    }
    #sync1 .owl-dot.active span { background: var(--brand-orange); }
  </style>

  <!-- Navbar / Topmenu -->
  <?php $this->load->view('template/festavalive/topmenu'); ?>

  <!-- Main Content Wrapper (bukan tag <main> agar tidak konflik) -->
  <div class="max-w-6xl mx-auto px-4 py-12 md:py-20">
    
    <!-- Main Card Container -->
    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
      
      <!-- BEGIN: HeroSection (Top Half) -->
      <section class="grid grid-cols-1 lg:grid-cols-2 gap-0">
        
        <!-- Left: Image Gallery (Owl Carousel) -->
        <div class="relative bg-gray-100 aspect-video lg:aspect-auto h-full min-h-[400px]">
          <div id="sync1" class="owl-carousel owl-theme h-full w-full">
            <?php
              $gambarsampul = base_url('myesc.id/images/nofoto.png');
              if (!empty($rowCabang->gambarsampul)) {
                $gambarsampul = base_url('myesc.id/admin/uploads/cabanggereja/' . $rowCabang->gambarsampul);
              }
            ?>
            <!-- Item 1: Sampul -->
            <div class="item">
              <span class="frame">
                <img src="<?php echo $gambarsampul ?>" alt="<?php echo $rowCabang->namacabang ?>">
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

        <!-- Right: Primary Details -->
        <div class="p-8 md:p-12 flex flex-col justify-center">
          <nav class="mb-6">
            <span class="text-sm font-semibold tracking-widest text-brand uppercase">Location Profile</span>
          </nav>
          <h1 class="text-3xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
            <?php echo $rowCabang->namacabang ?>
          </h1>

          <div class="space-y-6">
            <!-- Address Item -->
            <div class="flex items-start space-x-4">
              <div class="bg-brand-light p-2 rounded-lg">
                <svg class="h-6 w-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">Alamat Gereja</h4>
                <p class="text-gray-600 leading-relaxed"><?php echo $rowCabang->alamatlengkap ?></p>
              </div>
            </div>

            <!-- Contact Item -->
            <div class="flex items-start space-x-4">
              <div class="bg-brand-light p-2 rounded-lg">
                <svg class="h-6 w-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">No Telepon</h4>
                <p class="text-gray-600"><?php echo $rowCabang->notelp ?></p>
              </div>
            </div>

            <!-- Pastor Item -->
            <div class="flex items-start space-x-4">
              <div class="bg-brand-light p-2 rounded-lg">
                <svg class="h-6 w-6 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
              </div>
              <div>
                <h4 class="font-semibold text-gray-900">Nama Gembala</h4>
                <p class="text-gray-600"><?php echo $rowCabang->namagembala ?></p>
              </div>
            </div>
          </div>

          <!-- Interaction Row -->
          <div class="mt-10 flex flex-wrap gap-4">
            <a href="https://maps.google.com/?q=<?php echo urlencode($rowCabang->alamatlengkap) ?>" target="_blank" class="bg-brand text-white px-8 py-3 rounded-xl font-semibold shadow-lg shadow-orange-200 hover:bg-orange-600 transition-all flex items-center space-x-2">
              <span>Dapatkan Rute</span>
              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </a>
            
            <div class="flex items-center space-x-3">
              <?php if (!empty($rowCabang->urlinstagram)) { ?>
              <a href="<?php echo $rowCabang->urlinstagram ?>" target="_blank" class="p-3 bg-gray-100 rounded-xl hover:bg-brand/10 hover:text-brand transition-all text-gray-600">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
              </a>
              <?php } ?>
              <?php if (!empty($rowCabang->urlyoutube)) { ?>
              <a href="<?php echo $rowCabang->urlyoutube ?>" target="_blank" class="p-3 bg-gray-100 rounded-xl hover:bg-brand/10 hover:text-brand transition-all text-gray-600">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.612 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path></svg>
              </a>
              <?php } ?>
            </div>
          </div>
        </div>
      </section>
      <!-- END: HeroSection -->

      <!-- BEGIN: ContentDetails (Bottom Half) -->
      <section class="p-8 md:p-12 bg-white border-t border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
          
          <!-- Schedule Column -->
          <div>
            <div class="flex items-center space-x-3 mb-6">
              <span class="bg-brand-light p-2 rounded-lg text-brand">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
              </span>
              <h2 class="text-2xl font-bold text-gray-900">Jadwal Ibadah</h2>
            </div>
            
            <div class="space-y-4">
              <?php
              $jadwalText = $rowCabang->jadwalibadah;
              $jadwalLines = explode("\n", $jadwalText);

              foreach ($jadwalLines as $line) {
                  $line = trim($line);
                  if (!empty($line)) {
                      $timePattern = '/(\d{2}\.\d{2}\s*-\s*\d{2}\.\d{2})/';
                      preg_match($timePattern, $line, $matches);
                      
                      $timeDisplay = '';
                      $nameDisplay = $line;

                      if (isset($matches[1])) {
                          $timeDisplay = $matches[1];
                          $nameDisplay = trim(preg_replace($timePattern, '', $line));
                      }
                      ?>
                      <div class="flex justify-between items-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                        <span class="font-semibold text-gray-700"><?php echo $nameDisplay; ?></span>
                        <?php if($timeDisplay): ?>
                            <span class="bg-brand-light text-brand px-4 py-1 rounded-full text-sm font-bold"><?php echo $timeDisplay; ?></span>
                        <?php endif; ?>
                      </div>
                      <?php
                  }
              }
              ?>
            </div>
          </div>

          <!-- Description Column -->
          <div>
            <div class="flex items-center space-x-3 mb-6">
              <span class="bg-brand-light p-2 rounded-lg text-brand">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
              </span>
              <h2 class="text-2xl font-bold text-gray-900">Deskripsi Gereja</h2>
            </div>
            <div class="prose prose-orange max-w-none text-gray-600 leading-relaxed space-y-4">
              <?php if (!empty($rowCabang->deskripsi)) { 
                  echo nl2br($rowCabang->deskripsi); 
              } else { ?>
                <p>GBI El Shaddai Pontianak adalah tempat di mana perjalanan pelayanan El Shaddai dimulai dan terus berkembang sejak tahun 2009. Lokasi ini digembalakan oleh Ps. Yehezkiel Wilan dan Ps. Sandra.</p>
                <p>Visi kami adalah membawa kemuliaan Tuhan ke seluruh kota melalui ibadah yang transformatif, komunitas yang sehat, dan pelayanan yang berdampak. Kami mengundang Anda untuk bergabung bersama kami dalam ibadah setiap hari Minggu.</p>
              <?php } ?>
            </div>
          </div>

        </div>
      </section>
      <!-- END: ContentDetails -->

    </div>
  </div>

  <?php $this->load->view('template/festavalive/footer'); ?>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
  <script>
    $(document).ready(function() {
      // Owl Carousel Init
      $("#sync1").owlCarousel({
        items: 1,
        slideSpeed: 600,
        nav: true,
        center: false,
        autoplay: true,
        dots: true,
        loop: true,
        autoHeight: false,
        navText: [
          '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>',
          '<svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>'
        ],
      });

      // AJAX List Cabang
      var idcabang = "<?php echo $idcabang ?>";
      var idmenu = "<?php echo $this->encrypt->encode($menu) ?>";

      function initMap() {
        $.ajax({
            url: '<?php echo site_url('ourlocation/getcabang') ?>',
            type: 'GET',
            dataType: 'json',
          })
          .done(function(getcabangresult) {
            console.log("Cabang loaded");
          })
          .fail(function() { console.log("error getcabang"); });
      }
      initMap();
    });
  </script>

</body>
</html>