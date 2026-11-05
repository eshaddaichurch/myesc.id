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
        registrasi:'<?php echo site_url("registrasikelas/index/"); ?>',
        tahun:     '<?php echo date("Y"); ?>',
        mode:      'index'
    };
</script>
<script src="<?php echo base_url('assets/js/dashboardnextstep.js'); ?>"></script>

</body>
</html>