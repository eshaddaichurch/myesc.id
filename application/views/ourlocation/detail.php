<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- FONTS -->
  <link href="https://fonts.googleapis.com/css2?family=Baloo+2&family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Owl Carousel CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* ===== GLOBAL ===== */
    *, *::before, *::after { box-sizing: border-box; }
    html, body { height: 100%; width: 100%; }
    body {
      font-family: 'Figtree', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      /* background: #ead7a9; */
      background: linear-gradient(63deg, #fffaf5, #ffb347);
      color: #111827;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }
    img { max-width: 100%; height: auto; display: block; }
    a, a:hover { text-decoration: none; }

    /* -------------------------
       Breadcrumbs (jika dipakai)
       ------------------------- */
    .breadcrumbs { padding: 140px 0 60px 0; min-height: 30vh; position: relative; background-size: cover; background-position: center; }
    .breadcrumbs::before { content: ""; background-color: rgba(0,0,0,0.6); position: absolute; inset: 0; }
    .breadcrumbs h2 { font-size:56px; font-weight:500; color:#fff; font-family:'Baloo 2', cursive; position:relative; z-index:2; margin:0; padding-top:.5rem; }
    .breadcrumbs ol { display:flex; flex-wrap:wrap; list-style:none; padding:0 0 10px 0; margin:0; font-size:16px; font-weight:600; color:rgba(255,255,255,0.9); position:relative; z-index:2; }
    .breadcrumbs ol a { color: rgba(255,255,255,0.9); transition:.3s; }
    .breadcrumbs ol a:hover { text-decoration: underline; }
    .breadcrumbs ol li+li { padding-left:10px; }
    .breadcrumbs ol li+li::before { display:inline-block; padding-right:10px; color:#fff; content:"/"; }

    /* -------------------------
       Postcard (jika dipakai)
       ------------------------- */
    .postcard { display:flex; flex-wrap:wrap; box-shadow:0 4px 21px -12px rgba(0,0,0,0.66); border-radius:10px; margin:0 0 4rem 0; overflow:hidden; position:relative; color:#ffffff; background-color:#18151f; }
    .postcard.light { background-color:#e1e5ea; color:#111; }
    .postcard a { color:inherit; }
    .postcard h1, .postcard .h1 { margin-bottom:.5rem; font-weight:500; line-height:1.2; }
    .postcard .small { font-size:80%; }
    .postcard__title { font-size:1.75rem; padding-left:10px; color:inherit; }
    .postcard__img { max-height:180px; width:100%; object-fit:cover; position:relative; display:block; }
    .postcard__img_link { display:contents; }
    .postcard__bar { width:50px; height:10px; margin:10px 0; border-radius:5px; background-color:#424242; transition: width .2s ease; }
    .postcard__text { padding:2.5rem; position:relative; display:flex; flex-direction:column; color:inherit; background:transparent; }
    .postcard__preview-txt { overflow:hidden; text-overflow:ellipsis; text-align:left; height:100%; }
    .postcard__tagbox { display:flex; flex-flow:row wrap; font-size:14px; margin:20px 0 0 0; padding:0; justify-content:center; }
    .postcard__tagbox .tag__item { display:inline-block; background:#FAF0E6; border-radius:3px; padding:2.5px 10px; margin:0 5px 5px 0; user-select:none; transition:background-color .3s; }
    .postcard__tagbox .tag__item:hover { background:#FFD09B; }
    .postcard::before { content:""; position:absolute; top:0; right:0; bottom:0; left:0; background-image: linear-gradient(-70deg, #424242, transparent 50%); opacity:1; border-radius:10px; pointer-events:none; }

    @media screen and (min-width: 769px) {
      .postcard { flex-wrap: nowrap; max-width: 1000px; margin: 0 auto; align-items: center; }
      .postcard__img-container { width: 300px; height: 100%; overflow: hidden; flex-shrink: 0; }
      .postcard__img-container img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s ease; display: block; }
      .postcard__text { padding-left: 2rem; padding-right: 2rem; flex: 1; }
      .postcard:hover .postcard__img-container img { transform: scale(1.05); }
      .postcard:nth-child(2n+1) { flex-direction: row; }
      .postcard:nth-child(2n+0) { flex-direction: row-reverse; }
    }
    @media screen and (min-width: 1024px) { .postcard__text { padding: 2rem 3.5rem; } }

    /* ===========================
       MAIN layout / gallery / details
       =========================== */
    #hero { width:100%; height:40vh; position:relative; display:flex; align-items:center; justify-content:center; text-align:center; padding:1.5rem; }
    #hero .container { position:relative; z-index:2; }
    #hero h1 { margin:0; font-size:clamp(1.25rem,3.2vw,2.6rem); font-weight:700; color:#fff; line-height:1.05; letter-spacing:-0.02em; text-shadow:0 6px 22px rgba(0,0,0,0.35); font-family:'Baloo 2', cursive; }
    #hero h5 { margin-top:.35rem; color: rgba(255,255,255,0.9); font-weight:500; font-size:.95rem; }

    .page-content.section-padding { padding: 2.2rem 0 3.2rem; }
    .card { background: var(--card, #fff); border-radius: 14px; box-shadow: 0 8px 30px rgba(16,24,40,0.06); border: none; overflow: visible; width:100%; }
    .card .card-body { padding:1.25rem; }
    .card-body.min-h-lg { min-height: auto; }
    @media (min-width: 1024px) { .card-body.min-h-lg { min-height: 640px; } }
    .row.justify-content-center { gap: 1.25rem; }
    .detail-title { font-size: 1.5rem; font-weight:700; margin-bottom:.6rem; color:#0f172a; }

    /* ====== GALLERY ====== */
    .gallery { }
    /* Main carousel tidak overflow */
    #sync1.owl-carousel { position: relative; }
    #sync1 .owl-stage-outer { overflow: hidden !important; }
    #sync1 .owl-stage { overflow: visible; }
    #sync1 .item { margin:.35rem; }
    #sync1 .frame {
      width: 100%;
      aspect-ratio: 4 / 3;   /* bisa diganti 16/9 */
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 18px rgba(15,23,42,0.08);
      background: #f4f4f5;
      display: block;
    }
    #sync1 .frame img { width:100%; height:100%; object-fit: scale-down; }

    /* THUMBNAILS */
    .thumbs-clip {              /* <- pembungkus untuk memotong overflow */
      width: 100%;
      overflow: hidden;
      padding: .1rem;          /* agar thumb tidak mentok */
      box-sizing: border-box;
    }
    #sync2.owl-carousel { position: relative; margin-top:.75rem; }
    #sync2 .owl-stage-outer { overflow: visible !important; } /* desktop efek scale terlihat */
    #sync2 .item { margin:.35rem; }
    #sync2 .thumb {
      width: 100%;
      max-width: 110px;
      aspect-ratio: 1 / 1;
      border-radius: 8px;
      overflow: hidden;
      background: #f4f4f5;
      opacity: .95;
      transition: transform .18s ease, box-shadow .18s ease, opacity .18s ease;
      display:block;
    }
    #sync2 .thumb img { width:100%; height:100%; object-fit: cover; display:block; }
    #sync2 .owl-item.current .thumb { transform: scale(1.03); box-shadow: 0 10px 20px rgba(15,23,42,0.12); opacity:1; }

    /* Nav arrows main */
    #sync1.owl-theme .owl-prev, #sync1.owl-theme .owl-next {
      position:absolute; top:50%; transform: translateY(-50%);
      background: rgba(255,255,255,0.95); width:44px; height:44px; border-radius:12px;
      display:flex; align-items:center; justify-content:center;
      box-shadow: 0 6px 18px rgba(2,6,23,0.08); z-index: 20;
    }
    #sync1.owl-theme .owl-prev { left: 14px; } 
    #sync1.owl-theme .owl-next { right: 14px; }

    /* Details */
    .ulCabang { list-style:none; padding-left:0; margin:0; }
    .ulCabang li { padding:6px 0; border-bottom:1px dashed rgba(15,23,42,0.04); }
    .ulCabang li:last-child { border-bottom:none; }
    .ulCabang li a { text-decoration:none; color:var(--accent, #243EAE); font-size:.98rem; font-weight:600; }
    .ulCabang li span { color:#374151; font-weight:600; font-size:.98rem; }

    .detail-cabang { padding-top:10px; padding-bottom:18px; }
    .detail-cabang .detail-label { font-weight:600; color:var(--muted,#6b7280); display:block; }
    .detail-cabang .detail-value { font-weight:600; color:#0f172a; display:block; margin-top:4px; word-break:break-word; }

    .social-area { display:flex; align-items:center; justify-content:center; gap:.9rem; margin-top:1rem; }
    .social-area a { display:inline-flex; align-items:center; justify-content:center; width:48px; height:48px; border-radius:12px; background:rgba(0,0,0,0.03); transition: transform .15s ease; font-size:1.15rem; color:inherit; }
    .social-area a:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(2,6,23,0.08); }

    .desc-section h3 { font-size:1.125rem; font-weight:700; margin-bottom:.6rem; }
    .desc-section hr { border-top:1px solid rgba(15,23,42,0.06); margin:.8rem 0; }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 991px) {
      .col-md-9 { width: 100%; padding-left: 0; padding-right: 0; }
      .col-md-3 { width: 100%; padding-left: 0; padding-right: 0; }
    }
    @media (max-width: 768px) {
      .ps-5 { padding-left: 1rem !important; }
      .pe-5 { padding-right: 1rem !important; }

      .col-md-9.ps-5 { padding-left: 1rem !important; padding-right: 1rem !important; }
      .card { margin-left: 0.25rem; margin-right: 0.25rem; border-radius: 12px; }
      .card {
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.08);
        transition: transform .3s ease, box-shadow .3s ease;
      }
      .card .card-body { padding: 1rem; }
      .detail-title { font-size: 1.125rem; }
      .social-area a { width:44px; height:44px; }

      /* KUNCI: di mobile, thumbnail tidak boleh overflow */
      #sync2 .owl-stage-outer { overflow: hidden !important; }
      #sync2 .thumb { max-width: 90px; }
    }

    /* Utilities */
    .text-center { text-align:center; }
    .mb-4 { margin-bottom:1rem!important; }
    .mt-3 { margin-top:.75rem!important; }
    .mt-5 { margin-top:2rem!important; }
    .me-3 { margin-right:1rem!important; }
    .ps-5 { padding-left:3rem!important; }
    .pe-5 { padding-right:3rem!important; }
  </style>

  <main>

    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <!-- Hero -->
    <section id="hero" aria-label="hero">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <h1 class="text-center"><?php echo $rowCabang->namacabang ?></h1>
            <h5 class="text-center"><?php echo !empty($rowCabang->keterangan_singkat) ? $rowCabang->keterangan_singkat : ''; ?></h5>
          </div>
        </div>
      </div>
    </section>

    <!-- Main content -->
    <section class="page-content section-padding" aria-labelledby="our-location">
      <div class="container">
        <div class="row justify-content-center">

          <!-- Left: main card -->
          <div class="col-md-9 ps-5">
            <div class="card">
              <div class="card-body min-h-lg">

                <div class="row">
                  <div class="col-12 text-center font-weight-bold mb-4">
                    <h2 class="detail-title"><?php echo $rowCabang->namacabang ?></h2>
                  </div>

                  <!-- Gallery column -->
                  <div class="col-md-4 gallery">
                    <div class="row">
                      <div class="col-12">
                        <?php
                          $gambarsampul = base_url('myesc.id/images/nofoto.png');
                          if (!empty($rowCabang->gambarsampul)) {
                            $gambarsampul = base_url('myesc.id/admin/uploads/cabanggereja/' . $rowCabang->gambarsampul);
                          }
                        ?>
                        <!-- Main carousel -->
                        <div id="sync1" class="owl-carousel owl-theme">
                          <div class="item">
                            <span class="frame">
                              <img src="<?php echo $gambarsampul ?>" loading="lazy" alt="<?php echo $rowCabang->namacabang ?>">
                            </span>
                          </div>
                          <?php
                          if ($rsGallery->num_rows() > 0) {
                            foreach ($rsGallery->result() as $rowGallery) {
                              $filegallery = base_url('myesc.id/images/nofoto.png');
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

                        <!-- Thumbnails (dibungkus thumbs-clip untuk potong overflow) -->
                        <div class="thumbs-clip">
                          <div id="sync2" class="owl-carousel owl-theme">
                            <div class="item">
                              <span class="thumb">
                                <img src="<?php echo $gambarsampul ?>" loading="lazy" alt="">
                              </span>
                            </div>
                            <?php
                            if ($rsGallery->num_rows() > 0) {
                              foreach ($rsGallery->result() as $rowGallery) {
                                $filegallery = base_url('myesc.id/images/nofoto.png');
                                if (!empty($rowGallery->filegallery)) {
                                  $filegallery = base_url('myesc.id/admin/uploads/cabanggereja/gallery/' . $rowGallery->filegallery);
                                  ?>
                                  <div class="item">
                                    <span class="thumb">
                                      <img src="<?php echo $filegallery ?>" loading="lazy" alt="">
                                    </span>
                                  </div>
                                  <?php
                                }
                              }
                            }
                            ?>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <!-- Info column -->
                  <div class="col-md-8">
                    <div class="row">
                      <div class="col-12">

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

                      </div>

                      <!-- Social icons -->
                      <div class="col-12 text-center mt-4">
                        <div class="social-area">
                          <?php
                          if (!empty($rowCabang->urlfacebook)) {
                            echo '<a href="' . $rowCabang->urlfacebook . '" target="_blank" aria-label="facebook"><i class="fab fa-facebook" aria-hidden="true"></i></a>';
                          }
                          if (!empty($rowCabang->urlinstagram)) {
                            echo '<a href="' . $rowCabang->urlinstagram . '" target="_blank" aria-label="instagram"><i class="fab fa-instagram" aria-hidden="true"></i></a>';
                          }
                          if (!empty($rowCabang->urlyoutube)) {
                            echo '<a href="' . $rowCabang->urlyoutube . '" target="_blank" aria-label="youtube"><i class="fab fa-youtube" aria-hidden="true"></i></a>';
                          }
                          if (!empty($rowCabang->urltwitter)) {
                            echo '<a href="' . $rowCabang->urltwitter . '" target="_blank" aria-label="twitter"><i class="fab fa-twitter" aria-hidden="true"></i></a>';
                          }
                          if (!empty($rowCabang->urllinkedin)) {
                            echo '<a href="' . $rowCabang->urllinkedin . '" target="_blank" aria-label="linkedin"><i class="fab fa-linkedin" aria-hidden="true"></i></a>';
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Description (jika ada) -->
                  <?php if (!empty($rowCabang->deskripsi)) { ?>
                    <div class="col-12 mt-5 desc-section">
                      <div class="row">
                        <div class="col-12 text-center">
                          <h3>Deskripsi Gereja</h3>
                        </div>
                        <div class="col-12"><hr></div>
                        <div class="col-12">
                          <?php echo $rowCabang->deskripsi ?>
                        </div>
                      </div>
                    </div>
                  <?php } ?>

                </div>
              </div>
            </div>
          </div>

          <!-- (Opsional) Kolom kanan list cabang
          <div class="col-md-3 pe-5">
            <div class="card">
              <div class="card-body">
                <div id="divContentCabang">
                  <ul id="ulCabang" class="ulCabang"></ul>
                </div>
              </div>
            </div>
          </div>
          -->

        </div>
      </div>
    </section>

  </main>

  <?php $this->load->view('template/festavalive/footer'); ?>

  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    $(document).ready(function() {
      var sync1 = $("#sync1");
      var sync2 = $("#sync2");
      var slidesPerPage = 3;
      var syncedSecondary = true;

      sync1.owlCarousel({
        items: 1,
        slideSpeed: 600,
        nav: true,
        center: true,
        autoplay: false,
        dots: true,
        loop: true,
        autoHeight: false, // frame fixed aspect ratio
        responsiveRefreshRate: 200,
        navText: [
          '<svg width="18" height="30" viewBox="0 0 11 20" aria-hidden="true"><path style="fill:none;stroke-width:1.6px;stroke:#000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>',
          '<svg width="18" height="30" viewBox="0 0 11 20" aria-hidden="true"><path style="fill:none;stroke-width:1.6px;stroke:#000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'
        ],
      }).on('changed.owl.carousel', syncPosition);

      sync2.on('initialized.owl.carousel', function() {
          sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
          items: slidesPerPage,
          dots: true,
          nav: true,
          smartSpeed: 200,
          slideSpeed: 500,
          slideBy: 1,
          responsiveRefreshRate: 100,
          responsive: {
            0: { items: 3 },
            480: { items: 3 },
            768: { items: slidesPerPage }
          }
        }).on('changed.owl.carousel', syncPosition2);

      function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);
        if (current < 0) current = count;
        if (current > count) current = 0;

        sync2.find(".owl-item").removeClass("current").eq(current).addClass("current");
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();

        if (current > end) sync2.data('owl.carousel').to(current, 100, true);
        if (current < start) sync2.data('owl.carousel').to(current - onscreen, 100, true);
      }

      function syncPosition2(el) {
        if (syncedSecondary) {
          var number = el.item.index;
          sync1.data('owl.carousel').to(number, 100, true);
        }
      }

      sync2.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
      });
    });
  </script>

  <script>
    var idcabang = "<?php echo $idcabang ?>";
    var idmenu = "<?php echo $this->encrypt->encode($menu) ?>";

    $(document).ready(function() { initMap(); });

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
          } else {
            var addText = `<h5 class="text-center">Data cabang gereja belum ada.</h5>`;
            $('#divContentCabang').append(addText);
          }
        })
        .fail(function() { console.log("error getcabang"); });
    }
  </script>

</body>
</html>
