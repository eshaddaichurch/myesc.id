<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");

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

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Member Baru<br>Bulan Ini</span>
                                <span class="info-box-number" id="memberBaruIni">
                                    <span id="kenaikanbulanlalu">100</span>
                                    <small>Orang</small>
                                </span>
                            </div>
                        </div>
                    </div>



                    <div class="clearfix hidden-md-up"></div>

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

                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah <br>Member</span>
                                <span class="info-box-number" id="jumlahMemberPersen">
                                    <span id="jumlahMember">0</span>
                                    <small>Orang</small>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>


                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-12 mb-3">

                                        <div class="card card-body shadow">
                                            <div class="row">

                                                

                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="">Periode</label>
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="date" name="tglawal" id="tglawal" class="form-control" value="<?php echo date('Y-m-01') ?>">
                                                        </div>
                                                        <div class="col-1 text-center">
                                                            S/D
                                                        </div>
                                                        <div class="col-5">
                                                            <input type="date" name="tglakhir" id="tglakhir" class="form-control" value="<?php echo date('Y-m-t') ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 pt-4">
                                                    <a href="#" class="btn btn-success btn-sm" id="btnCetakExcel"><i class="fa fa-file-excel"></i> Cetak Excel</a>
                                                    <a href="#" class="btn btn-danger btn-sm" id="btnCetakPdf"><i class="fa fa-file-pdf"></i> Cetak Pdf</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>


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


                                    


                                    


                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah01">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Jan</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah02">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Feb</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah03">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Mar</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah04">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Apr</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah05">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Mei</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah06">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Jun</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah07">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Jul</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah08">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Ags</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah09">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Sep</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah10">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Okt</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah11">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Nov</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-2">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <label for=""><i class="fa fa-users text-primary"></i></label>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="font-weight-bold" id="jumlah12">0</span>
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <span class="text-muted">Des</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>


            </div> <!-- ./card-body -->

        </div> <!-- /.card -->
    </div> <!-- /.col -->
</div> <!-- /.row -->
<!-- Main row -->




<?php $this->load->view("template/footer") ?>


<!-- ChartJS -->
<script src="<?php echo (base_url()) ?>assets/adminlte/plugins/chart.js/Chart.min.js"></script>


<script>
    $(document).ready(function() {
        loadInfoBox();
        loadGrafik();
        loadJumlahMemberPerbulan();
    });



    $('#tglawal').change(function(e) {
        loadGrafik();
    });
    $('#tglakhir').change(function(e) {
        loadGrafik();
    });

    function loadInfoBox() {

        //INFO BOX
        $.ajax({
                url: '<?php echo site_url("dashboarddc/getinfobox") ?>',
                type: 'GET',
                dataType: 'json',
            })
            .done(function(resultinfo) {
                console.log(resultinfo);
                $('#memberBaruLalu').html(numberWithCommas(resultinfo.memberBaruLalu));
                $('#memberBaruIni').html(numberWithCommas(resultinfo.memberBaruIni));
                $('#jumlahDc').html(numberWithCommas(resultinfo.jumlahDc));
                $('#jumlahMember').html(numberWithCommas(resultinfo.jumlahMember));
            })
            .fail(function() {
                console.log("error");
            });

    }

    function loadGrafik() {

        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        var ticksStyle = {
            fontColor: '#495057',
            fontStyle: 'bold'
        }

        var mode = 'index'
        var intersect = true


        $.ajax({
                url: '<?php echo site_url("dashboarddc/getgrafikmember") ?>',
                type: 'GET',
                dataType: 'json',
                data: {
                    'tglawal': tglawal,
                    'tglakhir': tglakhir
                },
            })
            .done(function(getgrafikmemberResult) {
                console.log(getgrafikmemberResult);
                console.log(getgrafikmemberResult.jumlahmember);

                $('#rataratamember').html(getgrafikmemberResult.ratarata + ' Jemaat');
                $('#jumlahi').html(getgrafikmemberResult.jumlahi + ' Minggu');

                var $visitorsChart = $('#visitors-chart')
                var visitorsChart = new Chart($visitorsChart, {
                    data: {
                        labels: getgrafikmemberResult.datatanggal,
                        datasets: [{
                                type: 'line',
                                data: getgrafikmemberResult.jumlahmember,
                                backgroundColor: 'transparent',
                                borderColor: '#007bff',
                                pointBorderColor: '#007bff',
                                pointBackgroundColor: '#007bff',
                                fill: false
                                // pointHoverBackgroundColor: '#007bff',
                                // pointHoverBorderColor    : '#007bff'
                            },
                        ]
                    },
                    options: {
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
                                // display: false,
                                gridLines: {
                                    display: true,
                                    lineWidth: '4px',
                                    color: 'rgba(0, 0, 0, .2)',
                                    zeroLineColor: 'transparent'
                                },
                                ticks: $.extend({
                                    beginAtZero: true,
                                    suggestedMax: 200
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
                    }
                })

            })
            .fail(function() {
                console.log("error getgrafikmember");
            });


    }

    function loadJumlahMemberPerbulan() {
        $.ajax({
            url: '<?= site_url('dashboarddc/getjumlahmemberperbulan') ?>',
            type: 'GET',
            dataType: 'json',
        })
        .done(function(response) {
            console.log(response);

            $('#jumlah01').html(response.m01);
            $('#jumlah02').html(response.m02);
            $('#jumlah03').html(response.m03);
            $('#jumlah04').html(response.m04);
            $('#jumlah05').html(response.m05);
            $('#jumlah06').html(response.m06);
            $('#jumlah07').html(response.m07);
            $('#jumlah08').html(response.m08);
            $('#jumlah09').html(response.m09);
            $('#jumlah10').html(response.m10);
            $('#jumlah11').html(response.m11);
            $('#jumlah12').html(response.m12);
        })
        .fail(function() {
            console.log('error');
        });
    }

    $(document).on('click', '#btnCetakPdf', function(e) {
        e.preventDefault();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        window.open('<?php echo site_url('dashboarddc/cetak/pdf/') ?>' + tglawal + '/' + tglakhir, '_blank');
    });


    $(document).on('click', '#btnCetakExcel', function(e) {
        e.preventDefault();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        window.open('<?php echo site_url('dashboarddc/cetak/excel/') ?>' + tglawal + '/' + tglakhir, '_blank');
    });


</script>

</body>

</html>