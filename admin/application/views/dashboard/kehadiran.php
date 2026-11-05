<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<style>
    .dk-hero {
        background: linear-gradient(135deg, #4c1d95 0%, #6d28d9 55%, #a78bfa 100%);
        color: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 6px 18px rgba(76, 29, 149, .25);
    }
    .dk-stat { background: rgba(255,255,255,.14); border-radius: 10px; padding: .75rem 1rem; height: 100%; }
    .dk-stat-val { font-size: 1.5rem; font-weight: 700; line-height: 1.1; }
    .dk-stat-label { font-size: .8rem; opacity: .9; }

    .dk-card { border: 0; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
    .dk-val { font-size: 1.6rem; font-weight: 700; line-height: 1.1; color: #212529; }
    .dk-label { font-size: .85rem; font-weight: 600; color: #495057; }
    .dk-chart { position: relative; height: 300px; }
    .dk-donut { position: relative; height: 260px; }
    .dk-tile { border: 1px solid #e5e7eb; border-radius: 8px; padding: .5rem; text-align: center; background: #fff; }
    .dk-table th, .dk-table td { font-size: .85rem; white-space: nowrap; }
    .dk-table tbody tr:hover { background: #faf5ff; }
    .dk-table tfoot td { font-weight: 700; background: #f4f6f9; }
    .dk-peak { font-weight: 700; color: #6d28d9; }

    @media (max-width: 576px) {
        .dk-val { font-size: 1.3rem; }
        .dk-chart { height: 240px; }
    }
</style>

<div class="row" id="toni-breadcrumb">
    <div class="col-12">
        <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-1">
            <li class="breadcrumb-item active">Dashboard Kehadiran</li>
        </ol>
        <h4 class="text-dark mb-0">Dashboard Kehadiran</h4>
    </div>
</div>

<div class="row mt-3" id="toni-content">
    <div class="col-12">

        <?php if (!empty($error)): ?>
            <div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- ================= FILTER ================= -->
        <div class="card dk-card mb-4">
            <div class="card-body">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4 mb-2">
                        <label for="fJenis" class="small font-weight-bold">Jenis Absen</label>
                        <select id="fJenis" class="form-control">
                            <?php foreach ($jenis as $j): ?>
                                <option value="<?php echo htmlspecialchars($j['idabsenjenis']); ?>"
                                    <?php echo $j['idabsenjenis'] === $idjenis ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($j['namaabsenjenis']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="fAwal" class="small font-weight-bold">Tanggal Awal</label>
                        <input type="date" id="fAwal" class="form-control" value="<?php echo $tglawal; ?>">
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="fAkhir" class="small font-weight-bold">Tanggal Akhir</label>
                        <input type="date" id="fAkhir" class="form-control" value="<?php echo $tglakhir; ?>">
                    </div>
                    <div class="form-group col-md-2 mb-2">
                        <button type="button" class="btn btn-primary btn-block" id="btnTerapkan">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center">
                    <small class="text-muted mr-2">Pintasan:</small>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="ini">Bulan ini</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="lalu">Bulan lalu</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="3bln">3 bulan terakhir</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="tahun">Tahun ini</button>
                    <button type="button" class="btn btn-danger btn-sm mb-1 ml-auto" id="btnCetak">
                        <i class="fas fa-file-pdf"></i> Cetak PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- ================= HERO ================= -->
        <div class="dk-hero mb-4">
            <div class="mb-3">
                <h5 class="mb-1 font-weight-bold">Ringkasan Kehadiran</h5>
                <small>Periode: <span id="hPeriode"><?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></span></small>
            </div>
            <div class="row">
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dk-stat">
                        <div class="dk-stat-val" id="hTotal">0</div>
                        <div class="dk-stat-label"><i class="fas fa-users"></i> Total Kehadiran</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dk-stat">
                        <div class="dk-stat-val" id="hRata">0</div>
                        <div class="dk-stat-label"><i class="fas fa-chart-line"></i> Rata-rata per Hari Ibadah</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dk-stat">
                        <div class="dk-stat-val" id="hHari">0</div>
                        <div class="dk-stat-label"><i class="fas fa-calendar-check"></i> Hari Ibadah Tercatat</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dk-stat">
                        <div class="dk-stat-val" id="hSesi" style="font-size:1.1rem;">-</div>
                        <div class="dk-stat-label"><i class="fas fa-trophy"></i> Ibadah Terbanyak <small id="hSesiSub"></small></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= INFO BULAN & PERBANDINGAN ================= -->
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card dk-card h-100 p-3">
                    <div class="dk-label">Kehadiran Bulan Ini <small class="text-muted" id="infoIniNama"></small></div>
                    <div class="dk-val" id="infoIni">0</div>
                    <small id="pctIni" class="text-muted">Memuat...</small>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card dk-card h-100 p-3">
                    <div class="dk-label">Kehadiran Bulan Lalu <small class="text-muted" id="infoLaluNama"></small></div>
                    <div class="dk-val" id="infoLalu">0</div>
                    <small id="pctLalu" class="text-muted">Memuat...</small>
                </div>
            </div>
            <div class="col-md-12 col-xl-6 mb-4">
                <div class="card dk-card h-100 p-3">
                    <div class="dk-label">Periode Terpilih vs Periode Sebelumnya</div>
                    <div class="dk-val" id="bNow">0</div>
                    <small id="bInfo" class="text-muted">Memuat...</small>
                </div>
            </div>
        </div>

        <!-- ================= IBADAH TANPA CATATAN ================= -->
        <div class="card dk-card mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="font-weight-bold mb-0"><i class="fas fa-exclamation-circle text-warning"></i> Ibadah Tanpa Catatan Absen</h6>
                <small class="text-muted">Hari Minggu dalam periode yang belum ada data kehadirannya</small>
            </div>
            <div class="card-body">
                <ul class="mb-0 pl-3" id="listKosong"><li class="text-muted">Memuat...</li></ul>
            </div>
        </div>

        <div id="catatanKosong" class="alert alert-light border text-center d-none">
            Tidak ada data kehadiran pada periode ini.
        </div>

        <!-- ================= SCORECARD PER IBADAH ================= -->
        <div class="font-weight-bold text-dark mb-2">Kehadiran per Ibadah</div>
        <div class="row mb-2" id="gridSesi">
            <div class="col-12 text-muted mb-3">Memuat data...</div>
        </div>

        <!-- ================= GRAFIK TREN + KOMPOSISI ================= -->
        <div class="row mt-2">
            <div class="col-lg-8 mb-4">
                <div class="card dk-card h-100">
                    <div class="card-header bg-white border-0 pt-3 d-flex flex-wrap justify-content-between align-items-center">
                        <div class="mb-2">
                            <h6 class="font-weight-bold mb-0">Tren Kehadiran Harian</h6>
                            <small class="text-muted">Setiap batang mewakili satu hari ibadah</small>
                        </div>
                        <div class="btn-group btn-group-toggle btn-group-sm mb-2" data-toggle="buttons">
                            <label class="btn btn-outline-primary active" data-type="bar">
                                <input type="radio" name="tipeTren" checked> <i class="fas fa-chart-bar"></i> Batang
                            </label>
                            <label class="btn btn-outline-primary" data-type="line">
                                <input type="radio" name="tipeTren"> <i class="fas fa-chart-line"></i> Garis
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dk-chart"><canvas id="cvTren"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card dk-card h-100">
                    <div class="card-header bg-white border-0 pt-3">
                        <h6 class="font-weight-bold mb-0">Komposisi per Ibadah</h6>
                        <small class="text-muted">Proporsi total periode</small>
                    </div>
                    <div class="card-body">
                        <div class="dk-donut"><canvas id="cvDonut"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= GRAFIK PER BULAN ================= -->
        <div class="card dk-card mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="font-weight-bold mb-0">Total per Bulan, <span id="judulBulan">-</span></h6>
            </div>
            <div class="card-body">
                <div class="dk-chart"><canvas id="cvBulan"></canvas></div>
            </div>
        </div>

        <!-- ================= SCORECARD PER LOKASI ================= -->
        <div class="font-weight-bold text-dark mb-2">Kehadiran per Ruangan</div>
        <div class="row mb-2" id="gridLokasi">
            <div class="col-12 text-muted mb-3">Memuat data...</div>
        </div>

        <!-- ================= TABEL HARIAN ================= -->
        <div class="card dk-card mb-4">
            <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold mb-0">Rincian Harian</h6>
                <small class="text-muted"><i class="fas fa-star text-warning"></i> Hari dengan kehadiran tertinggi ditandai</small>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover dk-table mb-0" id="tabelHarian"></table>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('template/footer'); ?>

<script src="<?php echo base_url('assets/adminlte/plugins/chart.js/Chart.min.js'); ?>"></script>
<script>
    window.DKH = {
        base:  '<?php echo site_url("dashboardkehadiran/"); ?>',
        self:  '<?php echo site_url("dashboardkehadiran"); ?>',
        cetak: '<?php echo site_url("dashboardkehadiran/cetak"); ?>'
    };
</script>
<script src="<?php echo base_url('assets/js/dashboardkehadiran.js'); ?>"></script>

</body>
</html>