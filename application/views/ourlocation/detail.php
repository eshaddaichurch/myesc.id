<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- FONTS -->
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* ===== GLOBAL STYLE ===== */
    *, *::before, *::after { box-sizing: border-box; }
    html, body { height: 100%; width: 100%; }
    body {
      font-family: 'Figtree', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(63deg, #fffaf5, #ffb347);
      color: #111827;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    img { max-width: 100%; height: auto; display: block; }
    a, a:hover { text-decoration: none; }

    /* HERO */
    #hero {
      width: 100%;
      min-height: 60vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background: linear-gradient(63deg, #ffb347, #ffcc33);
      color: #fff;
      padding: 2rem 1.5rem;
      background-size: cover;
      background-position: center;
    }

    .page-content.section-padding { padding: 2.2rem 0 3.2rem; }
    .card { background: #fff; border-radius: 14px; box-shadow: 0 8px 30px rgba(16,24,40,0.06); border: none; width:100%; }
    .card .card-body { padding:1.25rem; }
    .detail-title { font-size: 1.5rem; font-weight:700; margin-bottom:.6rem; color:#0f172a; }

    /* GALLERY */
    #sync1 .frame {
      width: 100%;
      aspect-ratio: 4 / 3;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 18px rgba(15,23,42,0.08);
      background: #f4f4f5;
    }
    #sync1 .frame img { width:100%; height:100%; object-fit: scale-down; }

    #sync2 .thumb {
      width: 100%;
      max-width: 110px;
      aspect-ratio: 1 / 1;
      border-radius: 8px;
      overflow: hidden;
      background: #f4f4f5;
      opacity: .95;
      transition: all .2s ease;
    }
    #sync2 .thumb img { width:100%; height:100%; object-fit: cover; }
    #sync2 .owl-item.current .thumb { transform: scale(1.03); box-shadow: 0 10px 20px rgba(15,23,42,0.12); opacity:1; }

    /* INFO */
    .detail-cabang { padding-top:10px; padding-bottom:18px; }
    .detail-cabang .detail-label { font-weight:600; color:#6b7280; }
    .detail-cabang .detail-value { font-weight:600; color:#0f172a; margin-top:4px; word-break:break-word; }

    /* SOCIAL ICONS */
    .social-area { display:flex; justify-content:center; gap:.9rem; margin-top:1rem; }
    .social-area a {
      display:inline-flex; align-items:center; justify-content:center;
      width:48px; height:48px; border-radius:12px; background:rgba(0,0,0,0.03);
      transition: transform .15s ease; font-size:1.15rem; color:inherit;
    }
    .social-area a:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(2,6,23,0.08); }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .card { border-radius: 20px; }
      .detail-title { font-size: 1.25rem; }
    }
  </style>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <!-- Hero -->
    <section id="hero" aria-label="hero">
      <div class="container text-center">
        <h1><?php echo $rowCabang->namacabang ?></h1>
        <h5><?php echo !empty($rowCabang->keterangan_singkat) ? $rowCabang->keterangan_singkat : ''; ?></h5>
      </div>
    </section>

    <!-- Main Content -->
    <section class="page-content section-padding" aria-labelledby="our-location">
      <div class="container">
        <div class="row justify-content-center">

          <div class="col-md-9">
            <div class="card">
              <div class="card-body min-h-lg">

                <div class="text-center mb-4">
                  <h2 class="detail-title"><?php echo $rowCabang->namacabang ?></h2>
                </div>

                <div class="row">
                  <!-- Gallery -->
                  <div class="col-md-4 gallery">
                    <?php
                      $gambarsampul = base_url('myesc.id/images/nofoto.png');
                      if (!empty($rowCabang->gambarsampul)) {
                        $gambarsampul = base_url('myesc.id/admin/uploads/cabanggereja/' . $rowCabang->gambarsampul);
                      }
                    ?>
                    <div id="sync1" class="owl-carousel owl-theme">
                      <div class="item">
                        <span class="frame"><img src="<?php echo $gambarsampul ?>" alt="<?php echo $rowCabang->namacabang ?>"></span>
                      </div>
                      <?php if ($rsGallery->num_rows() > 0): foreach ($rsGallery->result() as $rowGallery): 
                        if (!empty($rowGallery->filegallery)): ?>
                          <div class="item">
                            <span class="frame">
                              <img src="<?php echo base_url('myesc.id/admin/uploads/cabanggereja/gallery/' . $rowGallery->filegallery) ?>" alt="">
                            </span>
                          </div>
                      <?php endif; endforeach; endif; ?>
                    </div>

                    <!-- Thumbnails -->
                    <div class="thumbs-clip">
                      <div id="sync2" class="owl-carousel owl-theme">
                        <div class="item"><span class="thumb"><img src="<?php echo $gambarsampul ?>" alt=""></span></div>
                        <?php if ($rsGallery->num_rows() > 0): foreach ($rsGallery->result() as $rowGallery): 
                          if (!empty($rowGallery->filegallery)): ?>
                            <div class="item"><span class="thumb"><img src="<?php echo base_url('myesc.id/admin/uploads/cabanggereja/gallery/' . $rowGallery->filegallery) ?>" alt=""></span></div>
                        <?php endif; endforeach; endif; ?>
                      </div>
                    </div>
                  </div>

                  <!-- Info -->
                  <div class="col-md-8">
                    <div class="form-group detail-cabang">
                      <label class="detail-label">Alamat Gereja</label>
                      <div class="detail-value"><?php echo $rowCabang->alamatlengkap ?></div>
                    </div>
                    <div class="form-group detail-cabang">
                      <label class="detail-label">No Telepon</label>
                      <div class="detail-value"><?php echo $rowCabang->notelp ?></div>
                    </div>
                    <div class="form-group detail-cabang">
                      <label class="detail-label">Nama Gembala</label>
                      <div class="detail-value"><?php echo $rowCabang->namagembala ?></div>
                    </div>
                    <div class="form-group detail-cabang">
                      <label class="detail-label">Jadwal Ibadah</label>
                      <div class="detail-value"><?php echo $rowCabang->jadwalibadah ?></div>
                    </div>

                    <!-- Social -->
                    <div class="text-center mt-4">
                      <div class="social-area">
                        <?php
                        if (!empty($rowCabang->urlfacebook)) echo '<a href="'.$rowCabang->urlfacebook.'" target="_blank"><i class="fab fa-facebook"></i></a>';
                        if (!empty($rowCabang->urlinstagram)) echo '<a href="'.$rowCabang->urlinstagram.'" target="_blank"><i class="fab fa-instagram"></i></a>';
                        if (!empty($rowCabang->urlyoutube)) echo '<a href="'.$rowCabang->urlyoutube.'" target="_blank"><i class="fab fa-youtube"></i></a>';
                        if (!empty($rowCabang->urltwitter)) echo '<a href="'.$rowCabang->urltwitter.'" target="_blank"><i class="fab fa-twitter"></i></a>';
                        if (!empty($rowCabang->urllinkedin)) echo '<a href="'.$rowCabang->urllinkedin.'" target="_blank"><i class="fab fa-linkedin"></i></a>';
                        ?>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Deskripsi -->
                <?php if (!empty($rowCabang->deskripsi)) : ?>
                  <div class="mt-5 desc-section text-center">
                    <h3>Deskripsi Gereja</h3>
                    <hr>
                    <div><?php echo $rowCabang->deskripsi ?></div>
                  </div>
                <?php endif; ?>

              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main>

  <?php $this->load->view('template/festavalive/footer'); ?>

  <!-- Owl Carousel -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    $(document).ready(function() {
      const sync1 = $("#sync1");
      const sync2 = $("#sync2");
      const slidesPerPage = 3;
      let syncedSecondary = true;

      sync1.owlCarousel({
        items: 1,
        slideSpeed: 600,
        nav: true,
        center: true,
        dots: true,
        loop: true,
        autoHeight: false,
        responsiveRefreshRate: 200,
        navText: [
          '<svg width="18" height="30" viewBox="0 0 11 20"><path style="fill:none;stroke-width:1.6px;stroke:#000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
          '<svg width="18" height="30" viewBox="0 0 11 20"><path style="fill:none;stroke-width:1.6px;stroke:#000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'
        ],
      }).on('changed.owl.carousel', syncPosition);

      sync2.on('initialized.owl.carousel', function() {
        sync2.find(".owl-item").eq(0).addClass("current");
      }).owlCarousel({
        items: slidesPerPage,
        dots: true,
        nav: true,
        smartSpeed: 200,
        slideSpeed: 500,
        responsive: { 0: { items: 3 }, 768: { items: slidesPerPage } }
      }).on('changed.owl.carousel', syncPosition2);

      function syncPosition(el) {
        const count = el.item.count - 1;
        let current = Math.round(el.item.index - (el.item.count / 2) - .5);
        if (current < 0) current = count;
        if (current > count) current = 0;
        sync2.find(".owl-item").removeClass("current").eq(current).addClass("current");
      }

      function syncPosition2(el) {
        if (syncedSecondary) {
          const number = el.item.index;
          sync1.data('owl.carousel').to(number, 100, true);
        }
      }

      sync2.on("click", ".owl-item", function(e) {
        e.preventDefault();
        const number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
      });
    });
  </script>

</body>
</html>
