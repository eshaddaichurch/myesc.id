<?php $this->load->view('template/festavalive/header'); ?>



<body>
  <style>
    /*--------------------------------------------------------------
        # Hero Section
    --------------------------------------------------------------*/
    
    #hero h1 {
      font-size: 2.5rem;
      font-weight: bold;
      color: white;
      margin-top: 50px;
      text-align: center;
    }

    #hero h2 {
      font-size: 1rem;
      color: #eeeeee;
      margin-top: 10px;
      text-align: center;
    }

    /* Navbar fixed at the top */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1050;
    }

    /* Map section */
    #map {
      height: 70vh;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Responsive Map */
    @media (max-width: 768px) {
      #map {
        height: 50vh;
      }
    }

    /* Cabang List */
    .ulCabang li {
      padding: 10px 0;
      border-bottom: 1px solid #ddd;
    }

    .ulCabang li a {
      font-size: 1rem;
      color: #2a2a2a;
      text-decoration: none;
      display: block;
      transition: color 0.3s ease;
    }

    .ulCabang li a:hover {
      color: #EE6F09;
    }

    /* Section About */
    .about-section {
      padding: 50px 0;
      background-color: #f7f7f7;
      text-align: center;
    }

    .about-section h2 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 30px;
      color: #333;
    }

    .card-body {
      padding: 20px;
    }

    .card {
      border-radius: 1rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin-bottom: 20px;
    }

    .card-body h5 {
      font-size: 1.25rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 20px;
    }

    /* Make sure it's mobile responsive */
    @media (max-width: 768px) {
      .card-body {
        padding: 15px;
      }

      .card {
        margin-bottom: 10px;
      }
    }
  </style>

  <main>
    <?php $this->load->view('template/festavalive/topmenu'); ?>


    <!-- About Section -->
    <!-- <section class="about-section">
      <div class="container">
        <h2>OUR LOCATION</h2>
      </div>
    </section> -->

    <!-- Page Content Section -->
    <section class="page-content section-padding">
      <div class="container">
        <div class="row justify-content-center">
          <!-- Map Section -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-body">
                <div id="map"></div>
              </div>
            </div>
          </div>

          <!-- Cabang List Section -->
          <div class="col-md-4">
            <div class="card">
              <div class="card-body">
                <h5>CABANG GEREJA ELSHADDAI</h5>
                <ul class="ulCabang" id="ulCabang">
                  <li><a href="<?php echo site_url('ourlocation/detail/') ?>">Cabang Siantan</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php $this->load->view('template/festavalive/footer'); ?>

  <!-- Leaflet JS & CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
          integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    var idmenu = "<?php echo $this->encrypt->encode($menu) ?>";
    const centerMap = [0.03718835906169617, 110.35766601562501];
    var map = L.map('map').setView(centerMap, 8);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    // Map click event (optional)
    function onMapClick(e) {
      alert("You clicked the map at " + e.latlng);
    }

    function initMap() {
      const myLatLng = {
        lat: 0.461323,
        lng: 127.843268
      };

      map.remove();
      map = L.map('map').setView(centerMap, 8);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
      }).addTo(map);

      $.ajax({
        url: '<?php echo site_url('ourlocation/getcabang') ?>',
        type: 'GET',
        dataType: 'json',
      }).done(function(getcabangresult) {
        console.log(getcabangresult);
        var dataCabang = getcabangresult;
        $('#ulCabang').empty();

        if (dataCabang.length > 0) {
          for (var i = 0; i < dataCabang.length; i++) {
            var latitude = dataCabang[i]['latitude'];
            var longitude = dataCabang[i]['longitude'];
            var lokasi = [latitude, longitude];
            setMarker(lokasi, dataCabang[i]['idcabang'], dataCabang[i]['namacabang'], dataCabang[i]['namacabang_slug'], dataCabang[i]['namagembala'], dataCabang[i]['gambarsampul'], dataCabang[i]['alamatlengkap'], dataCabang[i]['icon']);
            var addText = `<li><a href="<?php echo site_url('ourlocation/detail/') ?>` + dataCabang[i]['namacabang_slug'] + `/` + idmenu + `">` + dataCabang[i]['namacabang'] + `</a></li>`;
            $('#ulCabang').append(addText);
          }
        }
      }).fail(function() {
        console.log("error getcabang");
      });
    }

    function setMarker(lokasi, idcabang, namacabang, namacabang_slug, namagembala, gambarsampul, alamatlengkap, icon) {
      try {
        var iconWarna = L.icon({
          iconUrl: icon ? '<?php echo base_url('uploads/cabanggereja/') ?>' + icon : '<?php echo base_url('myesc.id/images/pin2.png') ?>',
          iconSize: [28, 30],
        });

        var marker = L.marker(lokasi, {icon: iconWarna}).addTo(map);
        marker.bindPopup("<b>" + namacabang + "</b><hr><small>Nama Gembala: " + namagembala + '</small><br><a href="<?php echo site_url('ourlocation/detail/') ?>' + namacabang_slug + '/' + idmenu + '" class="link-popup">Lihat Selengkapnya</a>');
      } catch (e) {
        console.log("Lokasi " + lokasi + " tidak ditemukan!");
      }
    }

    initMap();
  </script>
</body>
