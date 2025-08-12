<?php $this->load->view('template/festavalive/header'); ?>

<body>

  <!-- FONT: Figtree -->
  <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Owl Carousel CSS (sama seperti semula) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    :root{
      --bg:#f6f8fb;
      --card:#ffffff;
      --muted:#6b7280;
      --accent:#243EAE;
      --radius:14px;
    }

    /* Global */
    html,body{
      height:100%;
    }
    body {
      font-family: 'Figtree', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: var(--bg);
      color: #111827;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      margin:0;
      padding:0;
    }

    /* HERO (keaslian gambar tetap pakai path lama) */
    #hero {
      width: 100%;
      height: 40vh;
      background: url("<?php echo base_url('myesc.id/images/banner2.jpg') ?>") center center / cover no-repeat;
      position: relative;
      display:flex;
      align-items:center;
      justify-content:center;
      text-align:center;
      padding: 1.5rem;
    }
    #hero:before {
      content: "";
      position:absolute;
      inset:0;
      background: linear-gradient(180deg, rgba(0,0,0,0.36), rgba(0,0,0,0.36));
      border-bottom-left-radius: 0;
      border-bottom-right-radius: 0;
    }
    #hero .container { position:relative; z-index:2; }
    #hero h1 {
      margin: 0;
      font-size: clamp(1.25rem, 3.2vw, 2.6rem);
      font-weight:700;
      color:#fff;
      line-height:1.05;
      letter-spacing: -0.02em;
      text-shadow: 0 6px 22px rgba(0,0,0,0.35);
    }
    #hero h5 {
      margin-top: .35rem;
      color: rgba(255,255,255,0.9);
      font-weight:500;
      font-size: .95rem;
    }

    /* Page content wrapper */
    .page-content.section-padding {
      padding: 2.2rem 0 3.2rem;
    }

    /* Card main area */
    .card {
      background: var(--card);
      border-radius: var(--radius);
      box-shadow: 0 8px 30px rgba(16,24,40,0.06);
      border: none;
      overflow: visible;
    }

    .card .card-body {
      padding: 1.25rem;
    }

    /* Layout tweaks */
    .row.justify-content-center {
      gap: 1.25rem;
    }

    /* Title */
    .detail-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 0.6rem;
      color: #0f172a;
    }

    /* Gallery (owl) modern */
    #sync1 .item,
    #sync2 .item {
      display:flex;
      align-items:center;
      justify-content:center;
      margin: 0.35rem;
    }

    #sync1 .item img {
      width:100%;
      height: auto;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
      aspect-ratio: 4 / 3;
    }
    #sync2 .item img {
      width:100%;
      height:auto;
      border-radius: 8px;
      object-fit: cover;
      aspect-ratio: 4 / 3;
      opacity: .95;
      transition: transform .18s ease, box-shadow .18s ease;
    }
    #sync2 .owl-item.current img {
      transform: scale(1.03);
      box-shadow: 0 10px 20px rgba(15,23,42,0.12);
      opacity:1;
    }

    /* Owl nav overrides (positioning arrows inside main carousel) */
    #sync1.owl-theme { position:relative; }
    #sync1.owl-theme .owl-prev,
    #sync1.owl-theme .owl-next {
      position:absolute;
      top:50%;
      transform: translateY(-50%);
      background: rgba(255,255,255,0.85);
      width:40px;
      height:40px;
      border-radius:10px;
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow: 0 6px 18px rgba(2,6,23,0.08);
    }
    #sync1.owl-theme .owl-prev { left:10px; }
    #sync1.owl-theme .owl-next { right:10px; }

    /* small thumbnails carousel */
    #sync2 { margin-top: .7rem; }

    /* Cabang list (sidebar) */
    .ulCabang {
      list-style:none;
      padding-left:0;
      margin:0;
    }
    .ulCabang li {
      padding: 6px 0;
      border-bottom: 1px dashed rgba(15,23,42,0.04);
    }
    .ulCabang li:last-child { border-bottom: none; }
    .ulCabang li a {
      text-decoration: none;
      color: var(--accent);
      font-size: 0.98rem;
      font-weight: 600;
    }
    .ulCabang li span {
      color: #374151;
      font-weight:600;
      font-size: 0.98rem;
    }

    /* details rows */
    .detail-cabang { padding-top: 10px; padding-bottom: 18px; }
    .detail-cabang .detail-label { font-weight: 600; color:var(--muted); display:block; }
    .detail-cabang .detail-value { font-weight: 600; color:#0f172a; display:block; margin-top:4px; word-break:break-word; }

    /* Social icons area */
    .social-area { display:flex; align-items:center; justify-content:center; gap: 0.9rem; margin-top:1rem; }
    .social-area a { display:inline-flex; align-items:center; justify-content:center; width:48px; height:48px; border-radius:12px; background:rgba(0,0,0,0.03); transition: transform .15s ease; font-size:1.15rem; }
    .social-area a:hover { transform: translateY(-4px); box-shadow: 0 8px 20px rgba(2,6,23,0.08); }

    /* Description */
    .desc-section h3 { font-size: 1.125rem; font-weight:700; margin-bottom:.6rem; }
    .desc-section hr { border-top:1px solid rgba(15,23,42,0.06); margin: .8rem 0; }

    /* Responsive: mobile-first */
    @media (max-width: 991px) {
      .col-md-9 { width:100%; padding-left:0; padding-right:0; }
      .col-md-3 { width:100%; padding-left:0; padding-right:0; }
    }
    @media (max-width: 768px) {
      #hero { height: 28vh; padding: .75rem; }
      .card .card-body { padding: 1rem; }
      .detail-title { font-size:1.125rem; }
      .social-area a { width:44px; height:44px; }
      /* make carousels more thumb-friendly */
      #sync2 .item img { aspect-ratio: 16/9; }
    }

    /* keep original utility classes compatibility (bootstrap may be included via header) */
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
              <div class="card-body" style="min-height: 640px;">

                <div class="row">
                  <div class="col-12 text-center font-weight-bold mb-4">
                    <h2 class="detail-title"><?php echo $rowCabang->namacabang ?></h2>
                  </div>

                  <!-- Gallery column -->
                  <div class="col-md-4">
                    <div class="row">
                      <div class="col-12">
                        <?php
                        $gambarsampul = base_url('myesc.id/images/nofoto.png');
                        if (!empty($rowCabang->gambarsampul)) {
                          $gambarsampul = base_url('myesc.id/admin/uploads/cabanggereja/' . $rowCabang->gambarsampul);
                        }
                        ?>
                        <div id="sync1" class="owl-carousel owl-theme">
                          <div class="item">
                            <img src="<?php echo $gambarsampul ?>" class="img-thumbnail" alt="<?php echo $rowCabang->namacabang ?>">
                          </div>

                          <?php
                          if ($rsGallery->num_rows() > 0) {
                            foreach ($rsGallery->result() as $rowGallery) {
                              $filegallery = base_url('myesc.id/images/nofoto.png');
                              if (!empty($rowGallery->filegallery)) {
                                $filegallery = base_url('myesc.id/admin/uploads/cabanggereja/gallery/' . $rowGallery->filegallery);
                          ?>
                                <div class="item">
                                  <img src="<?php echo $filegallery ?>" class="img-thumbnail" alt="">
                                </div>
                          <?php
                              }
                            }
                          }
                          ?>
                        </div>

                        <div id="sync2" class="owl-carousel owl-theme">
                          <div class="item">
                            <img src="<?php echo $gambarsampul ?>" class="img-thumbnail" alt="">
                          </div>
                          <?php
                          if ($rsGallery->num_rows() > 0) {
                            foreach ($rsGallery->result() as $rowGallery) {
                              $filegallery = base_url('myesc.id/images/nofoto.png');
                              if (!empty($rowGallery->filegallery)) {
                                $filegallery = base_url('myesc.id/admin/uploads/cabanggereja/gallery/' . $rowGallery->filegallery);
                          ?>
                                <div class="item">
                                  <img src="<?php echo $filegallery ?>" class="img-thumbnail" alt="">
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

                      <!-- Social icons (keaslian isi sosial tetap pakai PHP echo seperti awal) -->
                      <div class="col-12 text-center mt-4">
                        <div class="social-area">
                          <?php
                          $sosialmedia = '';
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

          <!-- Right: daftar cabang (sidebar kecil) -->
          <div class="col-md-3 pe-5">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-center">
                    <h5 style="font-weight:700">CABANG GEREJA ELSHADDAI</h5>
                  </div>
                  <div class="col-12">
                    <hr>
                  </div>
                  <div class="col-12" id="divContentCabang">
                    <ul class="ulCabang" id="ulCabang">
                      <li><a href="<?php echo site_url('ourlocation/detail/') ?>">Cabang Siantan</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </section>

  </main>

  <?php $this->load->view('template/festavalive/footer'); ?>


  <!-- Owl Carousel JS (tetap sama) -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Leaflet (sama seperti semula) -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    $(document).ready(function() {

      var sync1 = $("#sync1");
      var sync2 = $("#sync2");
      var slidesPerPage = 3; //globaly define number of elements per page
      var syncedSecondary = true;

      sync1.owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: true,
        autoplay: false,
        dots: true,
        loop: true,
        responsiveRefreshRate: 200,
        navText: ['<svg width="18" height="30" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1.6px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="18" height="30" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1.6px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
      }).on('changed.owl.carousel', syncPosition);

      sync2
        .on('initialized.owl.carousel', function() {
          sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
          items: slidesPerPage,
          dots: true,
          nav: true,
          smartSpeed: 200,
          slideSpeed: 500,
          slideBy: slidesPerPage,
          responsiveRefreshRate: 100
        }).on('changed.owl.carousel', syncPosition2);

      function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);

        if (current < 0) {
          current = count;
        }
        if (current > count) {
          current = 0;
        }

        sync2
          .find(".owl-item")
          .removeClass("current")
          .eq(current)
          .addClass("current");
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();

        if (current > end) {
          sync2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
          sync2.data('owl.carousel').to(current - onscreen, 100, true);
        }
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

    $(document).ready(function() {
      initMap();
    });

    function initMap() {
      $.ajax({
          url: '<?php echo site_url('ourlocation/getcabang') ?>',
          type: 'GET',
          dataType: 'json',
        })
        .done(function(getcabangresult) {
          var dataCabang = getcabangresult;
          $('#ulCabang').empty();

          if (dataCabang.length > 0) {
            var nourut = 1;
            for (var i = dataCabang.length - 1; i >= 0; i--) {

              if (idcabang != dataCabang[i]['idcabang']) {
                var addText = `<li><a href="<?php echo site_url('ourlocation/detail/') ?>` + dataCabang[i]['namacabang_slug'] + `/` + idmenu + `">` + dataCabang[i]['namacabang'] + `</a></li>`;
                $('#ulCabang').append(addText);
              } else {
                var addText = `<li><span>` + dataCabang[i]['namacabang'] + `</span></li>`;
                $('#ulCabang').append(addText);
              }

              nourut++;
            }
          } else {
            var addText = `<h5 class="text-center">Data cabang gereja belum ada.</h5>`;
            $('#divContentCabang').append(addText);
          }

        })
        .fail(function() {
          console.log("error getcabang");
        });
    }
  </script>

</body>

</html>
