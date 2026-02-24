<?php $this->load->view('template/festavalive/header'); ?>
<body>
<style>
   @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

body { font-family: 'Figtree', sans-serif; background:#aaa; }

  .locations-wrapper { padding: 150px 0 50px; }

  .locations-header h2 {
    font-size: 2.2rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;
  }
  .locations-header p { color: #64748b; font-size: .95rem; }

  .locations-layout {
    display: grid;
    grid-template-columns: 420px 1fr;
    gap: 26px;
    margin-top: 26px;
    align-items: start;
  }

  .branch-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    max-height: 72vh;
    overflow-y: auto;
    padding-right: 6px;
  }

  .branch-card {
    position: relative;
    background: #fff;
    border-radius: 18px;
    border: 1px solid #e5e7eb;
    padding: 18px 18px 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,.05);
    transition: all .25s ease;
  }
  .branch-card.active {
    border: 2px solid #f97316;
    box-shadow: 0 8px 20px rgba(249,115,22,.25);
  }

  .branch-pin {
    position:absolute;
    right:14px;
    top:14px;
    width:24px;
    height:24px;
    border-radius:50%;
    background:#fff7ed;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#f97316;
    font-size:13px;
  }

  .branch-title { font-size: 1.02rem; font-weight: 600; color: #0f172a; }
  .branch-address { font-size: .88rem; color: #475569; margin-top: 2px; }

  .branch-meta {
    font-size: .82rem;
    color: #475569;
    margin-top: 8px;
    line-height: 1.4;
  }

  .branch-actions {
    display: flex;
    gap: 8px;
    margin-top: 14px;
  }
  .btn-dir {
    flex: 1;
    background: #f97316;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 8px 10px;
    font-size: .85rem;
    font-weight: 600;
  }
  .btn-detail {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: .83rem;
    color: #0f172a;
    text-decoration: none;
    display:flex;
    align-items:center;
    justify-content:center;
  }

  #map {
    width: 100%;
    height: 72vh;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,.12);
  }

  /* -------- MOBILE -------- */
  @media (max-width: 992px) {
    .locations-layout { grid-template-columns: 1fr; }
    .branch-list { max-height: none; order: 2; }
    #map { order: 1; height: 48vh; margin-bottom: 18px; }
  }

  @media (max-width: 576px) {
    .locations-wrapper { padding: 100px 0 40px; }
    .locations-header h2 { font-size: 1.6rem; }
    .locations-header p { font-size: .9rem; }

    .branch-card { border-radius: 16px; padding: 16px 14px 14px; }
    .branch-title { font-size: .98rem; }
    .branch-address { font-size: .82rem; }
    .branch-meta { font-size: .78rem; }

    .branch-actions { flex-direction: column; }
    .btn-dir, .btn-detail { width: 100%; }

    #map { height: 42vh; border-radius: 18px; }
  }
</style>

<main>
<?php $this->load->view('template/festavalive/topmenu'); ?>

<section class="locations-wrapper">
  <div class="container">
    <div class="locations-header">
      <h2>Visit ESC</h2>
      <p></p>
    </div>

    <div class="locations-layout">
      <div class="branch-list" id="branchList"></div>
      <div id="map"></div>
    </div>
  </div>
</section>
</main>

<?php $this->load->view('template/festavalive/footer'); ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
var idmenu = "<?php echo $this->encrypt->encode($menu) ?>";
const centerMap = [0.03718835906169617, 110.35766601562501];
var map = L.map('map').setView(centerMap, 8);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '© OpenStreetMap'
}).addTo(map);

function initMap() {
  $.ajax({
    url: '<?php echo site_url('ourlocation/getcabang') ?>',
    type: 'GET',
    dataType: 'json'
  }).done(function(dataCabang) {
    $('#branchList').empty();
    if (!dataCabang || !dataCabang.length) return;

    dataCabang.forEach((cabang, i) => {
      const lat = cabang.latitude;
      const lng = cabang.longitude;
      const lokasi = [lat, lng];

      const iconWarna = L.icon({
        iconUrl: cabang.icon ? '<?php echo base_url('uploads/cabanggereja/') ?>' + cabang.icon : '<?php echo base_url('myesc.id/images/pin2.png') ?>',
        iconSize: [28,30]
      });

      L.marker(lokasi,{icon:iconWarna}).addTo(map)
        .bindPopup(`<b>${cabang.namacabang}</b><br><small>${cabang.alamatlengkap}</small>`);

      // const serviceTimes = cabang.jadwal || cabang.servicetimes || '-';

      const card = `
        <div class="branch-card ${i===0?'active':''}" onclick="focusMap(${lat},${lng},this)">
          <div class="branch-pin">📍</div>
          <div class="branch-title">${cabang.namacabang}</div>
          <div class="branch-address">${cabang.alamatlengkap}</div>
          <div class="branch-actions">
            <button class="btn-dir">Get Directions</button>
            <a class="btn-detail" href="<?php echo site_url('ourlocation/detail/') ?>${cabang.namacabang_slug}/${idmenu}">Details</a>
          </div>
        </div>`;

      $('#branchList').append(card);
    });

    if (dataCabang[0]) map.setView([dataCabang[0].latitude,dataCabang[0].longitude],12);
  });
}

function focusMap(lat,lng,el){
  map.setView([lat,lng],14,{animate:true});
  $('.branch-card').removeClass('active');
  if(el) $(el).addClass('active');
}

initMap();
</script>
</body>
