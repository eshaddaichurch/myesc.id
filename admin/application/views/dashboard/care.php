<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Dashboard Care</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>

<div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="card" id="cardcontent">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12">
                        <?php
                        $pesan = $this->session->flashdata('pesan');
                        if (!empty($pesan)) {
                            echo $pesan;
                        }
                        ?>
                    </div>

                    <!-- Info Box: Jemaat Baru -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 class="jumlahjemaatbaru">0</h3>
                                <p>Jemaat Baru</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box: Jumlah Jemaat Semua -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 class="jumlahjemaatsemua">0</h3>
                                <p>Jumlah Jemaat</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box: Simpatisan -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 class="jumlahjemaatsimpatisan">0</h3>
                                <p>Jumlah Simpatisan</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box: Sudah Dibaptis -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 class="jumlahjemaatsudahdibaptis">0</h3>
                                <p>Sudah Dibaptis</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        </div>
                    </div>

                    <!-- PIE CHART: Jemaat Baru per Bulan -->
                    <div class="col-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title text-light">Grafik Jemaat Baru per Bulan</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="pieChart" style="min-height: 250px; height: 350px; max-width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- BAR CHART: Jemaat Baru -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Jemaat Baru</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">Jumlah: <span id="lbljemaatbaru">0</span></span>
                                        <span>Tahun <?php echo date('Y'); ?></span>
                                    </p>
                                </div>
                                <div class="position-relative mb-4">
                                    <canvas id="grafikjemaatbaru" height="200"></canvas>
                                </div>
                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> Jumlah Jemaat
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BAR CHART: Marriage Class -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Marriage Class</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">Jumlah: <span id="lblmarriage">0</span></span>
                                        <span>Bulan <?php echo bulan(date('m')); ?></span>
                                    </p>
                                </div>
                                <div class="position-relative mb-4">
                                    <canvas id="grafikmarriage" height="200"></canvas>
                                </div>
                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> Jumlah Jemaat
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BAR CHART: Jemaat Dibaptis -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">Jemaat Dibaptis Tahun <?php echo date('Y'); ?></h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <p class="d-flex flex-column">
                                        <span class="text-bold text-lg">Jumlah: <span id="lblbaptis">0</span></span>
                                        <span>Tahun <?php echo date('Y'); ?></span>
                                    </p>
                                </div>
                                <div class="position-relative mb-4">
                                    <canvas id="grafikbaptis" height="200"></canvas>
                                </div>
                                <div class="d-flex flex-row justify-content-end">
                                    <span class="mr-2">
                                        <i class="fas fa-square text-primary"></i> Jumlah Jemaat
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer') ?>

<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

