<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

// Konfigurasi kartu aktivitas (key harus sama dengan _sumberData() di controller)
$kartuAktivitas = array(
    array('key' => 'pendaftar',      'label' => 'Pendaftar',       'desc' => 'Pendaftaran akun baru',    'icon' => 'fa-user-plus',  'warna' => '#17a2b8'),
    array('key' => 'jemaatbaru',     'label' => 'Jemaat Baru',     'desc' => 'Status jemaat baru',        'icon' => 'fa-user-check', 'warna' => '#007bff'),
    array('key' => 'pernikahan',     'label' => 'Pernikahan',      'desc' => 'Dari akta nikah',           'icon' => 'fa-ring',       'warna' => '#dc3545'),
    array('key' => 'penyerahananak', 'label' => 'Penyerahan Anak', 'desc' => 'Dari akta penyerahan anak', 'icon' => 'fa-baby',       'warna' => '#fd7e14'),
    array('key' => 'baptis',         'label' => 'Baptis',          'desc' => 'Dari akta baptisan',        'icon' => 'fa-water',      'warna' => '#6f42c1'),
);
?>

<style>
    .dc-hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 60%, #3a7bd5 100%);
        color: #fff;
        border-radius: 14px;
        padding: 1.5rem 1.5rem 1.25rem;
        box-shadow: 0 6px 18px rgba(30, 60, 114, .25);
    }
    .dc-hero .dc-stat {
        background: rgba(255, 255, 255, .12);
        border-radius: 10px;
        padding: .75rem 1rem;
        height: 100%;
    }
    .dc-hero .dc-stat-val { font-size: 1.5rem; font-weight: 700; line-height: 1.1; }
    .dc-hero .dc-stat-label { font-size: .8rem; opacity: .85; }

    .dc-card { border: 0; border-radius: 12px; box-shadow: 0 2px 10px rgba(0, 0, 0, .06); }

    .dc-kpi {
        cursor: pointer;
        transition: transform .15s ease, box-shadow .15s ease, opacity .2s ease, filter .2s ease;
        user-select: none;
    }
    .dc-kpi:hover, .dc-kpi:focus {
        transform: translateY(-3px);
        box-shadow: 0 8px 22px rgba(0, 0, 0, .12);
        outline: none;
    }
    .dc-kpi.is-off { opacity: .4; filter: grayscale(.7); }
    .dc-kpi .dc-ico {
        width: 46px; height: 46px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.15rem; flex-shrink: 0;
    }
    .dc-kpi .dc-val { font-size: 1.75rem; font-weight: 700; line-height: 1; color: #212529; }
    .dc-kpi .dc-label { font-size: .85rem; font-weight: 600; color: #495057; }
    .dc-kpi .dc-trend { font-size: .75rem; }
    .dc-kpi .dc-bar { height: 4px; border-radius: 4px; margin-top: .75rem; }

    .dc-up   { color: #28a745; }
    .dc-down { color: #dc3545; }
    .dc-flat { color: #6c757d; }

    .dc-toolbar .btn-group-toggle .btn { font-size: .8rem; }
    .dc-insight {
        background: #f1f6ff; color: #1e3c72; border-radius: 8px;
        padding: .4rem .75rem; font-size: .85rem;
    }

    .dc-chart-box { position: relative; height: 360px; }
    .dc-donut-box { position: relative; height: 300px; }
    .dc-donut-center {
        position: absolute; top: 42%; left: 50%;
        transform: translate(-50%, -50%);
        text-align: center; pointer-events: none;
    }

    .dc-table th { white-space: nowrap; font-size: .85rem; }
    .dc-table td { font-size: .9rem; }
    .dc-table tbody tr:hover { background: #f8fbff; }
    .dc-table .dc-peak { font-weight: 700; color: #1e3c72; }
    .dc-table tfoot td { font-weight: 700; background: #f4f6f9; }

    .dc-loading {
        position: absolute; inset: 0;
        background: rgba(255, 255, 255, .7);
        display: none; align-items: center; justify-content: center;
        z-index: 5; border-radius: 12px;
    }
    .dc-loading.show { display: flex; }

    @media (max-width: 576px) {
        .dc-kpi .dc-val { font-size: 1.4rem; }
        .dc-chart-box { height: 280px; }
    }
</style>

<div class="row" id="toni-breadcrumb">
    <div class="col-12">
        <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-1">
            <li class="breadcrumb-item active">Dashboard Care</li>
        </ol>
        <h4 class="text-dark mb-0">Dashboard Care</h4>
    </div>
</div>

<div class="row mt-3" id="toni-content">
    <div class="col-12">

        <?php
        $pesan = $this->session->flashdata('pesan');
        if (!empty($pesan)) echo $pesan;
        ?>

        <!-- ================= HERO ================= -->
        <div class="dc-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="mb-2 mb-md-0">
                    <h5 class="mb-1 font-weight-bold">Ringkasan Data Gereja</h5>
                    <small>Data tahun <span class="lbl-tahun"><?php echo $tahun; ?></span>, dibandingkan dengan <span class="lbl-tahunlalu"><?php echo $tahun - 1; ?></span></small>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <select id="filterTahun" class="form-control form-control-sm mr-2 mb-1" style="width:110px;">
                        <?php foreach ($daftartahun as $th): ?>
                            <option value="<?php echo $th; ?>" <?php echo $th == $tahun ? 'selected' : ''; ?>><?php echo $th; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="btn btn-light btn-sm mr-1 mb-1" id="btnRefresh" title="Muat ulang">
                        <i class="fas fa-sync-alt" id="iconRefresh"></i>
                    </button>
                    <button type="button" class="btn btn-success btn-sm mr-1 mb-1" onclick="showModalCetak('excel')">
                        <i class="fas fa-file-excel"></i> Excel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm mb-1" onclick="showModalCetak('pdf')">
                        <i class="fas fa-file-pdf"></i> PDF
                    </button>
                </div>
            </div>

            <div class="row">
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dc-stat">
                        <div class="dc-stat-val" data-animate="heroJemaat">0</div>
                        <div class="dc-stat-label"><i class="fas fa-church"></i> Jemaat Aktif</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dc-stat">
                        <div class="dc-stat-val" data-animate="heroSimpatisan">0</div>
                        <div class="dc-stat-label"><i class="fas fa-user-friends"></i> Simpatisan</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dc-stat">
                        <div class="dc-stat-val" data-animate="heroUmum">0</div>
                        <div class="dc-stat-label"><i class="fas fa-users"></i> Umum</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dc-stat">
                        <div class="dc-stat-val" data-animate="heroBaptis">0</div>
                        <div class="dc-stat-label"><i class="fas fa-water"></i> Akta Baptis (Total)</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= KARTU AKTIVITAS ================= -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
            <div class="font-weight-bold text-dark">
                Aktivitas Tahun <span class="lbl-tahun"><?php echo $tahun; ?></span>
            </div>
            <small class="text-muted">
                <i class="fas fa-hand-pointer"></i> Klik kartu untuk menampilkan atau menyembunyikan di grafik dan tabel
                <a href="#" id="btnTampilkanSemua" class="ml-2 d-none">Tampilkan semua</a>
            </small>
        </div>

        <div class="row mb-2" id="rowKpi">
            <?php foreach ($kartuAktivitas as $k): ?>
                <div class="col-xl col-md-4 col-6 mb-3">
                    <div class="card dc-card dc-kpi position-relative h-100 p-3"
                         id="kpi-<?php echo $k['key']; ?>"
                         data-key="<?php echo $k['key']; ?>"
                         role="button" tabindex="0"
                         title="Klik untuk tampilkan/sembunyikan">
                        <div class="d-flex align-items-center mb-2">
                            <div class="dc-ico mr-2" style="background: <?php echo $k['warna']; ?>;">
                                <i class="fas <?php echo $k['icon']; ?>"></i>
                            </div>
                            <div class="dc-label"><?php echo $k['label']; ?></div>
                        </div>
                        <div class="dc-val" data-animate="kpi-<?php echo $k['key']; ?>">0</div>
                        <div class="dc-trend mt-1 dc-flat">&nbsp;</div>
                        <div class="dc-bar" style="background: <?php echo $k['warna']; ?>; opacity:.25;"></div>
                        <small class="text-muted d-block mt-1"><?php echo $k['desc']; ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- ================= GRAFIK + KOMPOSISI ================= -->
        <div class="row" id="dcContent">
            <div class="dc-loading" id="dcLoading">
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status"></div>
                    <div class="small text-muted mt-2">Memuat data...</div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card dc-card h-100">
                    <div class="card-header bg-white border-0 pt-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center dc-toolbar">
                            <div class="mb-2 mb-md-0">
                                <h6 class="font-weight-bold mb-1">Tren Bulanan</h6>
                                <div class="dc-insight" id="insightPuncak">Memuat...</div>
                            </div>
                            <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
                                <label class="btn btn-outline-primary active" data-type="bar">
                                    <input type="radio" name="chartType" checked> <i class="fas fa-chart-bar"></i> Batang
                                </label>
                                <label class="btn btn-outline-primary" data-type="line">
                                    <input type="radio" name="chartType"> <i class="fas fa-chart-line"></i> Garis
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dc-chart-box">
                            <canvas id="grafikUtama"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card dc-card h-100">
                    <div class="card-header bg-white border-0 pt-3">
                        <h6 class="font-weight-bold mb-0">Komposisi Jemaat</h6>
                        <small class="text-muted">Status keseluruhan saat ini</small>
                    </div>
                    <div class="card-body">
                        <div class="dc-donut-box">
                            <canvas id="grafikKomposisi"></canvas>
                            <div class="dc-donut-center">
                                <div class="small text-muted" style="line-height:1.2">Total<br>terdaftar</div>
                                <div class="h4 font-weight-bold mb-0" id="donutCenter">0</div>
                            </div>
                        </div>
                        <div class="mt-3" id="komposisiList"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= TABEL RINCIAN ================= -->
        <div class="card dc-card mb-4">
            <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold mb-0">Rincian Bulanan <span class="lbl-tahun"><?php echo $tahun; ?></span></h6>
                <small class="text-muted"><i class="fas fa-star text-warning"></i> Bulan dengan angka tertinggi ditandai</small>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover dc-table mb-0">
                    <thead class="thead-light" id="theadRincian">
                        <tr>
                            <th>Bulan</th>
                            <?php foreach ($kartuAktivitas as $k): ?>
                                <th class="text-right" data-key="<?php echo $k['key']; ?>"><?php echo $k['label']; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody id="tbodyRincian">
                        <tr><td colspan="6" class="text-center text-muted py-4">Memuat data...</td></tr>
                    </tbody>
                    <tfoot id="tfootRincian"></tfoot>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- MODAL CETAK -->
<div class="modal fade" id="modalCetak" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" id="modalCetakHeader">
                <h5 class="modal-title">
                    <i id="modalCetakIcon" class="fas fa-file-pdf"></i>
                    <span id="modalCetakTitle">Cetak Laporan Dashboard Care</span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="cetakTglawal"><i class="fas fa-calendar-alt"></i> Tanggal Awal</label>
                    <input type="date" class="form-control" id="cetakTglawal" value="<?php echo $tahun . '-01-01'; ?>">
                </div>
                <div class="form-group">
                    <label for="cetakTglakhir"><i class="fas fa-calendar-alt"></i> Tanggal Akhir</label>
                    <input type="date" class="form-control" id="cetakTglakhir" value="<?php echo $tahun . '-12-31'; ?>">
                </div>
                <div class="alert alert-info mb-0" id="modalCetakInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn" id="modalCetakBtn" onclick="doCetak()">
                    <i id="modalCetakBtnIcon" class="fas fa-file-pdf"></i>
                    <span id="modalCetakBtnText">Cetak PDF</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer') ?>

<script src="<?php echo base_url(); ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>

<script>
    // ===================== NOTIFIKASI (aman walau SweetAlert2 belum dimuat) =====================
    function notify(title, text, icon, isToast) {
        if (typeof Swal !== 'undefined' && Swal.fire) {
            if (isToast) {
                Swal.fire({ toast: true, position: 'top-end', icon: icon || 'info', title: title, showConfirmButton: false, timer: 2000 });
            } else {
                Swal.fire(title, text || '', icon || 'info');
            }
        } else {
            if (isToast) {
                console.warn(title);
            } else {
                alert(title + (text ? '\n\n' + text : ''));
            }
        }
    }

    // ===================== KONFIGURASI =====================
    var DC_URL    = '<?php echo site_url('dashboardcare/getdata') ?>';
    var CETAK_URL = '<?php echo site_url('dashboardcare/cetak') ?>';
    var TAHUN     = <?php echo (int) $tahun; ?>;

    var CONFIG = {
        pendaftar:      { label: 'Pendaftar',       warna: '#17a2b8' },
        jemaatbaru:     { label: 'Jemaat Baru',     warna: '#007bff' },
        pernikahan:     { label: 'Pernikahan',      warna: '#dc3545' },
        penyerahananak: { label: 'Penyerahan Anak', warna: '#fd7e14' },
        baptis:         { label: 'Baptis',          warna: '#6f42c1' }
    };
    var KEYS = Object.keys(CONFIG);

    var grafikUtama = null, grafikKomposisi = null;
    var chartType = 'bar';
    var hiddenKeys = {};
    var lastData = null;

    // ===================== UTILITAS =====================
    function fmt(n) {
        return (parseInt(n, 10) || 0).toLocaleString('id-ID');
    }

    function hexToRgba(hex, alpha) {
        var r = parseInt(hex.slice(1, 3), 16);
        var g = parseInt(hex.slice(3, 5), 16);
        var b = parseInt(hex.slice(5, 7), 16);
        return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
    }

    function animateNumber($el, to) {
        var from = parseInt($el.attr('data-val'), 10) || 0;
        $el.attr('data-val', to);
        var start = null, dur = 600;
        function step(ts) {
            if (!start) start = ts;
            var p = Math.min((ts - start) / dur, 1);
            $el.text(fmt(Math.round(from + (to - from) * p)));
            if (p < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    function setLoading(on) {
        $('#dcLoading').toggleClass('show', on);
        $('#iconRefresh').toggleClass('fa-spin', on);
    }

    function visibleKeys() {
        return KEYS.filter(function (k) { return !hiddenKeys[k]; });
    }

    // ===================== LOAD DATA =====================
    function loadData() {
        setLoading(true);
        $.getJSON(DC_URL, { tahun: TAHUN })
            .done(function (res) {
                setLoading(false);
                if (!res || !res.success) {
                    notify('Gagal', 'Format data tidak valid.', 'error');
                    return;
                }
                lastData = res;
                renderAll();

                if (res.errors && res.errors.length) {
                    notify('Sebagian data gagal dimuat', res.errors.join('\n'), 'warning');
                }
            })
            .fail(function (xhr) {
                setLoading(false);
                notify('Gagal', 'Data dashboard gagal dimuat (HTTP ' + xhr.status + ').', 'error');
            });
    }

    function renderAll() {
        renderHero();
        renderKpi();
        renderMainChart();
        renderKomposisi();
        renderTable();
    }

    // Dipanggil saat kartu diklik (tanpa ambil ulang data dari server)
    function refreshView() {
        renderKpi();
        renderMainChart();
        renderTable();
    }

    // ===================== HERO =====================
    function renderHero() {
        var k = lastData.komposisi;
        animateNumber($('[data-animate="heroJemaat"]'), k.jemaat);
        animateNumber($('[data-animate="heroSimpatisan"]'), k.simpatisan);
        animateNumber($('[data-animate="heroUmum"]'), k.umum);
        animateNumber($('[data-animate="heroBaptis"]'), lastData.totalbaptisakta);
    }

    // ===================== KARTU AKTIVITAS =====================
    function renderKpi() {
        KEYS.forEach(function (key) {
            var s = lastData.summary[key];
            var diff = s.total - s.tahunlalu;
            var pct = s.tahunlalu === 0
                ? (s.total > 0 ? 100 : 0)
                : Math.round(diff / s.tahunlalu * 100);

            var cls  = diff > 0 ? 'dc-up' : (diff < 0 ? 'dc-down' : 'dc-flat');
            var icon = diff > 0 ? 'fa-arrow-up' : (diff < 0 ? 'fa-arrow-down' : 'fa-minus');

            var $kpi = $('#kpi-' + key);
            animateNumber($kpi.find('.dc-val'), s.total);
            $kpi.find('.dc-trend')
                .attr('class', 'dc-trend mt-1 ' + cls)
                .html('<i class="fas ' + icon + '"></i> ' + Math.abs(pct) + '% dibanding ' +
                      (TAHUN - 1) + ' (' + fmt(s.tahunlalu) + ')');
            $kpi.toggleClass('is-off', !!hiddenKeys[key]).attr('aria-pressed', hiddenKeys[key] ? 'false' : 'true');
        });

        var adaYangDisembunyikan = KEYS.some(function (k) { return hiddenKeys[k]; });
        $('#btnTampilkanSemua').toggleClass('d-none', !adaYangDisembunyikan);
    }

    function toggleKpi(key) {
        var akanDisembunyikan = !hiddenKeys[key];
        if (akanDisembunyikan && visibleKeys().length <= 1) {
            notify('Minimal satu kategori harus ditampilkan', '', 'info', true);
            return;
        }
        hiddenKeys[key] = akanDisembunyikan;
        refreshView();
    }

    // ===================== GRAFIK UTAMA =====================
    function renderMainChart() {
        var isLine = chartType === 'line';

        var datasets = KEYS.map(function (k) {
            var c = CONFIG[k];
            return {
                label: c.label,
                data: lastData.series[k],
                borderColor: c.warna,
                backgroundColor: isLine ? hexToRgba(c.warna, 0.08) : hexToRgba(c.warna, 0.85),
                borderWidth: isLine ? 2.5 : 1,
                pointBackgroundColor: c.warna,
                pointRadius: isLine ? 3 : 0,
                pointHoverRadius: 6,
                lineTension: 0.35,
                fill: false
            };
        });

        if (grafikUtama) grafikUtama.destroy();

        grafikUtama = new Chart(document.getElementById('grafikUtama').getContext('2d'), {
            type: chartType,
            data: { labels: lastData.bulan, datasets: datasets },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                animation: { duration: 500 },
                legend: { display: false },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function (item, data) {
                            return ' ' + data.datasets[item.datasetIndex].label + ': ' + fmt(item.yLabel);
                        }
                    }
                },
                hover: { mode: 'index', intersect: false },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0,
                            callback: function (v) { return fmt(v); }
                        },
                        gridLines: { color: 'rgba(0,0,0,.06)' }
                    }],
                    xAxes: [{
                        gridLines: { display: false }
                    }]
                }
            }
        });

        // Terapkan visibilitas kategori
        KEYS.forEach(function (k, i) {
            grafikUtama.getDatasetMeta(i).hidden = hiddenKeys[k] ? true : null;
        });
        grafikUtama.update();

        renderInsight();
    }

    function renderInsight() {
        var keys = visibleKeys();
        if (keys.length === 0 || !lastData) {
            $('#insightPuncak').text('Pilih minimal satu kategori.');
            return;
        }

        var totalPerBulan = lastData.bulan.map(function (_, i) {
            return keys.reduce(function (sum, k) { return sum + (lastData.series[k][i] || 0); }, 0);
        });
        var maks = Math.max.apply(null, totalPerBulan);

        if (maks === 0) {
            $('#insightPuncak').text('Belum ada aktivitas tercatat pada tahun ini.');
            return;
        }
        var idx = totalPerBulan.indexOf(maks);
        $('#insightPuncak').html(
            '<i class="fas fa-lightbulb"></i> Bulan tersibuk: <b>' + lastData.bulan[idx] +
            '</b> dengan <b>' + fmt(maks) + '</b> aktivitas'
        );
    }

    // Tombol Batang / Garis
    $(document).on('change', 'input[name="chartType"]', function () {
        chartType = $(this).closest('label').data('type');
        if (lastData) renderMainChart();
    });

    // ===================== KOMPOSISI (DONUT) =====================
    function renderKomposisi() {
        var k = lastData.komposisi;
        var total = k.jemaat + k.simpatisan + k.umum;
        var items = [
            { label: 'Jemaat',     nilai: k.jemaat,     warna: '#00a65a' },
            { label: 'Simpatisan', nilai: k.simpatisan, warna: '#f39c12' },
            { label: 'Umum',       nilai: k.umum,       warna: '#6c757d' }
        ];

        $('#donutCenter').text(fmt(total));

        if (grafikKomposisi) grafikKomposisi.destroy();
        grafikKomposisi = new Chart(document.getElementById('grafikKomposisi').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: items.map(function (i) { return i.label; }),
                datasets: [{
                    data: items.map(function (i) { return i.nilai; }),
                    backgroundColor: items.map(function (i) { return i.warna; }),
                    borderWidth: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 68,
                legend: { display: false },
                animation: { duration: 500 },
                tooltips: {
                    callbacks: {
                        label: function (item, data) {
                            var v = data.datasets[0].data[item.index];
                            var p = total ? Math.round(v / total * 100) : 0;
                            return ' ' + data.labels[item.index] + ': ' + fmt(v) + ' (' + p + '%)';
                        }
                    }
                }
            }
        });

        var html = '';
        items.forEach(function (i) {
            var p = total ? Math.round(i.nilai / total * 100) : 0;
            html += '<div class="d-flex justify-content-between align-items-center mb-2">' +
                        '<div><span class="d-inline-block rounded-circle mr-2" style="width:10px;height:10px;background:' + i.warna + ';"></span>' + i.label + '</div>' +
                        '<div class="font-weight-bold">' + fmt(i.nilai) + ' <small class="text-muted">(' + p + '%)</small></div>' +
                    '</div>';
        });
        $('#komposisiList').html(html);
    }

    // ===================== TABEL =====================
    function renderTable() {
        // Sembunyikan kolom yang kategorinya disembunyikan
        $('#theadRincian th[data-key]').each(function () {
            $(this).toggleClass('d-none', !!hiddenKeys[$(this).data('key')]);
        });

        // Nilai tertinggi per kolom
        var maksKolom = {};
        KEYS.forEach(function (k) {
            maksKolom[k] = Math.max.apply(null, lastData.series[k]);
        });

        var totalKolom = {};
        KEYS.forEach(function (k) { totalKolom[k] = 0; });

        var html = '';
        lastData.bulan.forEach(function (namaBulan, i) {
            html += '<tr><td class="font-weight-bold">' + namaBulan + '</td>';
            KEYS.forEach(function (k) {
                var v = lastData.series[k][i] || 0;
                totalKolom[k] += v;
                var puncak = (v > 0 && v === maksKolom[k]);
                html += '<td class="text-right ' + (puncak ? 'dc-peak' : '') + (hiddenKeys[k] ? ' d-none' : '') + '">' +
                        (puncak ? '<i class="fas fa-star text-warning small"></i> ' : '') +
                        fmt(v) + '</td>';
            });
            html += '</tr>';
        });
        $('#tbodyRincian').html(html);

        var foot = '<tr><td>Total ' + lastData.tahun + '</td>';
        KEYS.forEach(function (k) {
            foot += '<td class="text-right' + (hiddenKeys[k] ? ' d-none' : '') + '">' + fmt(totalKolom[k]) + '</td>';
        });
        foot += '</tr>';
        $('#tfootRincian').html(foot);
    }

    // ===================== EVENT =====================
    $(function () {
        loadData();

        $('.dc-kpi').on('click', function () {
            if (!lastData) return;
            toggleKpi($(this).data('key'));
        }).on('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (lastData) toggleKpi($(this).data('key'));
            }
        });

        $('#btnTampilkanSemua').on('click', function (e) {
            e.preventDefault();
            hiddenKeys = {};
            refreshView();
        });

        $('#btnRefresh').on('click', function () {
            loadData();
        });

        $('#filterTahun').on('change', function () {
            TAHUN = parseInt(this.value, 10);
            hiddenKeys = {};
            history.replaceState(null, '', '?tahun=' + TAHUN);
            $('.lbl-tahun').text(TAHUN);
            $('.lbl-tahunlalu').text(TAHUN - 1);
            $('#cetakTglawal').val(TAHUN + '-01-01');
            $('#cetakTglakhir').val(TAHUN + '-12-31');
            loadData();
        });
    });

    // ===================== MODAL CETAK =====================
    var _jenisCetakan = 'pdf';

    function showModalCetak(jenis) {
        _jenisCetakan = jenis || 'pdf';
        var isExcel = _jenisCetakan === 'excel';

        $('#modalCetakHeader').toggleClass('bg-success', isExcel).toggleClass('bg-danger', !isExcel);
        $('#modalCetakIcon').attr('class', isExcel ? 'fas fa-file-excel' : 'fas fa-file-pdf');
        $('#modalCetakTitle').text(isExcel ? 'Cetak Excel - Dashboard Care' : 'Cetak PDF - Dashboard Care');
        $('#modalCetakBtn').toggleClass('btn-success', isExcel).toggleClass('btn-danger', !isExcel);
        $('#modalCetakBtnIcon').attr('class', isExcel ? 'fas fa-file-excel' : 'fas fa-file-pdf');
        $('#modalCetakBtnText').text(isExcel ? 'Cetak Excel' : 'Cetak PDF');
        $('#modalCetakInfo').html(isExcel
            ? '<i class="fas fa-info-circle"></i> Laporan diunduh sebagai file Excel.'
            : '<i class="fas fa-info-circle"></i> Laporan ditampilkan sebagai PDF di tab baru.');

        $('#modalCetak').modal('show');
    }

    function doCetak() {
        var tglawal  = $('#cetakTglawal').val();
        var tglakhir = $('#cetakTglakhir').val();

        if (!tglawal || !tglakhir) {
            notify('Perhatian', 'Tanggal awal dan akhir harus diisi!', 'warning');
            return;
        }
        if (tglawal > tglakhir) {
            notify('Perhatian', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!', 'warning');
            return;
        }

        $('#modalCetak').modal('hide');
        window.open(CETAK_URL + '/' + _jenisCetakan + '/' + tglawal + '/' + tglakhir, '_blank');
    }
</script>

</body>
</html>