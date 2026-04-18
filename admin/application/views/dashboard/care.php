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
                        if (!empty($pesan))
                            echo $pesan;
                        ?>
                    </div>

                    <!-- Tombol Cetak -->
                    <div class="col-12 mb-3 text-right">
                        <button type="button" class="btn btn-danger" onclick="showModalCetak()">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </button>
                    </div>

                    <!-- Info Box: Jemaat Baru -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 class="jumlahjemaatbaru">0</h3>
                                <p>Jemaat Baru Tahun Ini</p>
                            </div>
                            <div class="icon"><i class="ion ion-bag"></i></div>
                        </div>
                    </div>

                    <!-- Info Box: Jumlah Jemaat -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 class="jumlahjemaatsemua">0</h3>
                                <p>Jumlah Jemaat</p>
                            </div>
                            <div class="icon"><i class="ion ion-stats-bars"></i></div>
                        </div>
                    </div>

                    <!-- Info Box: Simpatisan -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 class="jumlahjemaatsimpatisan">0</h3>
                                <p>Jumlah Simpatisan</p>
                            </div>
                            <div class="icon"><i class="ion ion-person-add"></i></div>
                        </div>
                    </div>

                    <!-- Info Box: Sudah Dibaptis -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 class="jumlahjemaatsudahdibaptis">0</h3>
                                <p>Sudah Dibaptis</p>
                            </div>
                            <div class="icon"><i class="ion ion-person-add"></i></div>
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
                                <canvas id="pieChart" style="min-height:250px; height:350px; max-width:100%;"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- BAR CHART: Jemaat Baru -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">Jemaat Baru</h3>
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
                                    <span class="mr-2"><i class="fas fa-square text-primary"></i> Jumlah Jemaat</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BAR CHART: Marriage Class -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">Marriage Class</h3>
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
                                    <span class="mr-2"><i class="fas fa-square" style="color:#28a745;"></i> Marriage Class</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BAR CHART: Jemaat Dibaptis -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0">
                                <h3 class="card-title">Jemaat Dibaptis Tahun <?php echo date('Y'); ?></h3>
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
                                    <span class="mr-2"><i class="fas fa-square" style="color:#ffc107;"></i> Dibaptis</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- =====================================================
     MODAL CETAK PDF
===================================================== -->
<div class="modal fade" id="modalCetak" tabindex="-1" role="dialog" aria-labelledby="modalCetakLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalCetakLabel">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan Dashboard Care
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="cetakTglawal"><i class="fas fa-calendar-alt"></i> Tanggal Awal</label>
                    <input type="date" class="form-control" id="cetakTglawal"
                           value="<?php echo date('Y-m-01'); ?>">
                </div>
                <div class="form-group">
                    <label for="cetakTglakhir"><i class="fas fa-calendar-alt"></i> Tanggal Akhir</label>
                    <input type="date" class="form-control" id="cetakTglakhir"
                           value="<?php echo date('Y-m-t'); ?>">
                </div>
                <div class="alert alert-info mb-0">
                    <i class="fas fa-info-circle"></i>
                    Laporan akan menampilkan data jemaat baru yang bergabung pada periode yang dipilih.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="button" class="btn btn-danger" onclick="doCetak('pdf')">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/footer') ?>

<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

