<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Dashboard Disciples Community</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard Disciples Community</li>
        </ol>
    </div>
</div>

<div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="card" id="cardcontent">
            <div class="card-body">
                <div class="row">

                    <!-- Info Box: Member Baru Bulan Lalu -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Member Baru<br>Bulan Lalu</span>
                                <span class="info-box-number">
                                    <span id="memberBaruLalu">0</span>
                                    <small>Orang</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box: Member Baru Bulan Ini -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Member Baru<br>Bulan Ini</span>
                                <!-- FIX: id="memberBaruIni" dipindah ke span wrapper yang benar -->
                                <span class="info-box-number">
                                    <span id="memberBaruIni">0</span>
                                    <small>Orang</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix hidden-md-up"></div>

                    <!-- Info Box: Jumlah DC -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah <br>DC</span>
                                <span class="info-box-number">
                                    <span id="jumlahDc">0</span>
                                    <small>DC</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Box: Jumlah Member -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah <br>Member</span>
                                <span class="info-box-number">
                                    <span id="jumlahMember">0</span>
                                    <small>Orang</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Grafik + Bulan -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <!-- Filter Periode -->
                                    <div class="col-12 mb-3">
                                        <div class="card card-body shadow">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label>Periode</label>
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="date" name="tglawal" id="tglawal" class="form-control" value="<?php echo date('Y-m-01') ?>">
                                                        </div>
                                                        <div class="col-1 text-center">S/D</div>
                                                        <div class="col-5">
                                                            <input type="date" name="tglakhir" id="tglakhir" class="form-control" value="<?php echo date('Y-m-t') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <a href="#" class="btn btn-success btn-sm" id="btnCetakExcel"><i class="fa fa-file-excel"></i> Cetak Excel</a>
                                                    <a href="#" class="btn btn-danger btn-sm" id="btnCetakPdf"><i class="fa fa-file-pdf"></i> Cetak Pdf</a>

                                                    <a href="<?= site_url('dashboarddc/cetakLaporanAnggota') ?>" 
                                                    class="btn btn-dark btn-sm" target="_blank">
                                                        <i class="fa fa-users"></i> Laporan Anggota
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Grafik Line -->
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                <div class="d-flex justify-content-between">
                                                    <h3 class="card-title">Grafik Jumlah Member Baru</h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <p class="d-flex flex-column">
                                                        <span class="text-bold text-lg">Rata-rata Member Baru: <span id="rataratamember">0</span></span>
                                                        <span id="jumlahi">0 Minggu</span>
                                                    </p>
                                                </div>
                                                <div class="position-relative mb-4">
                                                    <canvas id="visitors-chart" height="200"></canvas>
                                                </div>
                                                <div class="d-flex flex-row justify-content-end">
                                                    <span class="mr-2">
                                                        <i class="fas fa-square" style="color: #007bff;"></i> Member Baru DC
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kotak Jumlah per Bulan -->
                                    <?php
                                    $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                                    for ($m = 1; $m <= 12; $m++):
                                        $id = str_pad($m, 2, '0', STR_PAD_LEFT);
                                        ?>
                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah<?php echo $id ?>">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted"><?php echo $namaBulan[$m - 1] ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endfor; ?>

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

<script>
    // FIX: Deklarasi instance di luar agar bisa di-destroy sebelum dibuat ulang
    var visitorsChartInstance = null;

    $(document).ready(function () {
        loadInfoBox();
        loadGrafik();
        loadJumlahMemberPerbulan();
    });

    $('#tglawal, #tglakhir').on('change', function () {
        loadGrafik();
    });

    // ===== INFO BOX =====
    function loadInfoBox() {
        $.ajax({
            url: '<?php echo site_url('dashboarddc/getinfobox') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (data) {
            $('#memberBaruLalu').html(numberWithCommas(data.memberBaruLalu));
            $('#memberBaruIni').html(numberWithCommas(data.memberBaruIni));
            $('#jumlahDc').html(numberWithCommas(data.jumlahDc));
            $('#jumlahMember').html(numberWithCommas(data.jumlahMember));
        })
        .fail(function () {
            console.error("AJAX Error: getinfobox");
        });
    }

    // ===== GRAFIK LINE =====
    function loadGrafik() {
        var tglawal  = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        };

        $.ajax({
            url: '<?php echo site_url('dashboarddc/getgrafikmember') ?>',
            type: 'GET',
            dataType: 'json',
            data: { tglawal: tglawal, tglakhir: tglakhir },
        })
        .done(function (data) {
            $('#rataratamember').html(data.ratarata + ' Jemaat');
            $('#jumlahi').html(data.jumlahi + ' Hari');

            // FIX: Destroy chart lama sebelum buat yang baru
            if (visitorsChartInstance) {
                visitorsChartInstance.destroy();
            }

            var ctx = $('#visitors-chart').get(0).getContext('2d');
            visitorsChartInstance = new Chart(ctx, {
                data: {
                    labels: data.datatanggal,
                    datasets: [{
                        type: 'line',
                        data: data.jumlahmember,
                        backgroundColor: 'transparent',
                        borderColor: '#007bff',
                        pointBorderColor: '#007bff',
                        pointBackgroundColor: '#007bff',
                        fill: false
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: { mode: 'index', intersect: true },
                    hover:    { mode: 'index', intersect: true },
                    legend:   { display: false },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({ beginAtZero: true, suggestedMax: 10 }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: { display: false },
                            ticks: ticksStyle
                        }]
                    }
                }
            });
        })
        .fail(function () {
            console.error("AJAX Error: getgrafikmember");
        });
    }

    // ===== JUMLAH MEMBER PER BULAN =====
    function loadJumlahMemberPerbulan() {
        $.ajax({
            url: '<?php echo site_url('dashboarddc/getjumlahmemberperbulan') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (data) {
            for (var m = 1; m <= 12; m++) {
                var key = 'm' + (m < 10 ? '0' + m : m);
                var id  = 'jumlah' + (m < 10 ? '0' + m : m);
                $('#' + id).html(data[key] || 0);
            }
        })
        .fail(function () {
            console.error("AJAX Error: getjumlahmemberperbulan");
        });
    }

    // ===== CETAK =====
    $(document).on('click', '#btnCetakPdf', function (e) {
        e.preventDefault();
        var tglawal  = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();
        window.open('<?php echo site_url('dashboarddc/cetak/pdf/') ?>' + tglawal + '/' + tglakhir, '_blank');
    });

    $(document).on('click', '#btnCetakExcel', function (e) {
        e.preventDefault();
        var tglawal  = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();
        window.open('<?php echo site_url('dashboarddc/cetak/excel/') ?>' + tglawal + '/' + tglakhir, '_blank');
    });
</script>

</body>
</html>