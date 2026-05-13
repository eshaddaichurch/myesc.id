<?php $this->load->view('template/festavalive/header'); ?>
<body>
<main>
  <?php $this->load->view('template/festavalive/topmenu'); ?>

  <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --orange:       #ff5008;
      --orange-soft:  rgba(255,80,8,0.08);
      --orange-glow:  rgba(255,80,8,0.15);
      --dark:         #0e0e0e;
      --dark-2:       #161616;
      --card-bg:      #ffffff;
      --card-border:  rgba(0,0,0,0.07);
      --text:         #111111;
      --text-mid:     #555555;
      --text-light:   #999999;
      --bg:           #faf8f5;
      --sans:         'Figtree', sans-serif;
      --radius:       18px;
      --radius-sm:    10px;
      --shadow-sm:    0 2px 8px rgba(0,0,0,0.06);
      --shadow-md:    0 8px 28px rgba(0,0,0,0.10);
      --shadow-lg:    0 20px 60px rgba(0,0,0,0.14);
      --transition:   0.25s ease;
    }

    body {
      font-family: var(--sans);
      background: var(--bg);
      color: var(--text);
      overflow-x: hidden;
    }

    /* ══════════════════════════════
       HERO
    ══════════════════════════════ */
    .loc-hero {
      background: var(--dark);
      padding: 100px 24px 60px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .loc-hero__noise {
      position: absolute; inset: 0; pointer-events: none;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.035'/%3E%3C/svg%3E");
      background-size: 200px;
    }
    .loc-hero__glow {
      position: absolute;
      bottom: -60px; left: 50%; transform: translateX(-50%);
      width: 600px; height: 300px;
      background: radial-gradient(ellipse, rgba(255,80,8,0.18) 0%, transparent 70%);
      pointer-events: none;
    }
    .loc-hero__inner {
      position: relative; z-index: 2;
      max-width: 600px; margin: 0 auto;
    }
    .loc-hero__eyebrow {
      display: inline-flex; align-items: center; gap: 8px;
      font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
      color: var(--orange); font-weight: 600; margin-bottom: 20px;
    }
    .loc-hero__eyebrow::before, .loc-hero__eyebrow::after {
      content: ''; display: block;
      width: 20px; height: 1px; background: var(--orange);
    }
    .loc-hero__title {
      font-size: clamp(2.4rem, 7vw, 4rem);
      font-weight: 800; color: #fff;
      line-height: 1.05; letter-spacing: -1.5px;
      margin-bottom: 14px;
    }
    .loc-hero__sub {
      font-size: 15px; color: rgba(255,255,255,0.45);
      font-weight: 400; line-height: 1.6;
    }

    /* ══════════════════════════════
       SEARCH BAR
    ══════════════════════════════ */
    .loc-search-wrap {
      max-width: 520px;
      margin: -26px auto 0;
      padding: 0 24px;
      position: relative; z-index: 10;
    }
    .loc-search {
      display: flex; align-items: center; gap: 12px;
      background: #fff;
      border-radius: 100px;
      padding: 10px 10px 10px 20px;
      box-shadow: var(--shadow-lg);
      border: 1px solid var(--card-border);
    }
    .loc-search svg {
      width: 18px; height: 18px; color: var(--text-light); flex-shrink: 0;
    }
    .loc-search input {
      flex: 1; border: none; outline: none;
      font-family: var(--sans); font-size: 14px; font-weight: 500;
      color: var(--text); background: transparent;
    }
    .loc-search input::placeholder { color: var(--text-light); }
    .loc-search-count {
      font-size: 12px; font-weight: 600; color: var(--text-light);
      white-space: nowrap; padding-right: 4px;
    }

    /* ══════════════════════════════
       BODY LAYOUT
    ══════════════════════════════ */
    .loc-body {
      max-width: 1240px;
      margin: 32px auto 0;
      padding: 0 24px 80px;
      display: grid;
      grid-template-columns: 400px 1fr;
      gap: 24px;
      align-items: start;
    }

    /* ══════════════════════════════
       BRANCH LIST
    ══════════════════════════════ */
    .loc-list-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 14px;
    }
    .loc-list-header h3 {
      font-size: 13px; font-weight: 700;
      color: var(--text-mid); letter-spacing: 1px; text-transform: uppercase;
    }
    .loc-list {
      display: flex; flex-direction: column; gap: 10px;
      max-height: 72vh; overflow-y: auto;
      padding-right: 2px;
      scrollbar-width: thin; scrollbar-color: #ddd transparent;
    }
    .loc-list::-webkit-scrollbar { width: 3px; }
    .loc-list::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

    .loc-card {
      background: var(--card-bg);
      border-radius: var(--radius);
      border: 1.5px solid var(--card-border);
      padding: 16px 18px;
      box-shadow: var(--shadow-sm);
      transition: all var(--transition);
      cursor: pointer;
      position: relative;
      overflow: visible; /* Ubah dari hidden ke visible */
      display: flex;
      flex-direction: column;
      min-height: fit-content;
    }
    .loc-card::before {
      content: '';
      position: absolute; left: 0; top: 0; bottom: 0;
      width: 3px; background: var(--orange);
      transform: scaleY(0); transform-origin: bottom;
      transition: transform var(--transition);
      border-radius: 0 2px 2px 0;
    }
    .loc-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); border-color: rgba(255,80,8,0.2); }
    .loc-card:hover::before { transform: scaleY(1); }
    .loc-card.active {
      border-color: var(--orange);
      box-shadow: 0 8px 32px rgba(255,80,8,0.12);
      background: #fffcfb;
    }
    .loc-card.active::before { transform: scaleY(1); }

    .loc-card__top {
      display: flex; align-items: flex-start; gap: 12px;
      overflow: hidden;
      padding-bottom: 24px; /* Tambah ruang di bawah untuk tombol */
      margin-bottom: 10px;
    }
    .loc-card__pin {
      width: 34px; height: 34px; flex-shrink: 0;
      background: var(--orange-soft);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      border: 1px solid rgba(255,80,8,0.15);
      transition: background var(--transition);
    }
    .loc-card.active .loc-card__pin { background: var(--orange); }
    .loc-card__pin svg { width: 16px; height: 16px; color: var(--orange); }
    .loc-card.active .loc-card__pin svg { color: #fff; }
    .loc-card__meta { flex: 1; min-width: 0; }
    .loc-card__num-badge {
      font-size: 10px; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; color: var(--text-light);
      margin-bottom: 3px;
    }
    .loc-card__title {
      font-size: 14px; font-weight: 700; color: var(--text);
      line-height: 1.3; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    }
    .loc-card__address {
      font-size: 12.5px; color: var(--text-mid);
      line-height: 1.55; padding-left: 46px;
      display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .loc-card__actions {
      
      margin-top: auto; /* Dorong ke bawah jika konten pendek */
      padding-left: 46px;
      padding-bottom: 4px; /* Beri ruang aman di bawah */
      flex-wrap: wrap; /* Agar tombol turun ke baris baru jika sempit */
    }
    .loc-card__btn-dir {
      flex: 1; background: var(--orange); color: #fff; border: none;
      border-radius: var(--radius-sm); padding: 8px 12px;
      font-size: 12.5px; font-weight: 700; cursor: pointer;
      transition: background var(--transition), transform var(--transition);
      font-family: var(--sans); display: flex; align-items: center; justify-content: center; gap: 5px;
    }
    .loc-card__btn-dir:hover { background: #d93e00; transform: translateY(-1px); }
    .loc-card__btn-dir svg { width: 13px; height: 13px; }
    .loc-card__btn-detail {
      background: var(--bg); border: 1.5px solid var(--card-border);
      border-radius: var(--radius-sm); padding: 8px 14px;
      font-size: 12.5px; font-weight: 600; color: var(--text);
      text-decoration: none; display: flex; align-items: center; gap: 4px;
      transition: background var(--transition), border-color var(--transition);
    }
    .loc-card__btn-detail:hover { background: #efefef; text-decoration: none; color: var(--text); border-color: #ccc; }

    /* Empty state */
    .loc-empty {
      text-align: center; padding: 40px 20px;
      color: var(--text-light); font-size: 14px; display: none;
    }
    .loc-empty-icon { font-size: 36px; margin-bottom: 10px; }

    /* ══════════════════════════════
       MAP PANEL
    ══════════════════════════════ */
    .loc-map-wrap {
      position: sticky; top: 20px;
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: var(--shadow-md);
      border: 1px solid var(--card-border);
    }
    .loc-map-header {
      display: flex; align-items: center; justify-content: space-between;
      padding: 14px 18px;
      border-bottom: 1px solid var(--card-border);
      background: #fff;
    }
    .loc-map-header-left {
      display: flex; align-items: center; gap: 10px;
    }
    .loc-map-dot {
      width: 8px; height: 8px; border-radius: 50%;
      background: var(--orange);
      box-shadow: 0 0 0 3px rgba(255,80,8,0.15);
      animation: mapPulse 2s infinite;
    }
    @keyframes mapPulse {
      0%,100%{ box-shadow: 0 0 0 3px rgba(255,80,8,0.15); }
      50%    { box-shadow: 0 0 0 6px rgba(255,80,8,0.05); }
    }
    .loc-map-label {
      font-size: 13px; font-weight: 700; color: var(--text);
    }
    .loc-map-sublabel {
      font-size: 11px; color: var(--text-light); margin-top: 1px;
    }
    .loc-map-reset {
      background: var(--bg); border: 1px solid var(--card-border);
      border-radius: 8px; padding: 6px 12px;
      font-size: 12px; font-weight: 600; color: var(--text-mid);
      cursor: pointer; font-family: var(--sans);
      transition: background var(--transition);
    }
    .loc-map-reset:hover { background: #eee; }
    #map { width: 100%; height: 62vh; }

    /* ══════════════════════════════
       MOBILE TAB SWITCHER
    ══════════════════════════════ */
    .loc-tabs {
      display: none;
      background: #fff;
      border-radius: 100px;
      padding: 4px;
      box-shadow: var(--shadow-sm);
      border: 1px solid var(--card-border);
    }
    .loc-tab {
      flex: 1; padding: 9px 16px;
      font-size: 13px; font-weight: 600;
      border: none; background: transparent;
      border-radius: 100px; cursor: pointer;
      color: var(--text-mid); font-family: var(--sans);
      transition: all var(--transition);
      display: flex; align-items: center; justify-content: center; gap: 6px;
    }
    .loc-tab.active { background: var(--orange); color: #fff; }
    .loc-tab svg { width: 14px; height: 14px; }

    /* ══════════════════════════════
       RESPONSIVE
    ══════════════════════════════ */
    @media (max-width: 900px) {
      .loc-body {
        grid-template-columns: 1fr;
        padding: 0 16px 60px;
        margin-top: 24px;
        gap: 16px;
      }
      .loc-map-wrap { position: static; }
      #map { height: 48vh; }
      .loc-list { max-height: none; }
      .loc-search-wrap { max-width: 100%; padding: 0 16px; }

      /* Tab switcher visible on mobile */
      .loc-tabs { display: flex; margin: 20px 16px 0; }
      .loc-panel { display: none; }
      .loc-panel.active { display: block; }
    }

    @media (max-width: 480px) {
      .loc-hero { padding: 80px 20px 52px; }
      .loc-hero__title { letter-spacing: -1px; }
      .loc-card__actions { flex-direction: row; flex-wrap: wrap; }
      .loc-card__btn-dir { min-width: 0; }
    }

    /* ══════════════════════════════
       SKELETON LOADER
    ══════════════════════════════ */
    .skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e8e8e8 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: shimmer 1.4s infinite;
      border-radius: 8px;
    }
    @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }
    .skeleton-card {
      background: #fff; border-radius: var(--radius);
      padding: 16px 18px; border: 1.5px solid var(--card-border);
    }
    .sk-line { height: 12px; margin-bottom: 8px; }
    .sk-line-title { width: 70%; }
    .sk-line-addr { width: 90%; }
    .sk-line-addr2 { width: 60%; }
    .sk-btn { height: 34px; border-radius: var(--radius-sm); margin-top: 12px; }

    /* ══════════════════════════════
       COUNT BADGE
    ══════════════════════════════ */
    .loc-count-badge {
      display: inline-flex; align-items: center; gap: 6px;
      font-size: 12px; font-weight: 600; color: var(--text-mid);
      background: #fff; border: 1px solid var(--card-border);
      padding: 4px 12px; border-radius: 100px;
      box-shadow: var(--shadow-sm);
    }
    .loc-count-badge span { color: var(--orange); font-weight: 800; }


    /* Efek halus untuk marker logo ESC */
    .esc-marker-icon {
      transition: filter 0.2s ease, transform 0.2s ease;
      filter: drop-shadow(0 2px 4px rgba(0,0,0,0.15));
    }
    .esc-marker-icon:hover {
      filter: drop-shadow(0 4px 8px rgba(255,80,8,0.4));
      transform: scale(1.05);
    }

    /* Pastikan popup tetap rapi dengan font Figtree */
    .leaflet-popup-content {
      font-family: var(--sans) !important;
      margin: 12px 16px !important;
    }
  </style>

  <!-- HERO -->
  <div class="loc-hero">
    <div class="loc-hero__noise"></div>
    <div class="loc-hero__glow"></div>
    <div class="loc-hero__inner">
      <div class="loc-hero__eyebrow"></div>
      <h1 class="loc-hero__title">Visit ESC</h1>
      <p class="loc-hero__sub">Temukan lokasi gereja GBI terdekat dengan Anda di seluruh Kalimantan Barat</p>
    </div>
  </div>

  <!-- SEARCH -->
  <div class="loc-search-wrap">
    <div class="loc-search">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
      </svg>
      <input type="text" id="searchInput" placeholder="Cari nama atau alamat gereja…">
      <div class="loc-search-count" id="searchCount"></div>
    </div>
  </div>

  <!-- MOBILE TABS -->
  <div class="loc-tabs">
    <button class="loc-tab active" onclick="switchTab('list',this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
      Daftar
    </button>
    <button class="loc-tab" onclick="switchTab('map',this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/></svg>
      Peta
    </button>
  </div>

  <!-- BODY -->
  <div class="loc-body">
    <!-- LIST PANEL -->
    <div class="loc-panel active" id="listPanel">
      <div class="loc-list-header">
        <h3>Lokasi Gereja</h3>
        <div class="loc-count-badge" id="countBadge">
          <span id="countNum">–</span> Cabang
        </div>
      </div>
      <!-- Skeleton loaders -->
      <div class="loc-list" id="branchList">
        <?php for ($s = 0; $s < 4; $s++): ?>
        <div class="skeleton-card">
          <div class="skeleton sk-line sk-line-title"></div>
          <div class="skeleton sk-line sk-line-addr"></div>
          <div class="skeleton sk-line sk-line-addr2"></div>
          <div class="skeleton sk-btn"></div>
        </div>
        <?php endfor; ?>
      </div>
      <div class="loc-empty" id="emptyState">
        <div class="loc-empty-icon">🔍</div>
        <p>Tidak ada gereja yang cocok dengan pencarian Anda.</p>
      </div>
    </div>

    <!-- MAP PANEL -->
    <div class="loc-panel active" id="mapPanel">
      <div class="loc-map-wrap">
        <div class="loc-map-header">
          <div class="loc-map-header-left">
            <div class="loc-map-dot"></div>
            <div>
              <div class="loc-map-label">Peta Lokasi ESC</div>
              <div class="loc-map-sublabel" id="mapSubLabel">Memuat lokasi…</div>
            </div>
          </div>
          <button class="loc-map-reset" onclick="resetMapView()">Tampilkan Semua</button>
        </div>
        <div id="map"></div>
      </div>
    </div>
  </div>

</main>

<?php $this->load->view('template/festavalive/footer'); ?>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
  var idmenu = "<?php echo $this->encrypt->encode($menu) ?>";
  const centerMap = [0.03718835906169617, 110.35766601562501];
  var map = L.map('map').setView(centerMap, 8);
  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
    attribution: '© OpenStreetMap © CARTO',
    subdomains: 'abcd', maxZoom: 19
  }).addTo(map);

  var allData    = [];
  var allMarkers = [];

  function initMap() {
  $.ajax({
    url: '<?php echo site_url('ourlocation/getcabang') ?>',
    type: 'GET',
    dataType: 'json'
  }).done(function(dataCabang) {
    $('#branchList').empty();
    $('#emptyState').hide();

    if (!dataCabang || !dataCabang.length) {
      $('#branchList').html('<div class="loc-empty" style="display:block"><div class="loc-empty-icon">📍</div><p>Belum ada lokasi tersedia.</p></div>');
      return;
    }

    allData = dataCabang;
    $('#countNum').text(dataCabang.length);
    $('#mapSubLabel').text(dataCabang.length + ' lokasi ditemukan');

    // ✅ Icon marker dengan logo ESC
    const escIcon = L.icon({
      iconUrl: 'https://myesc.id/myesc.id/assets/FestavaLive/video/esc10.png',
      iconSize: [36, 36],
      iconAnchor: [18, 36],
      popupAnchor: [0, -36]
    });

    dataCabang.forEach((cabang, i) => {
      const lat = parseFloat(cabang.latitude);
      const lng = parseFloat(cabang.longitude);

      // Gunakan icon yang sama untuk semua marker
      const marker = L.marker([lat, lng], { icon: escIcon }).addTo(map)
        .bindPopup(`<div style="font-family:'Figtree',sans-serif;padding:4px"><strong style="font-size:13px;color:#111">${cabang.namacabang}</strong><br><span style="font-size:12px;color:#666;line-height:1.5">${cabang.alamatlengkap}</span></div>`);
      allMarkers.push(marker);

      const card = `
        <div class="loc-card ${i === 0 ? 'active' : ''}" id="card-${i}" onclick="focusMap(${lat},${lng},this,${i})">
          <div class="loc-card__top">
            <div class="loc-card__pin">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
              </svg>
            </div>
            <div class="loc-card__meta">
              <div class="loc-card__num-badge"></div>
              <div class="loc-card__title">${cabang.namacabang}</div>
            </div>
          </div>
          <div class="loc-card__address">${cabang.alamatlengkap}</div>
          <div class="loc-card__actions">
            <button class="loc-card__btn-dir" onclick="event.stopPropagation();openDir(${lat},${lng})">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polygon points="3 11 22 2 13 21 11 13 3 11"/>
              </svg>
              Petunjuk Arah
            </button>
            <a class="loc-card__btn-detail" href="<?php echo site_url('ourlocation/detail/') ?>${cabang.namacabang_slug}/${idmenu}">
              Detail →
            </a>
          </div>
        </div>`;
      $('#branchList').append(card);
    });

    if (dataCabang[0]) {
      map.setView([parseFloat(dataCabang[0].latitude), parseFloat(dataCabang[0].longitude)], 12);
      allMarkers[0] && allMarkers[0].openPopup();
    }
  });
}

  function openDir(lat, lng) {
    window.open('https://www.google.com/maps/dir/?api=1&destination=' + lat + ',' + lng, '_blank');
  }

  function focusMap(lat, lng, el, idx) {
    map.setView([lat, lng], 15, { animate: true });
    document.querySelectorAll('.loc-card').forEach(c => c.classList.remove('active'));
    if (el) el.classList.add('active');
    if (allMarkers[idx]) allMarkers[idx].openPopup();
    // Mobile: auto-switch to map tab
    if (window.innerWidth <= 900) switchTab('map', document.querySelectorAll('.loc-tab')[1]);
  }

  function resetMapView() {
    map.setView(centerMap, 8, { animate: true });
    document.querySelectorAll('.loc-card').forEach(c => c.classList.remove('active'));
  }

  // Search / filter
  document.getElementById('searchInput').addEventListener('input', function() {
    const q = this.value.trim().toLowerCase();
    const cards = document.querySelectorAll('.loc-card');
    let visible = 0;
    cards.forEach((card, i) => {
      const name = (allData[i]?.namacabang || '').toLowerCase();
      const addr = (allData[i]?.alamatlengkap || '').toLowerCase();
      const match = !q || name.includes(q) || addr.includes(q);
      card.style.display = match ? '' : 'none';
      if (match) visible++;
    });
    document.getElementById('searchCount').textContent = q ? visible + ' hasil' : '';
    document.getElementById('emptyState').style.display = (q && visible === 0) ? 'block' : 'none';
  });

  // Mobile tab switcher
  function switchTab(tab, btn) {
    document.querySelectorAll('.loc-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    if (tab === 'list') {
      document.getElementById('listPanel').classList.add('active');
      document.getElementById('mapPanel').classList.remove('active');
    } else {
      document.getElementById('mapPanel').classList.add('active');
      document.getElementById('listPanel').classList.remove('active');
      setTimeout(() => map.invalidateSize(), 100);
    }
  }

  initMap();
</script>
</body>