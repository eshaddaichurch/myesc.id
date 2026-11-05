<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

<link rel="stylesheet" href="<?php echo base_url('assets/css/dashboardnextstep.css'); ?>">

<div class="row" id="toni-breadcrumb">
    <div class="col-12">
        <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-1">
            <li class="breadcrumb-item"><a href="<?php echo site_url('dashboardnextstep'); ?>">Dashboard Equip</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
        <h4 class="text-dark mb-0">Detail Grafik Kelas</h4>
    </div>
</div>

<div class="row mt-3" id="toni-content">
    <div class="col-12 dns-detail">

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <a href="<?php echo site_url('dashboardnextstep'); ?>" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left"></i> Kembali ke dashboard
            </a>
            <div class="btn-group btn-group-toggle btn-group-sm mb-2" data-toggle="buttons">
                <label class="btn btn-outline-primary active" data-type="bar">
                    <input type="radio" name="chartType" checked> <i class="fas fa-chart-bar"></i> Batang
                </label>
                <label class="btn btn-outline-primary" data-type="line">
                    <input type="radio" name="chartType"> <i class="fas fa-chart-line"></i> Garis
                </label>
            </div>
        </div>

        <!-- ================= GRAFIK (lebar penuh) ================= -->
        <div class="row" id="gridKelas"></div>

        <!-- ================= TABEL RINCIAN ================= -->
        <div class="card dns-card mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h6 class="font-weight-bold mb-0">Rincian Sertifikat per Bulan, <?php echo date('Y'); ?></h6>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover dns-table mb-0" id="tabelBulanan"></table>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view("template/footer"); ?>

<script src="<?php echo base_url(); ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>
<script>
    window.DNS = {
        base:      '<?php echo site_url("dashboardnextstep/"); ?>',
        registrasi:'<?php echo site_url("registrasikelas/index/"); ?>',
        tahun:     '<?php echo date("Y"); ?>',
        mode:      'detail'
    };
</script>
<script src="<?php echo base_url('assets/js/dashboardnextstep.js'); ?>"></script>

</body>
</html>