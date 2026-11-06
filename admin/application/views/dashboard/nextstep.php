<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/dashboardnextstep.css'); ?>">

<div class="row" id="toni-breadcrumb">
    <div class="col-12">
        <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-1">
            <li class="breadcrumb-item active">Dashboard Equip</li>
        </ol>
        <h4 class="text-dark mb-0">Dashboard Equip</h4>
    </div>
</div>

<div class="row mt-3" id="toni-content">
    <div class="col-12">

        <?php
        $pesan = $this->session->flashdata("pesan");
        if (!empty($pesan)) {
            echo $pesan;
        }
        ?>

        <!-- ================= HERO ================= -->
        <div class="dns-hero mb-4">
            <div class="mb-3">
                <h5 class="mb-1 font-weight-bold">Ringkasan Kelas</h5>
                <small>Jumlah kelas yang sudah lulus, dan sertifikat yang terbit tahun <?php echo date('Y'); ?></small>
            </div>
            <div class="row">
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dns-stat">
                        <div class="dns-stat-val" id="heroTotal">0</div>
                        <div class="dns-stat-label"><i class="fas fa-layer-group"></i> Total Lulus Semua Kelas</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dns-stat">
                        <div class="dns-stat-val" id="heroMembership">0</div>
                        <div class="dns-stat-label"><i class="fas fa-id-badge"></i> Membership Class</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dns-stat">
                        <div class="dns-stat-val" id="heroFoundation">0</div>
                        <div class="dns-stat-label"><i class="fas fa-user-graduate"></i> Foundation Class (1-3)</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3 mb-2">
                    <div class="dns-stat">
                        <div class="dns-stat-val" id="heroGrade">0</div>
                        <div class="dns-stat-label"><i class="fas fa-book-open"></i> Grade (1-3)</div>
                    </div>
                </div>
            </div>
        </div>

                <!-- ================= FILTER & CETAK ================= -->
        <div class="card dns-card mb-4">
            <div class="card-body">
                <div class="form-row align-items-end">
                    <div class="form-group col-md-3 mb-2">
                        <label for="fAwal" class="small font-weight-bold">Tanggal Awal</label>
                        <input type="date" id="fAwal" class="form-control" value="<?php echo $tglawal; ?>">
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <label for="fAkhir" class="small font-weight-bold">Tanggal Akhir</label>
                        <input type="date" id="fAkhir" class="form-control" value="<?php echo $tglakhir; ?>">
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <button type="button" class="btn btn-primary btn-block" id="btnTerapkan">
                            <i class="fas fa-filter"></i> Terapkan
                        </button>
                    </div>
                    <div class="form-group col-md-3 mb-2">
                        <button type="button" class="btn btn-danger btn-block" id="btnCetak">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </button>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center mb-2">
                    <small class="text-muted mr-2">Pintasan:</small>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="ini">Bulan ini</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="lalu">Bulan lalu</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="3bln">3 bulan terakhir</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-1 mb-1" data-preset="tahun">Tahun ini</button>
                </div>

                <div class="small font-weight-bold mb-1">Kelas yang dicetak</div>
                <div class="d-flex flex-wrap">
                    <?php foreach ($kelas as $k): ?>
                        <div class="custom-control custom-checkbox custom-control-inline mb-1">
                            <input type="checkbox" class="custom-control-input cetak-kelas"
                                   id="ck-<?php echo $k['idkelas']; ?>"
                                   value="<?php echo $k['idkelas']; ?>" checked>
                            <label class="custom-control-label" for="ck-<?php echo $k['idkelas']; ?>">
                                <?php echo htmlspecialchars($k['namakelas']); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-1">
                    <a href="#" id="btnPilihSemua" class="small">Pilih semua</a>
                    <span class="text-muted small">&middot;</span>
                    <a href="#" id="btnHapusPilihan" class="small">Kosongkan</a>
                </div>
            </div>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-warning"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- ================= NOTIFIKASI PENDAFTARAN ================= -->
        <?php if ($rsMenunggu->num_rows() > 0): ?>
            <div class="card dns-card mb-4">
                <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
                    <h6 class="font-weight-bold mb-0">
                        <i class="fas fa-bell text-warning"></i> Notifikasi Pendaftaran Kelas
                    </h6>
                    <span class="badge badge-warning"><?php echo $rsMenunggu->num_rows(); ?> menunggu</span>
                </div>
                <div class="card-body">
                    <ul class="dns-notif-list">
                        <?php foreach ($rsMenunggu->result() as $row): ?>
                            <li>
                                <a href="<?php echo site_url('konfirmasikelas/edit/') . $this->encrypt->encode($row->idregistrasi); ?>">
                                    <?php echo since($row->tglregistrasi); ?> &middot; <?php echo htmlspecialchars($row->namalengkap); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- ================= KPI KELAS ================= -->
        <div class="font-weight-bold text-dark mb-2">Jumlah Lulus per Kelas</div>
                <div class="card dns-card mb-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="dns-label">Lulus pada periode terpilih (kelas yang dipilih)</div>
                    <small class="text-muted" id="periodeInfo"></small>
                </div>
                <div class="dns-val" id="periodeTotal">0</div>
            </div>
        </div>
        <div class="row mb-2" id="rowKpi">
            <div class="col-12 text-muted mb-3">Memuat data...</div>
        </div>

        <!-- ================= GRAFIK ================= -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mt-2 mb-3">
            <div class="font-weight-bold text-dark">
                Sertifikat Terbit per Bulan, <?php echo date('Y'); ?>
            </div>
            <div class="d-flex align-items-center">
                <div class="btn-group btn-group-toggle btn-group-sm mr-2" data-toggle="buttons">
                    <label class="btn btn-outline-primary active" data-type="bar">
                        <input type="radio" name="chartType" checked> <i class="fas fa-chart-bar"></i> Batang
                    </label>
                    <label class="btn btn-outline-primary" data-type="line">
                        <input type="radio" name="chartType"> <i class="fas fa-chart-line"></i> Garis
                    </label>
                </div>
                <a href="<?php echo site_url('dashboardnextstep/detail'); ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-table"></i> Lihat detail
                </a>
            </div>
        </div>

        <div class="row" id="gridKelas"></div>

    </div>
</div>

<?php $this->load->view("template/footer"); ?>

<script src="<?php echo base_url(); ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>
<script>
    window.DNS = {
        base:      '<?php echo site_url("dashboardnextstep/"); ?>',
        self:      '<?php echo site_url("dashboardnextstep"); ?>',
        cetak:     '<?php echo site_url("dashboardnextstep/cetak"); ?>',
        registrasi:'<?php echo site_url("registrasikelas/index/"); ?>',
        tahun:     '<?php echo date("Y"); ?>',
        mode:      'index'
    };
</script>
<script src="<?php echo base_url('assets/js/dashboardnextstep.js'); ?>"></script>

</body>
</html>