<script>
    var pieChartInstance      = null;
    var grafikJemaatBaruChart = null;
    var grafikMarriageChart   = null;
    var grafikBaptisChart     = null;

    $(document).ready(function () {
        loadInfoBox();
        loadAllCharts();
    });

    // ===== INFO BOX =====
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
            console.error("AJAX Error: getinfobox");
        });
    }

    // ===== ALL CHARTS =====
    function loadAllCharts() {
        var ticksStyle = { fontColor: '#495057', fontStyle: 'bold' };
        var chartOptions = buildChartOptions('index', true, ticksStyle);
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
            if (!data || !data.datatanggal || !data.jumlahjemaat) {
                console.error("getgrafikjemaatbaru: format data tidak valid", data);
                return;
            }

            // PIE CHART
            if (pieChartInstance) pieChartInstance.destroy();
            pieChartInstance = new Chart($('#pieChart').get(0).getContext('2d'), {
                type: 'pie',
                data: {
                    labels: data.datatanggal,
                    datasets: [{
                        data: data.jumlahjemaat,
                        backgroundColor: [
                            '#f56954','#00a65a','#f39c12','#00c0ef',
                            '#3c8dbc','#d2d6de','#605ca8','#00a2b5',
                            '#dd4b39','#222222','#e91e63','#009688'
                        ],
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: {
                        labels: [
                            { render: 'label', position: 'outside' },
                            { render: 'value' }
                        ]
                    }
                }
            });

            // BAR CHART
            if (grafikJemaatBaruChart) grafikJemaatBaruChart.destroy();
            $('#lbljemaatbaru').html(data.totaljemaat || 0);
            grafikJemaatBaruChart = new Chart($('#grafikjemaatbaru').get(0).getContext('2d'), {
                type: 'bar',
                data: {
                    labels: data.datatanggal,
                    datasets: [{ label: 'Jemaat Baru', data: data.jumlahjemaat, backgroundColor: '#557ae0', borderColor: '#557ae0' }]
                },
                options: chartOptions
            });
        })
        .fail(function (xhr, status, error) {
            console.error("AJAX Error: getgrafikjemaatbaru -", status, error);
        });
    }

    // ===== MARRIAGE =====
    function loadMarriageChart(chartOptions) {
        $.ajax({
            url: '<?php echo site_url('dashboardcare/getgrafikmarriage') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (data) {
            if (!data || !data.datatanggal || !data.jumlahjemaat) {
                console.error("getgrafikmarriage: format data tidak valid", data);
                return;
            }
            if (grafikMarriageChart) grafikMarriageChart.destroy();
            $('#lblmarriage').html(data.totaljemaat || 0);
            grafikMarriageChart = new Chart($('#grafikmarriage').get(0).getContext('2d'), {
                type: 'bar',
                data: {
                    labels: data.datatanggal,
                    datasets: [{ label: 'Marriage Class', data: data.jumlahjemaat, backgroundColor: '#28a745', borderColor: '#28a745' }]
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
                console.error("getgrafikbaptis: format data tidak valid", data);
                return;
            }
            if (grafikBaptisChart) grafikBaptisChart.destroy();
            $('#lblbaptis').html(data.totaljemaat || 0);
            grafikBaptisChart = new Chart($('#grafikbaptis').get(0).getContext('2d'), {
                type: 'bar',
                data: {
                    labels: data.datatanggal,
                    datasets: [{ label: 'Dibaptis', data: data.jumlahjemaat, backgroundColor: '#ffc107', borderColor: '#ffc107' }]
                },
                options: chartOptions
            });
        })
        .fail(function (xhr, status, error) {
            console.error("AJAX Error: getgrafikbaptis -", status, error);
        });
    }

    // ===== HELPER: Chart Options =====
    function buildChartOptions(mode, intersect, ticksStyle) {
        return {
            maintainAspectRatio: false,
            tooltips: { mode: mode, intersect: intersect },
            hover:    { mode: mode, intersect: intersect },
            legend:   { display: false },
            scales: {
                yAxes: [{
                    gridLines: { display: true, lineWidth: '4px', color: 'rgba(0,0,0,.2)', zeroLineColor: 'transparent' },
                    ticks: $.extend({ beginAtZero: true, suggestedMax: 10 }, ticksStyle)
                }],
                xAxes: [{
                    display: true,
                    gridLines: { display: false },
                    ticks: ticksStyle
                }]
            }
        };
    }

    // ===== MODAL CETAK =====
    function showModalCetak() {
        $('#modalCetak').modal('show');
    }

    function doCetak(jenisCetakan) {
        var tglawal  = $('#cetakTglawal').val();
        var tglakhir = $('#cetakTglakhir').val();

        if (!tglawal || !tglakhir) {
            Swal.fire('Perhatian', 'Tanggal awal dan akhir harus diisi!', 'warning');
            return;
        }
        if (tglawal > tglakhir) {
            Swal.fire('Perhatian', 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!', 'warning');
            return;
        }

        $('#modalCetak').modal('hide');
        var url = '<?php echo site_url('dashboardcare/cetak') ?>/' + jenisCetakan + '/' + tglawal + '/' + tglakhir;
        window.open(url, '_blank');
    }
</script>

</body>
</html>