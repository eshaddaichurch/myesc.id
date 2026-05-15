<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>

<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Dashboard Kehadiran</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Dashboard Kehadiran</li>
        </ol>
    </div>
</div>

<div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="card" id="cardcontent">
            <div class="card-body">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Kehadiran<br>Bulan Lalu</span>
                                <span class="info-box-number">
                                    <span id="kehadiranbulanlalu">0</span>
                                    <small>Jemaat</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-percentage"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Kenaikan/Penurunan<br>Bulan Lalu</span>
                                <!-- FIX #3: id dipindah ke span luar agar addClass warna kena seluruh blok angka -->
                                <span class="info-box-number" id="kenaikanbulanlaluPersen">
                                    <span id="kenaikanbulanlalu">0</span>
                                    <small>%</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <!-- FIX: typo "Kehadiaran" → "Kehadiran" -->
                                <span class="info-box-text">Kehadiran<br>Bulan Ini</span>
                                <span class="info-box-number">
                                    <span id="kehadiranbulanini">0</span>
                                    <small>Jemaat</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-percentage"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Kenaikan/Penurunan<br>Bulan ini</span>
                                <span class="info-box-number" id="kenaikanbulaniniPersen">
                                    <span id="kenaikanbulanini">0</span>
                                    <small>%</small>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <!-- Filter -->
                                    <div class="col-12 mb-3">
                                        <div class="card card-body shadow">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="idabsenjenis">Jenis Absen</label>
                                                        <select name="idabsenjenis" id="idabsenjenis" class="form-control">
                                                            <?php
                                                            // NOTE: idealnya data ini dikirim dari controller via $data,
                                                            // bukan di-query langsung di view (prinsip MVC).
                                                            // Tapi untuk sementara dibiarkan agar tidak mengubah controller index().
                                                            $rsAbsenJenis = $this->db->query("SELECT * FROM absenjenis WHERE statusaktif='Aktif' ORDER BY idabsenjenis");
                                                            if ($rsAbsenJenis->num_rows() > 0) {
                                                                foreach ($rsAbsenJenis->result() as $row) {
                                                                    echo '<option value="' . $row->idabsenjenis . '">' . $row->namaabsenjenis . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
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
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SCORECARD BERTINGKAT: Ibadah → Ruangan -->
                                    <div class="col-12 mb-3">
                                        <div class="card shadow-sm">
                                            <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
                                                <h5 class="card-title mb-0 text-dark">
                                                    <i class="fas fa-layer-group text-primary mr-2"></i>
                                                    Kehadiran per Ibadah & Ruangan
                                                    <small class="text-muted ml-2" id="scorecard-periode"></small>
                                                </h5>
                                                <button class="btn btn-xs btn-outline-secondary" type="button" data-toggle="collapse" data-target="#scorecardContent" aria-expanded="true">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </div>
                                            <div class="collapse show" id="scorecardContent">
                                                <div class="card-body py-3">
                                                    <div id="scorecard-container">
                                                        <!-- Loading state -->
                                                        <div class="text-center text-muted py-3">
                                                            <i class="fas fa-spinner fa-spin mr-2"></i> Memuat data ruangan...
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SCORECARD: Total Kehadiran per Ibadah (Responsive Grid) -->
                                    <div class="col-12 mb-3">
                                        <div class="card shadow-sm">
                                            <!-- <div class="card-header bg-white py-2">
                                                <h5 class="card-title mb-0 text-dark">
                                                    <i class="fas fa-chart-pie text-primary mr-2"></i>
                                                    Total Kehadiran per Ibadah
                                                    <small class="text-muted ml-2" id="scorecard-periode"></small>
                                                </h5>
                                            </div> -->
                                            <div class="card-body py-3">
                                                <div class="row text-center">
                                                    
                                                    <!-- Ibadah I -->
                                                    <div class="col-6 col-sm-4 col-md-2 mb-2">
                                                        <div class="p-2 border rounded bg-light">
                                                            <div class="text-muted small">Ibadah I</div>
                                                            <div class="h4 font-weight-bold text-primary mb-0" id="total-ibadah1">0</div>
                                                            <div class="text-muted small">jemaat</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Ibadah II -->
                                                    <div class="col-6 col-sm-4 col-md-2 mb-2">
                                                        <div class="p-2 border rounded bg-light">
                                                            <div class="text-muted small">Ibadah II</div>
                                                            <div class="h4 font-weight-bold text-success mb-0" id="total-ibadah2">0</div>
                                                            <div class="text-muted small">jemaat</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Ibadah III -->
                                                    <div class="col-6 col-sm-4 col-md-2 mb-2">
                                                        <div class="p-2 border rounded bg-light">
                                                            <div class="text-muted small">Ibadah III</div>
                                                            <div class="h4 font-weight-bold text-warning mb-0" id="total-ibadah3">0</div>
                                                            <div class="text-muted small">jemaat</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Ibadah IV -->
                                                    <div class="col-6 col-sm-4 col-md-2 mb-2">
                                                        <div class="p-2 border rounded bg-light">
                                                            <div class="text-muted small">Ibadah IV</div>
                                                            <div class="h4 font-weight-bold text-danger mb-0" id="total-ibadah4">0</div>
                                                            <div class="text-muted small">jemaat</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Ibadah V -->
                                                    <!-- <div class="col-6 col-sm-4 col-md-2 mb-2">
                                                        <div class="p-2 border rounded bg-light">
                                                            <div class="text-muted small">Ibadah V</div>
                                                            <div class="h4 font-weight-bold text-orange mb-0" id="total-ibadah5">0</div>
                                                            <div class="text-muted small">jemaat</div>
                                                        </div>
                                                    </div> -->
                                                    
                                                    <!-- TOTAL ALL -->
                                                    <div class="col-6 col-sm-4 col-md-2 mb-2">
                                                        <div class="p-2 border rounded bg-primary text-white">
                                                            <div class="text-white-50 small">TOTAL</div>
                                                            <div class="h4 font-weight-bold mb-0" id="total-semua">0</div>
                                                            <div class="text-white-50 small">jemaat</div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Grafik Kehadiran per Ibadah -->
                                    <!-- <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                <div class="d-flex justify-content-between">
                                                    <h3 class="card-title">Grafik Kehadiran Jemaat</h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <p class="d-flex flex-column">
                                                        <span class="text-bold text-lg">Rata-rata Kehadiran: <span id="totalhit">0</span></span>
                                                        <span id="jumlahi">0 Minggu</span>
                                                    </p>
                                                </div>
                                                <div class="position-relative mb-4">
                                                    <canvas id="visitors-chart" height="200"></canvas>
                                                </div>
                                                <div class="d-flex flex-row justify-content-end">
                                                    <span class="mr-2"><i class="fas fa-square" style="color: #007bff;"></i> Ibadah I</span>
                                                    <span class="mr-2"><i class="fas fa-square" style="color: #27D18B;"></i> Ibadah II</span>
                                                    <span class="mr-2"><i class="fas fa-square" style="color: #EAC575;"></i> Ibadah III</span>
                                                    <span class="mr-2"><i class="fas fa-square" style="color: #D31D48;"></i> Ibadah IV</span>
                                                    <span class="mr-2"><i class="fas fa-square" style="color: #FF5F00;"></i> Ibadah V</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- Grafik Total Kehadiran -->
                                    <!-- FIX #2: id diubah dari "totalnewvisitor" → "totalkehadiran" (duplikat dihilangkan) -->
                                    <!-- <div class="col-6">
                                        <div class="card">
                                            <div class="card-header border-0">
                                                <div class="d-flex justify-content-between">
                                                    <h3 class="card-title">Grafik Total Kehadiran Jemaat</h3>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <p class="d-flex flex-column">
                                                        <span class="text-bold text-lg">Rata-rata Total Kehadiran: <span id="totalkehadiran">0</span> Jemaat</span>
                                                        <span>6 Bulan Terakhir</span>
                                                    </p>
                                                </div>
                                                <div class="position-relative mb-4">
                                                    <canvas id="total-kehadiran-chart" height="200"></canvas>
                                                </div>
                                                <div class="d-flex flex-row justify-content-end">
                                                    <span class="mr-2">
                                                        <i class="fas fa-square text-primary"></i> Total Kehadiran
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- Card per bulan Jan-Des -->
                                    <?php
                                    $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
                                    foreach ($bulan as $idx => $nama) {
                                        $no = str_pad($idx + 1, 2, '0', STR_PAD_LEFT);
                                        echo '
                                        <div class="col-1">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 text-center">
                                                            <label><i class="fa fa-users text-primary"></i></label>
                                                        </div>
                                                        <div class="col-12 text-center">
                                                            <span class="font-weight-bold" id="jumlah' . $no . '">0</span>
                                                        </div>
                                                        <div class="col-12 text-center">
                                                            <span class="text-muted">' . $nama . '</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div> <!-- ./card-body -->
        </div> <!-- /.card -->
    </div> <!-- /.col -->
</div> <!-- /.row -->


<style>
    .text-orange { color: #FF5F00 !important; }
    .bg-orange { background-color: #FF5F00 !important; }
</style>

<?php $this->load->view('template/footer') ?>

<!-- ChartJS -->
<script src="<?php echo base_url() ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>

<!-- Tambahkan di atas script utama -->
<script>
// ===== ANIMATED COUNTER (Opsional) =====
function animateValue(id, start, end, duration) {
    if (start === end) return;
    var range = end - start;
    var current = start;
    var increment = end > start ? 1 : -1;
    var stepTime = Math.abs(Math.floor(duration / range));
    if (stepTime < 10) stepTime = 10;
    var obj = document.getElementById(id);
    var timer = setInterval(function() {
        current += increment;
        obj.innerHTML = numberWithCommas(current);
        if (current == end) clearInterval(timer);
    }, stepTime);
}

// Pakai di update scorecard:
// animateValue('total-ibadah1', 0, res.totalIbadah1, 1000);
</script>

<script>
    // FIX #1: Variabel chart dideklarasikan di luar fungsi
    // agar bisa di-destroy sebelum dibuat ulang
    var visitorsChart = null;
    var totalKehadiranChart = null;
    var salesChart = null;

    $(document).ready(function () {
        loadInfoBox();
        loadGrafik();
        loadScorecardLokasi();  // ← Tambahkan ini
    });

    $('#tglawal, #tglakhir, #idabsenjenis').change(function () {
        loadGrafik();
        loadScorecardLokasi();  // ← Refresh scorecard lokasi juga
    });

    function loadInfoBox() {
        $.ajax({
            url: '<?php echo site_url('dashboardkehadiran/getinfobox') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function (resultinfo) {
            $('#kehadiranbulanini').html(numberWithCommas(resultinfo.kehadiranbulanini));
            $('#kehadiranbulanlalu').html(numberWithCommas(resultinfo.kehadiranbulanlalu));
            $('#kenaikanbulanlalu').html(resultinfo.kenaikanbulanlalu);
            $('#kenaikanbulanini').html(resultinfo.kenaikanbulanini);

            // FIX #3: removeClass dulu sebelum addClass agar tidak numpuk
            $('#kenaikanbulaniniPersen')
                .removeClass('text-danger text-success')
                .addClass(parseInt(resultinfo.kenaikanbulanini) < 0 ? 'text-danger' : 'text-success');

            $('#kenaikanbulanlaluPersen')
                .removeClass('text-danger text-success')
                .addClass(parseInt(resultinfo.kenaikanbulanlalu) < 0 ? 'text-danger' : 'text-success');
        })
        .fail(function () {
            console.log("error loadInfoBox");
        });
    }

    function loadGrafik() {
        var idabsenjenis = $('#idabsenjenis').val();
        var tglawal     = $('#tglawal').val();
        var tglakhir    = $('#tglakhir').val();

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        };
        var mode      = 'index';
        var intersect = true;

        // ===== GRAFIK KEHADIRAN PER IBADAH =====
        $.ajax({
            url: '<?php echo site_url('dashboardkehadiran/getgrafikabsen') ?>',
            type: 'GET',
            dataType: 'json',
            data: { idabsenjenis, tglawal, tglakhir },
        })
        .done(function (res) {
            $('#totalhit').html(res.jumlahPerMinggu + ' Jemaat');
            $('#jumlahi').html(res.jumlahi + ' Minggu');

            // FIX #1: Destroy chart lama sebelum buat baru
            if (visitorsChart) {
                visitorsChart.destroy();
            }
            visitorsChart = new Chart($('#visitors-chart'), {
                data: {
                    labels: res.datatanggal,
                    datasets: [
                        {
                            type: 'line', label: 'Ibadah I',
                            data: res.datahadiribadah1,
                            backgroundColor: 'transparent', fill: false,
                            borderColor: '#007bff', pointBorderColor: '#007bff', pointBackgroundColor: '#007bff',
                        },
                        {
                            type: 'line', label: 'Ibadah II',
                            data: res.datahadiribadah2,
                            // FIX #4: typo 'tansparent' → 'transparent'
                            backgroundColor: 'transparent', fill: false,
                            borderColor: '#27D18B', pointBorderColor: '#27D18B', pointBackgroundColor: '#27D18B',
                        },
                        {
                            type: 'line', label: 'Ibadah III',
                            data: res.datahadiribadah3,
                            backgroundColor: 'transparent', fill: false,
                            borderColor: '#EAC575', pointBorderColor: '#EAC575', pointBackgroundColor: '#EAC575',
                        },
                        {
                            type: 'line', label: 'Ibadah IV',
                            data: res.datahadiribadah4,
                            backgroundColor: 'transparent', fill: false,
                            borderColor: '#D31D48', pointBorderColor: '#D31D48', pointBackgroundColor: '#D31D48',
                        },
                        {
                            type: 'line', label: 'Ibadah V',
                            data: res.datahadiribadah5,
                            backgroundColor: 'transparent', fill: false,
                            borderColor: '#FF5F00', pointBorderColor: '#FF5F00', pointBackgroundColor: '#FF5F00',
                        },
                    ]
                },
                options: buildChartOptions(mode, intersect, ticksStyle)
            });

            // FIX #1: Destroy chart lama sebelum buat baru
            if (totalKehadiranChart) {
                totalKehadiranChart.destroy();
            }
            totalKehadiranChart = new Chart($('#total-kehadiran-chart'), {
                data: {
                    labels: res.datatanggal,
                    datasets: [{
                        type: 'line', label: 'Total Kehadiran',
                        data: res.datatotalhadiribadah,
                        backgroundColor: 'transparent', fill: false,
                        borderColor: '#007bff', pointBorderColor: '#007bff', pointBackgroundColor: '#007bff',
                    }]
                },
                options: buildChartOptions(mode, intersect, ticksStyle)
            });

            // Update rata-rata total kehadiran
            // FIX #2: id sudah diubah jadi "totalkehadiran" di HTML
            $('#totalkehadiran').html(res.jumlahPerMinggu);

            // Update card per bulan
            if (res.jumlahPerbulan.length > 0) {
                var pb = res.jumlahPerbulan[0];
                for (var m = 1; m <= 12; m++) {
                    var key = 'jumlah' + String(m).padStart(2, '0');
                    $('#' + key).html(pb[key]);
                }
            }

            // ... setelah update card per bulan, tambahkan:

            // ===== UPDATE SCORECARD PER IBADAH =====
            if (res.totalIbadah1 !== undefined) {
                $('#total-ibadah1').html(numberWithCommas(res.totalIbadah1));
                $('#total-ibadah2').html(numberWithCommas(res.totalIbadah2));
                $('#total-ibadah3').html(numberWithCommas(res.totalIbadah3));
                $('#total-ibadah4').html(numberWithCommas(res.totalIbadah4));
                $('#total-ibadah5').html(numberWithCommas(res.totalIbadah5));
                $('#total-semua').html(numberWithCommas(res.totalSemua));
                
                // Update label periode di scorecard
                if (res.periodeDisplay) {
                    $('#scorecard-periode').html('(' + res.periodeDisplay + ')');
                }
            }
        })
        .fail(function () {
            console.log("error getgrafikabsen");
        });

        // ===== GRAFIK PERSENTASE (hidden, tetap diproses) =====
        $.ajax({
            url: '<?php echo site_url('dashboardkehadiran/getpersentase') ?>',
            type: 'GET',
            dataType: 'json',
            data: { idabsenjenis, tglawal, tglakhir },
        })
        .done(function (res) {
            // FIX #1: Destroy chart lama sebelum buat baru
            if (salesChart) {
                salesChart.destroy();
            }
            salesChart = new Chart($('#sales-chart'), {
                data: {
                    labels: res.datatanggal,
                    datasets: [{
                        type: 'line',
                        data: res.datapersentase,
                        backgroundColor: 'transparent', fill: false,
                        borderColor: '#08E0F3', pointBorderColor: '#08E0F3', pointBackgroundColor: '#08E0F3',
                    }]
                },
                options: buildChartOptions(mode, intersect, ticksStyle)
            });
        })
        .fail(function () {
            console.log("error getpersentase");
        });
    }

    // Helper: opsi chart yang sama dipakai di 3 chart → tidak perlu copy-paste
    function buildChartOptions(mode, intersect, ticksStyle) {
        return {
            maintainAspectRatio: false,
            tooltips:  { mode, intersect },
            hover:     { mode, intersect },
            legend:    { display: false },
            scales: {
                yAxes: [{
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({ beginAtZero: true, suggestedMax: 200 }, ticksStyle)
                }],
                xAxes: [{
                    display: true,
                    gridLines: { display: false },
                    ticks: ticksStyle
                }]
            }
        };
    }

    
    function loadScorecardLokasi() {
    var idabsenjenis = $('#idabsenjenis').val();
    var tglawal = $('#tglawal').val();
    var tglakhir = $('#tglakhir').val();

    $.ajax({
        url: '<?php echo site_url('dashboardkehadiran/getgrafikabsenperlokasi') ?>',
        type: 'GET',
        dataType: 'json',
        data: { idabsenjenis: idabsenjenis, tglawal: tglawal, tglakhir: tglakhir },
    })
    .done(function(res) {
        console.log("Data Ruangan Berhasil:", res); // Cek Console Browser (F12)
        
        var container = $('#scorecard-container');
        container.empty(); // Bersihkan loading

        if (!res || res.length === 0) {
            container.html('<div class="text-center text-muted py-3">Tidak ada data ruangan</div>');
            return;
        }

        // Grouping data
        var grouped = {};
        res.forEach(function(item) {
            var sesi = item.namasesi || 'Tanpa Sesi';
            if (!grouped[sesi]) grouped[sesi] = [];
            grouped[sesi].push(item);
        });

        // Render HTML
        var html = '<div class="row">';
        for (var sesi in grouped) {
            var items = grouped[sesi];
            var totalSesi = items.reduce((sum, item) => sum + item.total, 0);
            
            html += `
            <div class="col-12 mb-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 font-weight-bold">${sesi}</h6>
                        <span class="badge badge-primary badge-pill">${numberWithCommas(totalSesi)} Jemaat</span>
                    </div>
                    <div class="card-body py-2">
                        <div class="row">`;
            
            items.forEach(function(loc) {
                html += `
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-2">
                    <div class="p-2 border rounded text-center bg-white">
                        <div class="text-muted small">${loc.namalokasi}</div>
                        <div class="h5 font-weight-bold mb-0 text-primary">${numberWithCommas(loc.total)}</div>
                    </div>
                </div>`;
            });

            html += `</div></div></div></div>`;
        }
        html += '</div>';

        container.html(html);
    })
    .fail(function(err) {
        console.error("Gagal Load Ruangan:", err);
        $('#scorecard-container').html('<div class="text-danger text-center">Gagal memuat data</div>');
    });
}
</script>

</body>
</html>