<?php $this->load->view('template/festavalive/header'); ?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Figtree:wght@400;500;600;700&display=swap');

  :root {
    --cream: #f5f0e8;
    --orange: #e8621a;
    --brown: #2c1a0e;
    --brown-mid: #5c3d2e;
    --gray: #888;
    --gray-light: #e8e4dc;
    --white: #ffffff;
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Figtree', sans-serif;
    background-color: var(--cream);
    color: var(--brown);
  }

  .cal-hero {
    padding: 80px 60px 40px;
    max-width: 1200px;
    margin: 0 auto;
  }
  .cal-hero .label {
    font-size: 11px; font-weight: 700;
    letter-spacing: 3px; text-transform: uppercase;
    color: var(--orange); margin-bottom: 16px;
  }
  .cal-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(42px, 6vw, 72px);
    font-weight: 900; line-height: 1.05; color: var(--brown);
  }
  .cal-hero h1 span { color: var(--orange); }
  .cal-hero p {
    margin-top: 20px; font-size: 16px; color: var(--brown-mid);
    max-width: 420px; line-height: 1.7;
  }

  .cal-controls {
    max-width: 1200px; margin: 0 auto;
    padding: 0 60px 24px;
    display: flex; align-items: center;
    justify-content: space-between; flex-wrap: wrap; gap: 12px;
  }
  .month-nav { display: flex; align-items: center; gap: 12px; }
  .month-nav h2 {
    font-family: 'Playfair Display', serif;
    font-size: 22px; font-weight: 700; color: var(--brown); min-width: 175px;
  }
  .nav-btn {
    width: 36px; height: 36px; border-radius: 50%;
    border: 1.5px solid var(--gray-light); background: white;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    transition: all 0.2s; color: var(--brown); font-size: 18px;
    text-decoration: none; line-height: 1;
  }
  .nav-btn:hover { border-color: var(--orange); color: var(--orange); background: #fff7f3; }

  .view-toggle {
    display: flex; gap: 8px; background: var(--white);
    border-radius: 50px; padding: 4px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
  }
  .view-toggle button {
    border: none; cursor: pointer; padding: 8px 20px; border-radius: 50px;
    font-family: 'Figtree', sans-serif; font-size: 14px; font-weight: 600;
    transition: all 0.2s; background: transparent; color: var(--gray);
  }
  .view-toggle button.active {
    background: var(--orange); color: white;
    box-shadow: 0 2px 8px rgba(232,98,26,0.35);
  }

  .cal-main { max-width: 1200px; margin: 0 auto; padding: 0 60px 60px; }
  #monthView { display: block; }
  #listView  { display: none; }

  /* === MONTH GRID === */
  .month-grid {
    background: white; border-radius: 16px; overflow: hidden;
    box-shadow: 0 2px 20px rgba(0,0,0,0.07);
  }
  .month-grid-header {
    display: grid; grid-template-columns: repeat(7, 1fr);
    background: var(--gray-light);
  }
  .month-grid-header div {
    padding: 12px 8px; text-align: center;
    font-size: 11px; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--brown-mid);
  }
  .month-grid-body { display: grid; grid-template-columns: repeat(7, 1fr); }
  .day-cell {
    min-height: 110px; padding: 10px 8px;
    border-right: 1px solid var(--gray-light);
    border-bottom: 1px solid var(--gray-light);
  }
  .day-cell:nth-child(7n) { border-right: none; }
  .day-num { font-size: 14px; font-weight: 600; color: var(--brown-mid); margin-bottom: 6px; }
  .day-cell.is-sunday .day-num,
  .day-cell.is-today  .day-num { color: var(--orange); font-weight: 700; }
  .day-cell.other-month { background: #fafaf8; }
  .day-cell.other-month .day-num { color: #ccc; }

  .event-chip {
    display: block; font-size: 10px; font-weight: 600;
    padding: 3px 7px; border-radius: 4px; margin-bottom: 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    text-transform: uppercase; letter-spacing: 0.5px; color: white;
  }
  /* fallback colors jika warnapenjadwalan kosong */
  .chip-ibadah   { background: #e8621a; }
  .chip-doa      { background: #c49a14; }
  .chip-dc       { background: #2d6b5e; }
  .chip-nextstep { background: #1a6b3c; }
  .chip-youth    { background: #5b4a8a; }
  .chip-default  { background: #888; }

  /* === LEGEND === */
  .cal-legend {
    display: flex; justify-content: center;
    gap: 24px; margin-top: 20px; flex-wrap: wrap;
  }
  .legend-item {
    display: flex; align-items: center; gap: 7px;
    font-size: 11px; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: var(--brown-mid);
  }
  .legend-dot { width: 10px; height: 10px; border-radius: 50%; }

  /* === LIST VIEW === */
  .list-controls {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
  }
  .filter-group { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
  .filter-label {
    font-size: 12px; font-weight: 700; letter-spacing: 1px;
    text-transform: uppercase; color: var(--gray);
  }
  .filter-btn {
    border: 1.5px solid var(--gray-light); background: white;
    border-radius: 50px; padding: 6px 16px; font-size: 13px; font-weight: 600;
    font-family: 'Figtree', sans-serif; cursor: pointer;
    transition: all 0.2s; color: var(--brown-mid);
  }
  .filter-btn.active, .filter-btn:hover {
    background: var(--orange); border-color: var(--orange); color: white;
  }

  .event-table {
    background: white; border-radius: 16px; overflow: hidden;
    box-shadow: 0 2px 20px rgba(0,0,0,0.07); width: 100%;
  }
  .event-table-header {
    display: grid; grid-template-columns: 2.5fr 1.5fr 1.5fr 1fr;
    padding: 14px 24px; background: var(--gray-light);
  }
  .event-table-header span {
    font-size: 11px; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase; color: var(--brown-mid);
  }
  .event-row {
    display: grid; grid-template-columns: 2.5fr 1.5fr 1.5fr 1fr;
    padding: 18px 24px; border-bottom: 1px solid var(--gray-light);
    align-items: center; transition: background 0.15s;
  }
  .event-row:last-child { border-bottom: none; }
  .event-row:hover { background: #fdfaf7; }

  .event-name-cell { display: flex; align-items: center; gap: 12px; }
  .event-color-bar { width: 5px; height: 46px; border-radius: 3px; flex-shrink: 0; }
  .event-name { font-weight: 700; font-size: 15px; color: var(--brown); }
  .event-subtitle { font-size: 12px; color: var(--gray); margin-top: 2px; }
  .event-tema { font-size: 12px; color: var(--orange); font-weight: 600; margin-top: 2px; }
  .event-datetime { font-size: 14px; color: var(--brown-mid); font-weight: 600; }
  .event-time-sub { font-size: 12px; color: var(--gray); margin-top: 2px; }

  .cat-badge {
    display: inline-block; padding: 4px 12px; border-radius: 50px;
    font-size: 11px; font-weight: 700; letter-spacing: 0.5px;
    text-transform: uppercase; color: white;
  }

  .empty-state { text-align: center; padding: 60px 20px; color: var(--gray); }
  .empty-state .icon { font-size: 48px; margin-bottom: 16px; }

  @media (max-width: 768px) {
    /* Layout */
    .cal-hero, .cal-controls, .cal-main { padding-left: 12px; padding-right: 12px; }
    .cal-hero { padding-top: 36px; padding-bottom: 20px; }
    .cal-hero h1 { font-size: 32px; }
    .cal-hero p  { font-size: 14px; }
    .cal-controls { flex-direction: column; align-items: flex-start; gap: 10px; }
    .month-nav h2 { min-width: 120px; font-size: 17px; }

    /* Month grid — compact */
    .month-grid-header div { padding: 8px 2px; font-size: 10px; letter-spacing: 0.5px; }

    .day-cell {
      min-height: 48px;
      padding: 5px 3px;
      cursor: pointer;
    }
    .day-cell.has-event { background: #fffdf9; }
    .day-cell.is-today  { outline: 2px solid var(--orange); outline-offset: -2px; }

    .day-num { font-size: 12px; margin-bottom: 4px; text-align: center; }

    /* Sembunyikan chip teks di mobile — ganti jadi dots */
    .event-chip { display: none !important; }

    /* Dot container */
    .dot-row {
      display: flex; flex-wrap: wrap;
      justify-content: center; gap: 3px;
    }
    .event-dot {
      width: 7px; height: 7px;
      border-radius: 50%; flex-shrink: 0;
    }

    /* Panel detail event (slide up dari bawah) */
    .mobile-event-panel {
      display: none;
      position: fixed;
      bottom: 0; left: 0; right: 0;
      background: white;
      border-radius: 20px 20px 0 0;
      box-shadow: 0 -4px 30px rgba(0,0,0,0.18);
      z-index: 9999;
      max-height: 60vh;
      overflow-y: auto;
      padding: 0 0 24px;
      transform: translateY(100%);
      transition: transform 0.3s ease;
    }
    .mobile-event-panel.open {
      display: block;
      transform: translateY(0);
    }
    .panel-handle {
      width: 40px; height: 4px; border-radius: 2px;
      background: #ddd; margin: 12px auto 0;
    }
    .panel-date-title {
      font-family: 'Playfair Display', serif;
      font-size: 16px; font-weight: 700;
      color: var(--brown); padding: 14px 20px 10px;
      border-bottom: 1px solid var(--gray-light);
    }
    .panel-event-item {
      display: flex; align-items: flex-start;
      gap: 12px; padding: 14px 20px;
      border-bottom: 1px solid var(--gray-light);
    }
    .panel-event-item:last-child { border-bottom: none; }
    .panel-event-bar {
      width: 4px; min-height: 44px; border-radius: 2px; flex-shrink: 0; margin-top: 2px;
    }
    .panel-event-name  { font-weight: 700; font-size: 14px; color: var(--brown); }
    .panel-event-kelas { font-size: 12px; color: var(--gray); margin-top: 2px; }
    .panel-event-time  { font-size: 12px; color: var(--orange); font-weight: 600; margin-top: 4px; }
    .panel-event-jenis {
      font-size: 10px; font-weight: 700; text-transform: uppercase;
      letter-spacing: 0.5px; margin-top: 4px;
      display: inline-block; padding: 2px 8px; border-radius: 50px; color: white;
    }
    .panel-overlay {
      display: none; position: fixed; inset: 0;
      background: rgba(0,0,0,0.3); z-index: 9998;
    }
    .panel-overlay.open { display: block; }

    /* List view di mobile */
    .event-table-header,
    .event-row { grid-template-columns: 2fr 1.5fr; }
    .event-row > *:nth-child(3),
    .event-row > *:nth-child(4),
    .event-table-header > *:nth-child(3),
    .event-table-header > *:nth-child(4) { display: none; }
    .event-row { padding: 14px 16px; }
    .event-table-header { padding: 10px 16px; }
  }
</style>

<body>
<?php $this->load->view('template/festavalive/topmenu'); ?>

<?php
// ============================================================
// HELPER FUNCTIONS
// ============================================================

/**
 * Map jenisjadwal enum ke key sederhana untuk CSS class & filter
 * Sesuaikan nilai string jika enum DB berbeda
 */
function getJenisKey($jenis)
{
    $j = strtolower(trim($jenis ?? ''));
    if (strpos($j, 'ibadah') !== false)
        return 'ibadah';
    if (strpos($j, 'doa') !== false || strpos($j, 'fasting') !== false || strpos($j, 'menara') !== false)
        return 'doa';
    if (strpos($j, 'disciple') !== false || $j === 'dc')
        return 'dc';
    if (strpos($j, 'next step') !== false)
        return 'nextstep';
    if (strpos($j, 'youth') !== false || strpos($j, 'remaja') !== false || strpos($j, 'pemuda') !== false)
        return 'youth';
    return 'default';
}

function namaBulanID($m)
{
    $a = ['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
        '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
        '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'];
    return $a[str_pad((int) $m, 2, '0', STR_PAD_LEFT)] ?? '';
}

function namaBulanShortID($m)
{
    $a = ['01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr',
        '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Agu',
        '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Des'];
    return $a[str_pad((int) $m, 2, '0', STR_PAD_LEFT)] ?? '';
}

function hariID($ts)
{
    $a = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
    return $a[date('l', $ts)] ?? date('l', $ts);
}

// Fallback color map per jenis key
$colorMap = [
    'ibadah' => '#e8621a',
    'doa' => '#c49a14',
    'dc' => '#2d6b5e',
    'nextstep' => '#1a6b3c',
    'youth' => '#5b4a8a',
    'default' => '#888888',
];

// ============================================================
// DATA PREP
// ============================================================
$bulanInt = (int) $bulanEvent;
$tahunInt = (int) $tahunEvent;
$today = date('Y-m-d');

$eventMap = [];  // tgljadwal => [rows]
$allEvents = [];
$jenisFound = [];  // jenis key yang ada di bulan ini

if ($rsEvent->num_rows() > 0) {
    foreach ($rsEvent->result() as $row) {
        $tgl = date('Y-m-d', strtotime($row->tgljadwal));
        $eventMap[$tgl][] = $row;
        $allEvents[] = $row;
        $jk = getJenisKey($row->jenisjadwal ?? '');
        $jenisFound[$jk] = $row->jenisjadwal ?? $jk;
    }
}

// Grid calc
$firstDay = mktime(0, 0, 0, $bulanInt, 1, $tahunInt);
$startDow = (int) date('w', $firstDay);
$daysInMonth = (int) date('t', $firstDay);
$prevTs = ($bulanInt == 1) ? mktime(0, 0, 0, 12, 1, $tahunInt - 1) : mktime(0, 0, 0, $bulanInt - 1, 1, $tahunInt);
$daysInPrev = (int) date('t', $prevTs);
$bulanLabel = namaBulanID($bulanInt) . ' ' . $tahunInt;

// Helper: resolve warna chip
function resolveColor($warnapenjadwalan, $jenisKey, $colorMap)
{
    $w = ltrim(trim($warnapenjadwalan ?? ''), '#');
    if (preg_match('/^[0-9A-Fa-f]{6}$/', $w))
        return '#' . $w;
    return $colorMap[$jenisKey] ?? '#888';
}
?>

<!-- HERO -->
<!-- <div class="cal-hero">
  <div class="label">Our Calendar</div>
  <h1>Gathering in <span>Spirit</span><br>and Truth.</h1>
  <p>Temukan kesempatan untuk terhubung, bertumbuh, dan melayani dalam komunitas. Dari ibadah mingguan hingga pertemuan spesial.</p>
</div> -->

<!-- CONTROLS -->
<div class="cal-controls">
  <div class="month-nav">
    <a href="<?php echo site_url('kalender/lihatbulan/' . $bulanSebelum . '/' . $tahunSebelum . '/' . $this->encrypt->encode($menu)) ?>" class="nav-btn">&#8249;</a>
    <h2><?php echo $bulanLabel ?></h2>
    <a href="<?php echo site_url('kalender/lihatbulan/' . $bulanBerikut . '/' . $tahunBerikut . '/' . $this->encrypt->encode($menu)) ?>" class="nav-btn">&#8250;</a>
  </div>
  <div class="view-toggle">
    <button id="btnMonth" class="active" onclick="switchView('month')">&#128197; Month View</button>
    <button id="btnList"  onclick="switchView('list')">&#9776; List View</button>
  </div>
</div>

<!-- MAIN -->
<div class="cal-main">

  <!-- ====== MONTH VIEW ====== -->
  <div id="monthView">
    <div class="month-grid">
      <div class="month-grid-header">
        <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div>
        <div>Kam</div><div>Jum</div><div>Sab</div>
      </div>
      <div class="month-grid-body">

        <?php
        // Sel kosong awal (bulan sebelumnya)
        for ($i = 0; $i < $startDow; $i++) {
            $d = $daysInPrev - ($startDow - $i - 1);
            echo '<div class="day-cell other-month"><div class="day-num">' . $d . '</div></div>';
        }

        // Hari bulan ini
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dateKey = $tahunInt . '-' . str_pad($bulanInt, 2, '0', STR_PAD_LEFT) . '-' . str_pad($d, 2, '0', STR_PAD_LEFT);
            $ts = mktime(0, 0, 0, $bulanInt, $d, $tahunInt);
            $dow = (int) date('w', $ts);
            $cls = 'day-cell';
            if ($dow === 0)
                $cls .= ' is-sunday';
            if ($dateKey === $today)
                $cls .= ' is-today';

            // Siapkan data event untuk panel mobile (JSON)
            $mobileData = [];
            if (isset($eventMap[$dateKey])) {
                foreach ($eventMap[$dateKey] as $ev) {
                    $jkEv = getJenisKey($ev->jenisjadwal ?? '');
                    $mobileData[] = [
                        'nama' => $ev->namaevent ?? '',
                        'kelas' => $ev->namakelas ?? '',
                        'jam' => date('H:i', strtotime($ev->jammulai)) . ' WIB' . (!empty($ev->jamselesai) ? ' - ' . date('H:i', strtotime($ev->jamselesai)) . ' WIB' : ''),
                        'jenis' => $ev->jenisjadwal ?? '',
                        'color' => resolveColor($ev->warnapenjadwalan ?? '', $jkEv, $colorMap),
                    ];
                }
                $cls .= ' has-event';
            }

            $dataAttr = !empty($mobileData) ? ' data-events="' . htmlspecialchars(json_encode($mobileData, JSON_UNESCAPED_UNICODE)) . '" data-label="' . hariID($ts) . ', ' . $d . ' ' . namaBulanShortID($bulanInt) . '"' : '';

            echo '<div class="' . $cls . '"' . $dataAttr . '>';
            echo '<div class="day-num">' . $d . '</div>';

            if (isset($eventMap[$dateKey])) {
                $evList = $eventMap[$dateKey];
                $total = count($evList);
                $shown = 0;

                // Desktop: chip teks
                foreach ($evList as $ev) {
                    if ($shown >= 3) {
                        echo '<div class="event-chip chip-default">+' . ($total - 3) . ' lagi</div>';
                        break;
                    }
                    $jk = getJenisKey($ev->jenisjadwal ?? '');
                    $color = resolveColor($ev->warnapenjadwalan ?? '', $jk, $colorMap);
                    echo '<div class="event-chip" style="background:' . htmlspecialchars($color) . '" title="' . htmlspecialchars($ev->namaevent) . '">' . htmlspecialchars($ev->namaevent) . '</div>';
                    $shown++;
                }

                // Mobile: dot warna (maks 4 dot)
                echo '<div class="dot-row">';
                $dotShown = 0;
                foreach ($evList as $ev) {
                    if ($dotShown >= 4)
                        break;
                    $jk = getJenisKey($ev->jenisjadwal ?? '');
                    $color = resolveColor($ev->warnapenjadwalan ?? '', $jk, $colorMap);
                    echo '<div class="event-dot" style="background:' . htmlspecialchars($color) . '"></div>';
                    $dotShown++;
                }
                echo '</div>';
            }
            echo '</div>';
        }

        // Sel kosong akhir
        $total = $startDow + $daysInMonth;
        $remaining = (7 - ($total % 7)) % 7;
        for ($i = 1; $i <= $remaining; $i++) {
            echo '<div class="day-cell other-month"><div class="day-num">' . $i . '</div></div>';
        }
        ?>

      </div>
    </div>

    <!-- Legend -->
    <div class="cal-legend">
      <?php
$legendLabels = [
    'ibadah' => 'Ibadah / Worship',
    'doa' => 'Doa Bersama',
    'dc' => 'Disciple Community',
    'nextstep' => 'Next Step',
    'youth' => 'Youth / Pemuda',
    'default' => 'Lainnya',
];
foreach ($jenisFound as $jk => $jv) {
    $lbl = $legendLabels[$jk] ?? ucfirst($jk);
    $color = $colorMap[$jk] ?? '#888';
    echo '<div class="legend-item"><div class="legend-dot" style="background:' . $color . '"></div>' . htmlspecialchars($lbl) . '</div>';
}
?>
    </div>
  </div><!-- /monthView -->


  <!-- ====== LIST VIEW ====== -->
  <div id="listView">
    <div class="list-controls">
      <div class="filter-group">
        <span class="filter-label">Filter by:</span>
        <button class="filter-btn active" data-filter="all">All Events</button>
        <?php
        $filterLabels = [
            'ibadah' => 'Ibadah',
            'doa' => 'Doa Bersama',
            'dc' => 'Disciple Community',
            'nextstep' => 'Next Step',
            'youth' => 'Youth',
            'default' => 'Lainnya',
        ];
        foreach ($jenisFound as $jk => $jv) {
            $lbl = $filterLabels[$jk] ?? ucfirst($jk);
            echo '<button class="filter-btn" data-filter="' . htmlspecialchars($jk) . '">' . htmlspecialchars($lbl) . '</button>';
        }
        ?>
      </div>
    </div>

    <div class="event-table">
      <div class="event-table-header">
        <span>Event Name</span>
        <span>Tanggal &amp; Jam</span>
        <span>Jenis Jadwal</span>
        <span>Tema</span>
      </div>

      <?php if (count($allEvents) > 0): ?>
        <?php
        foreach ($allEvents as $row):
            $jk = getJenisKey($row->jenisjadwal ?? '');
            $color = resolveColor($row->warnapenjadwalan ?? '', $jk, $colorMap);
            $ts = strtotime($row->tgljadwal);
            $tglFmt = hariID($ts) . ', ' . date('d', $ts) . ' ' . namaBulanShortID(date('m', $ts)) . ' ' . date('Y', $ts);
            $jamMulai = date('H:i', strtotime($row->jammulai));
            $jamSelesai = !empty($row->jamselesai) ? date('H:i', strtotime($row->jamselesai)) : '';
            ?>
        <div class="event-row" data-type="<?php echo htmlspecialchars($jk) ?>">

          <!-- Nama event -->
          <div class="event-name-cell">
            <div class="event-color-bar" style="background:<?php echo $color ?>"></div>
            <div>
              <div class="event-name"><?php echo htmlspecialchars($row->namaevent) ?></div>
              <?php if (!empty($row->namakelas)): ?>
                <div class="event-subtitle"><?php echo htmlspecialchars($row->namakelas) ?></div>
              <?php endif ?>
              <?php if (!empty($row->tema)): ?>
                <div class="event-tema"><?php echo htmlspecialchars($row->tema) ?></div>
              <?php endif ?>
            </div>
          </div>

          <!-- Tanggal & Jam -->
          <div>
            <div class="event-datetime"><?php echo $tglFmt ?></div>
            <div class="event-time-sub">
              <?php echo $jamMulai ?> WIB
              <?php if ($jamSelesai): echo '&ndash; ' . $jamSelesai . ' WIB'; endif ?>
            </div>
          </div>

          <!-- Jenis -->
          <div>
            <span class="cat-badge" style="background:<?php echo $color ?>">
              <?php echo htmlspecialchars($row->jenisjadwal ?? '-') ?>
            </span>
          </div>

          <!-- Subtema -->
          <div style="font-size:13px; color:var(--brown-mid); line-height:1.5">
            <?php echo !empty($row->subtema) ? htmlspecialchars($row->subtema) : '<span style="color:#ccc">&mdash;</span>' ?>
          </div>

        </div>
        <?php endforeach ?>

      <?php else: ?>
        <div class="empty-state">
          <div class="icon">&#128197;</div>
          <p>Tidak ada jadwal event untuk <strong><?php echo $bulanLabel ?></strong>.</p>
        </div>
      <?php endif ?>

    </div><!-- .event-table -->
  </div><!-- /listView -->

</div><!-- .cal-main -->

<!-- ====== MOBILE EVENT PANEL ====== -->
<div class="panel-overlay" id="panelOverlay"></div>
<div class="mobile-event-panel" id="mobilePanel">
  <div class="panel-handle"></div>
  <div class="panel-date-title" id="panelDateTitle"></div>
  <div id="panelEventList"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// ===== Toggle Month / List View =====
function switchView(view) {
  document.getElementById('monthView').style.display = view === 'month' ? 'block' : 'none';
  document.getElementById('listView').style.display  = view === 'list'  ? 'block' : 'none';
  document.getElementById('btnMonth').classList.toggle('active', view === 'month');
  document.getElementById('btnList').classList.toggle('active', view === 'list');
  try { localStorage.setItem('calView_esc', view); } catch(e) {}
}

(function() {
  try { if (localStorage.getItem('calView_esc') === 'list') switchView('list'); } catch(e) {}
})();

// ===== Filter list view =====
document.querySelectorAll('.filter-btn').forEach(function(btn) {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
    this.classList.add('active');
    var filter = this.getAttribute('data-filter');
    document.querySelectorAll('.event-row').forEach(function(row) {
      row.style.display = (filter === 'all' || row.getAttribute('data-type') === filter) ? '' : 'none';
    });
  });
});

// ===== Mobile: klik day-cell buka panel =====
var panel   = document.getElementById('mobilePanel');
var overlay = document.getElementById('panelOverlay');

function openPanel(label, events) {
  document.getElementById('panelDateTitle').textContent = label;
  var html = '';
  events.forEach(function(ev) {
    html += '<div class="panel-event-item">'
          +   '<div class="panel-event-bar" style="background:'+ev.color+'"></div>'
          +   '<div>'
          +     '<div class="panel-event-name">'+escHtml(ev.nama)+'</div>'
          +     (ev.kelas ? '<div class="panel-event-kelas">'+escHtml(ev.kelas)+'</div>' : '')
          +     '<div class="panel-event-time">'+escHtml(ev.jam)+'</div>'
          +     '<span class="panel-event-jenis" style="background:'+ev.color+'">'+escHtml(ev.jenis)+'</span>'
          +   '</div>'
          + '</div>';
  });
  document.getElementById('panelEventList').innerHTML = html;
  panel.classList.add('open');
  overlay.classList.add('open');
}

function closePanel() {
  panel.classList.remove('open');
  overlay.classList.remove('open');
}

function escHtml(s) {
  return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// Hanya aktif di mobile (layar ≤ 768px)
document.querySelectorAll('.day-cell.has-event').forEach(function(cell) {
  cell.addEventListener('click', function() {
    if (window.innerWidth > 768) return; // desktop: tidak buka panel
    var raw    = this.getAttribute('data-events');
    var label  = this.getAttribute('data-label');
    if (!raw) return;
    try {
      var events = JSON.parse(raw);
      openPanel(label, events);
    } catch(e) {}
  });
});

overlay.addEventListener('click', closePanel);

// Swipe down untuk tutup panel
var startY = 0;
panel.addEventListener('touchstart', function(e) { startY = e.touches[0].clientY; }, {passive:true});
panel.addEventListener('touchend',   function(e) {
  if (e.changedTouches[0].clientY - startY > 60) closePanel();
}, {passive:true});
</script>

<?php $this->load->view('template/festavalive/footer'); ?>