<script>
    // Deklarasi instance chart di luar agar bisa di-destroy saat reload
    var pieChartInstance      = null;
    var grafikJemaatBaruChart = null;
    var grafikMarriageChart   = null;
    var grafikBaptisChart     = null;

    $(document).ready(function () {
        loadInfoBox();
        loadAllCharts();
    });

    // ===== LOAD INFO BOX =====
    function loadInfoBox() {
        $.ajax({
            url: '<?php echo site_url('dashboardcare/getinfobox') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (data) {
            $('.jumlahjemaatbaru').html(data.jumlahjemaatbaru || 0);
            $('.jumlahjemaatsemua').html(data.jumlahjemaatsemua || 0);
            $('.jumlahjemaatsimpatisan').html(data.jumlahjemaatsimpatisan || 0);
            $('.jumlahjemaatsudahdibaptis').html(data.jumlahjemaatbaptis || 0);
        })
        .fail(function () {
            console.error("AJAX Error: getinfobox - gagal memuat data info box");
        });
    }

    // ===== LOAD ALL CHARTS =====
    function loadAllCharts() {
        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        };
        var mode      = 'index';
        var intersect = true;
        var chartOptions = buildChartOptions(mode, intersect, ticksStyle);

        loadJemaatBaruCharts(chartOptions);
        loadMarriageChart(chartOptions);
        loadBaptisChart(chartOptions);
    }

    // ===== JEMAAT BARU (PIE + BAR) =====
    function loadJemaatBaruCharts(chartOptions) {
        $.ajax({
            url: '<?php echo site_url('dashboardcare/getgrafikjemaatbaru') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (data) {
            // FIX: Validasi format data sebelum render chart
            if (!data || !data.datatanggal || !data.jumlahjemaat) {
                console.error("API getgrafikjemaatbaru: format data tidak valid", data);
                return;
            }

            // === PIE CHART ===
            if (pieChartInstance) {
                pieChartInstance.destroy();
            }

            var pieCtx = $('#pieChart').get(0).getContext('2d');
            pieChartInstance = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: data.datatanggal,
                    datasets: [{
                        data: data.jumlahjemaat,
                        backgroundColor: [
                            '#f56954', '#00a65a', '#f39c12', '#00c0ef',
                            '#3c8dbc', '#d2d6de', '#605ca8', '#00a2b5',
                            '#dd4b39', '#222222', '#f39c12', '#00c0ef'
                        ],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        labels: [{
                            render: 'label',
                            position: 'outside'
                        }, {
                            render: 'value'
                        }]
                    }
                }
            });

            // === BAR CHART ===
            if (grafikJemaatBaruChart) {
                grafikJemaatBaruChart.destroy();
            }

            $('#lbljemaatbaru').html(data.totaljemaat || 0);

            var barCtx = $('#grafikjemaatbaru').get(0).getContext('2d');
            grafikJemaatBaruChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: data.datatanggal,
                    datasets: [{
                        label: 'Jemaat Baru',
                        data: data.jumlahjemaat,
                        backgroundColor: '#557ae0',
                        borderColor: '#557ae0',
                        fill: true
                    }]
                },
                options: chartOptions
            });
        })
        .fail(function (xhr, status, error) {
            console.error("AJAX Error: getgrafikjemaatbaru -", status, error);
        });
    }

    // ===== MARRIAGE CLASS =====
    function loadMarriageChart(chartOptions) {
        $.ajax({
            url: '<?php echo site_url('dashboardcare/getgrafikmarriage') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (data) {
            if (!data || !data.datatanggal || !data.jumlahjemaat) {
                console.error("API getgrafikmarriage: format data tidak valid", data);
                return;
            }

            if (grafikMarriageChart) {
                grafikMarriageChart.destroy();
            }

            $('#lblmarriage').html(data.totaljemaat || 0);

            var barCtx = $('#grafikmarriage').get(0).getContext('2d');
            grafikMarriageChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: data.datatanggal,
                    datasets: [{
                        label: 'Marriage Class',
                        data: data.jumlahjemaat,
                        backgroundColor: '#28a745',
                        borderColor: '#28a745',
                        fill: true
                    }]
                },
                options: chartOptions
            });
        })
        .fail(function (xhr, status, error) {
            console.error("AJAX Error: getgrafikmarriage -", status, error);
        });
    }

    // ===== BAPTIS =====
    function loadBaptisChart(chartOptions) {
        $.ajax({
            url: '<?php echo site_url('dashboardcare/getgrafikbaptis') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (data) {
            if (!data || !data.datatanggal || !data.jumlahjemaat) {
                console.error("API getgrafikbaptis: format data tidak valid", data);
                return;
            }

            if (grafikBaptisChart) {
                grafikBaptisChart.destroy();
            }

            $('#lblbaptis').html(data.totaljemaat || 0);

            var barCtx = $('#grafikbaptis').get(0).getContext('2d');
            grafikBaptisChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: data.datatanggal,
                    datasets: [{
                        label: 'Dibaptis',
                        data: data.jumlahjemaat,
                        backgroundColor: '#ffc107',
                        borderColor: '#ffc107',
                        fill: true
                    }]
                },
                options: chartOptions
            });
        })
        .fail(function (xhr, status, error) {
            console.error("AJAX Error: getgrafikbaptis -", status, error);
        });
    }

    // ===== HELPER: Build Chart Options =====
    function buildChartOptions(mode, intersect, ticksStyle) {
        return {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,
                        suggestedMax: 10
                    }, ticksStyle)
                }],
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                }]
            }
        };
    }
</script>

</body>
</html>