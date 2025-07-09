<?php $this->load->view('template/festavalive/header'); ?>

<body>
  <style>
    /* Navbar Fixed */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1050;
      background-color: #ffffffcc;
      backdrop-filter: blur(8px);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Hero Section */
    #hero {
      width: 100%;
      height: 40vh;
      background: url("<?php echo base_url('myesc.id/images/banner2.jpg') ?>") center center;
      background-size: cover;
      position: relative;
    }

    #hero:before {
      content: "";
      background: rgba(0, 0, 0, 0.6);
      position: absolute;
      inset: 0;
    }

    #hero h1,
    #hero h2 {
      color: #fff;
      text-align: center;
      z-index: 1;
      position: relative;
    }

    #hero h1 {
      font-size: 48px;
      margin-top: 100px;
      font-weight: 700;
    }

    #hero h2 {
      font-size: 16px;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    @media (max-width: 768px) {
      #hero {
        height: 60vh;
      }

      #hero h1 {
        font-size: 32px;
        margin-top: 80px;
      }
    }

    /* About Section */
    .about-section {
      background-color: #f9f9f9;
    }

    .page-content {
      padding: 2rem 0;
    }

    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease;
      overflow: hidden;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-body {
      padding: 1.5rem;
    }

    #map {
      height: 60vh;
      border-radius: 1rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
      #map {
        height: 40vh;
      }
    }

    .ulCabang {
      list-style: none;
      padding-left: 0;
    }

    .ulCabang li {
      margin-bottom: 10px;
    }

    .ulCabang li a {
      text-decoration: none;
      color: #243EAE;
      font-size: 16px;
      display: block;
      padding: 8px 12px;
      border-radius: 8px;
      transition: background-color 0.3s;
    }

    .ulCabang li a:hover {
      background-color: #eef2ff;
    }

    .link-popup {
      font-size: 14px;
      color: #243EAE;
      text-decoration: underline;
    }

    .card-header-title {
      font-weight: bold;
      font-size: 18px;
      color: #333;
    }

    .row {
      gap: 2rem;
    }

    @media (max-width: 768px) {
      .row {
        flex-direction: column-reverse;
      }
    }
  </style>

  <main>
    <?php $this->load->view('template/festavalive/topmenu'); ?>

    <!-- Hero Section -->
    <section id="hero">
      <div class="container text-center">
        <h1>Our Location</h1>
        <h2>Find Us Nearby</h2>
      </div>
    </section>

    <!-- Map and List Section -->
    <section class="page-content section-padding">
      <div class="container">
        <div class="row justify-content-center">

          <!-- Map Column -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-body">
                <div id="map"></div>
              </div>
            </div>
          </div>

          <!-- Branch List Column -->
          <div class="col-md-3">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 text-center mb-3">
                    <h5 class="card-header-title">Cabang Gereja Elshaddai</h5>
                  </div>
                  <div class="col-12">
                    <hr>
                  </div>
                  <div class="col-12">
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

  <!-- Leaflet JS/CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet @1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin="" />
  <script src="https://unpkg.com/leaflet @1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>

  <!-- Script for Map -->
  <script>
    var idmenu = "<?php echo $this->encrypt->encode($menu) ?>";

    const centerMap = [0.03718835906169617, 110.35766601562501];
    var map;

    function initMap() {
      map = L.map('map').setView(centerMap, 8);
      L.tileLayer('https://tile.openstreetmap.org/ {z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
      }).addTo(map);

      $.ajax({
        url: '<?php echo site_url('ourlocation/getcabang') ?>',
        type: 'GET',
        dataType: 'json',
      })
        .done(function(getcabangresult) {
          $('#ulCabang').empty();

          if (getcabangresult.length > 0) {
            getcabangresult.forEach(function(cabang) {
              var latitude = cabang.latitude;
              var longitude = cabang.longitude;
              var lokasi = [latitude, longitude];

              setMarker(lokasi, cabang.idcabang, cabang.namacabang, cabang.namacabang_slug, cabang.namagembala, cabang.gambarsampul, cabang.alamatlengkap, cabang.icon);

              var addText = `<li><a href="<?php echo site_url('ourlocation/detail/') ?>${cabang.namacabang_slug}/${idmenu}">${cabang.namacabang}</a></li>`;
              $('#ulCabang').append(addText);
            });
          }
        })
        .fail(function() {
          console.log("Error fetching branch data");
        });
    }

    function setMarker(lokasi, idcabang, namacabang, namacabang_slug, namagembala, gambarsampul, alamatlengkap, icon) {
      try {
        var iconUrl = icon ? '<?php echo base_url('uploads/cabanggereja/') ?>' + icon : '<?php echo base_url('myesc.id/images/pin2.png') ?>';

        var iconWarna = L.icon({
          iconUrl: iconUrl,
          iconSize: [28, 30],
        });

        var marker = L.marker(lokasi, { icon: iconWarna }).addTo(map);
        marker.bindPopup(`<b>${namacabang}</b><hr><small>Nama Gembala: ${namagembala}</small><br><a href="<?php echo site_url('ourlocation/detail/') ?>${namacabang_slug}/${idmenu}" class="link-popup">Lihat Selengkapnya</a>`);
      } catch (e) {
        console.log("Lokasi tidak ditemukan!");
      }
    }

    $(document).ready(function () {
      initMap();
    });
  </script>
</body>
</html>