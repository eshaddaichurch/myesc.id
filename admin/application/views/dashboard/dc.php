<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<style>
    .ddc-hero {
        background: linear-gradient(135deg, #831843 0%, #be185d 55%, #f472b6 100%);
        color: #fff;
        border-radius: 14px;
        padding: 1.5rem;
        box-shadow: 0 6px 18px rgba(131, 24, 67, .25);
    }
    .ddc-stat { background: rgba(255,255,255,.14); border-radius: 10px; padding: .75rem 1rem; height: 100%; }
    .ddc-stat-val { font-size: 1.5rem; font-weight: 700; line-height: 1.1; }
    .ddc-stat-label { font-size: .8rem; opacity: .9; }

    .ddc-card { border: 0; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
    .ddc-val { font-size: 1.6rem; font-weight: 700; line-height: 1.1; color: #212529; }
    .ddc-label { font-size: .85rem; font-weight: 600; color: #495057; }
    .ddc-chart { position: relative; height: 300px; }
    .ddc-table th, .ddc-table td { font-size: .85rem; white-space: nowrap; }
    .ddc-table tbody tr:hover { background: #fdf2f8; }
    .ddc-table tfoot td { font-weight: 700; background: #f4f6f9; }
    .ddc-peak { font-weight: 700; color: #be185d; }

    @media (max-width: 576px) {
        .ddc-val { font-size: 1.3rem; }
        .ddc-chart { height: 240px; }
    }
</style>

<div class="row" id="toni-breadcrumb">
    <div class="col-12">
        <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-1">
            <li class="breadcrumb-item active">Dashboard Disciples Community</li>
        </ol>
        <h4 class="text-dark mb-0">Dashboard Disciples Community</h4>
    </div>
</div>

<div class="row mt-3" id="toni-content">
    <div class="col-12">

        <?php if (!empty($error)): ?>
            <div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- ================= FILTER ================= -->
        <div class="card ddc-card mb-4">
            <div class="card-body">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-4 mb-2">
                        <label for="fAwal" class="small font-weight-bold">Tanggal Awal</label>
                        <input type="date" id="fAwal" class="form-control" value="<?php echo $tglawal; ?>">
                    </div>
                    <div class="form-group col-md-4 mb-2">
                        <label for="fAkhir" class="small font-weight-bold">Tanggal Akhir</label>
                        <input type="date" id="fAkhir" class="form-control" value="<?php echo $tglakhir; ?>">
                    </div>
                    <div class="form-group col-md-4 mb-2">
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
                </div>
            </div>
        </div>

        <!-- ================= HERO ================= -->
        <div class="ddc-hero mb-4">
            <div class="mb-3">
                <h5 class="mb-1 font-weight-bold">Ringkasan Disciples Community</h5>
                <small>Periode: <span id="hPeriode"><?php echo $tglawal; ?> s/d <?php echo $tglakhir; ?></span></small>
            </div>
            <div class="row">
                <div class="col-6 col-lg-3 mb-2">
                    <div class="ddc-stat">
                        <div class="ddc-stat-val" id="hBaru">0</div>
                        <div class="ddc-stat-label"><i class="fas fa-user-plus"></i> Member Baru pada Periode</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="ddc-stat">
                        <div class="ddc-stat-val" id="hRata">0</div>
                        <div class="ddc-stat-label"><i class="fas fa-chart-line"></i> Rata-rata per Hari</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="ddc-stat">
                        <div class="ddc-stat-val" id="hDc">0</div>
                        <div class="ddc-stat-label"><i class="fas fa-people-group"></i> DC Aktif</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="ddc-stat">
                        <div class="ddc-stat-val" id="hMember">0</div>
                        <div class="ddc-stat-label"><i class="fas fa-users"></i> Member Aktif</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= INFO BULAN & PERBANDINGAN ================= -->
        <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card ddc-card h-100 p-3">
                    <div class="ddc-label">Member Baru Bulan Ini <small class="text-muted" id="infoIniNama"></small></div>
                    <div class="ddc-val" id="infoIni">0</div>
                    <small id="pctIni" class="text-muted">Memuat...</small>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card ddc-card h-100 p-3">
                    <div class="ddc-label">Member Baru Bulan Lalu <small class="text-muted" id="infoLaluNama"></small></div>
                    <div class="ddc-val" id="infoLalu">0</div>
                    <small id="pctLalu" class="text-muted">Memuat...</small>
                </div>
            </div>
            <div class="col-md-12 col-xl-6 mb-4">
                <div class="card ddc-card h-100 p-3">
                    <div class="ddc-label">Periode Terpilih vs Periode Sebelumnya</div>
                    <div class="ddc-val" id="bNow">0</div>
                    <small id="bInfo" class="text-muted">Memuat...</small>
                </div>
            </div>
        </div>

        <!-- ================= GRAFIK HARIAN ================= -->
        <div class="card ddc-card mb-4">
            <div class="card-header bg-white border-0 pt-3 d-flex flex-wrap justify-content-between align-items-center">
                <div class="mb-2">
                    <h6 class="font-weight-bold mb-0">Member Baru per Hari</h6>
                    <small class="text-muted">Jumlah permohonan yang disetujui, per tanggal konfirmasi</small>
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
                <div id="catatanKosong" class="alert alert-light border text-center d-none mb-3">
                    Tidak ada member baru pada periode ini.
                </div>
                <div class="ddc-chart"><canvas id="cvHarian"></canvas></div>
                <div class="mt-2"><span class="small text-muted" id="infoTertinggi"></span></div>
            </div>
        </div>

        <!-- ================= GRAFIK PER BULAN ================= -->
        <div class="card ddc-card mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="font-weight-bold mb-0">Member Baru per Bulan, <span id="judulBulan">-</span></h6>
            </div>
            <div class="card-body">
                <div class="ddc-chart"><canvas id="cvBulan"></canvas></div>
            </div>
        </div>

        <!-- ================= TABEL DC ================= -->
        <div class="card ddc-card mb-4">
            <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                <h6 class="font-weight-bold mb-0">Daftar Disciples Community</h6>
                <small class="text-muted">Jumlah member aktif per DC</small>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover ddc-table mb-0" id="tabelDc"></table>
            </div>
        </div>

        <!-- ================= CETAK LAPORAN ================= -->
        <div class="card ddc-card mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="font-weight-bold mb-0"><i class="fas fa-file-pdf text-danger"></i> Cetak Laporan</h6>
                <small class="text-muted">PDF dan Excel memuat member baru pada periode di atas. Laporan Anggota memuat daftar anggota per DC.</small>
            </div>
            <div class="card-body">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3 mb-2">
                        <label class="small font-weight-bold">Jenis Kelamin (anggota)</label>
                        <select id="fJk" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label class="small font-weight-bold">Rentang Umur (anggota)</label>
                        <select id="fUmur" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            <option value="0-17">0 - 17 Tahun</option>
                            <option value="18-25">18 - 25 Tahun</option>
                            <option value="26-35">26 - 35 Tahun</option>
                            <option value="36-45">36 - 45 Tahun</option>
                            <option value="46-99">46 Tahun ke atas</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label class="small font-weight-bold">Status Keanggotaan</label>
                        <select id="fStatus" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            <option value="Core Team">Core Team</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <button type="button" class="btn btn-danger btn-block mb-2" id="btnCetak">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </button>
                        <button type="button" class="btn btn-success btn-block mb-2" id="btnExcel">
                            <i class="fas fa-file-excel"></i> Cetak Excel
                        </button>
                        <button type="button" class="btn btn-dark btn-block" id="btnLaporanAnggota">
                            <i class="fas fa-users"></i> Laporan Anggota
                        </button>
                    </div>
                </div>
                <small class="text-muted">Periode tanggal berlaku untuk PDF dan Excel member baru. Filter jenis kelamin, umur, dan status hanya berlaku untuk Laporan Anggota.</small>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('template/footer'); ?>

<script src="<?php echo base_url('assets/adminlte/plugins/chart.js/Chart.min.js'); ?>"></script>
<script>
    window.DDC = {
        base:    '<?php echo site_url("dashboarddc/"); ?>',
        self:    '<?php echo site_url("dashboarddc"); ?>',
        cetak:   '<?php echo site_url("dashboarddc/cetak"); ?>',
        excel:   '<?php echo site_url("dashboarddc/cetakexcel"); ?>',
        anggota: '<?php echo site_url("dashboarddc/cetaklaporananggota"); ?>'
    };
</script>
<script src="<?php echo base_url('assets/js/dashboarddc.js'); ?>"></script>

</body>
</html>