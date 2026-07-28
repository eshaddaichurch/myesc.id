<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

?>

<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Jemaat Baru</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item active">Jemaat Baru</li>
        </ol>

    </div>
</div>

<div class="row" id="toni-content">
    <div class="col-md-12">
        <div class="card" id="cardcontent">
            <div class="card-header">
                <h5 class="card-title">List Data Jemaat Baru</h5>
            </div>
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

                    <!-- FITUR BARU: Filter periode tanggal + tombol cetak PDF -->
                    <div class="col-md-12 mb-3">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-3 mb-2">
                                <label for="filterTglMulai">Tgl Daftar Mulai</label>
                                <input type="date" class="form-control" id="filterTglMulai">
                            </div>
                            <div class="form-group col-md-3 mb-2">
                                <label for="filterTglAkhir">Tgl Daftar Akhir</label>
                                <input type="date" class="form-control" id="filterTglAkhir">
                            </div>
                            <div class="form-group col-md-6 mb-2">
                                <button type="button" class="btn btn-primary" id="btnFilter">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <button type="button" class="btn btn-default" id="btnResetFilter">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                                <a href="#" target="_blank" class="btn btn-danger" id="btnCetakPdf">
                                    <i class="fas fa-file-pdf"></i> Cetak PDF
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- datatable -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condesed" id="table">
                                <thead>
                                    <tr class="bg-primary" style="">
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="text-align: left;">Nama Jemaat</th>
                                        <th style="text-align: center;">Tgl Daftar</th>
                                        <th style="text-align: center;">Email</th>
                                        <th style="text-align: center;">No HP</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center; width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>



                </div> <!-- /.row -->
            </div> <!-- ./card-body -->
        </div> <!-- /.card -->
    </div> <!-- /.col -->
</div> <!-- /.row -->
<!-- Main row -->




<?php $this->load->view('template/footer') ?>



<script type="text/javascript">
    var table;

    $(document).ready(function() {

        //defenisi datatable
        table = $("#table").DataTable({
            "select": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('jemaatbaru/datatablesource') ?>",
                "type": "POST",
                // FITUR BARU: ikut kirim parameter filter periode setiap kali
                // DataTables reload (search, ganti halaman, klik tombol Filter, dll)
                "data": function(d) {
                    d.tgl_mulai = $('#filterTglMulai').val();
                    d.tgl_akhir = $('#filterTglAkhir').val();
                }
            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                    "className": "dt-body-center"
                },
                {
                    "targets": [1],
                    "className": "dt-body-center"
                },
                {
                    "targets": [2],
                    "className": "dt-body-left"
                },
                {
                    "targets": [3],
                    "className": "dt-body-center"
                },
                {
                    "targets": [4],
                    "className": "dt-body-center"
                },
                {
                    "targets": [5],
                    "className": "dt-body-center"
                },
                {
                    "targets": [6],
                    "orderable": false,
                    "className": "dt-body-center"
                },
            ],

        });

        // FITUR BARU: update link tombol cetak PDF supaya ikut bawa filter aktif
        function updateLinkCetakPdf() {
            var tglMulai = $('#filterTglMulai').val();
            var tglAkhir = $('#filterTglAkhir').val();
            var url = "<?php echo site_url('jemaatbaru/cetakpdf') ?>";
            var params = [];
            if (tglMulai) params.push('tgl_mulai=' + encodeURIComponent(tglMulai));
            if (tglAkhir) params.push('tgl_akhir=' + encodeURIComponent(tglAkhir));
            if (params.length > 0) {
                url += '?' + params.join('&');
            }
            $('#btnCetakPdf').attr('href', url);
        }
        updateLinkCetakPdf();

        // FITUR BARU: tombol Filter -> reload DataTables dengan filter aktif
        $('#btnFilter').on('click', function() {
            table.ajax.reload();
            updateLinkCetakPdf();
        });

        // FITUR BARU: tombol Reset -> kosongkan filter lalu reload
        $('#btnResetFilter').on('click', function() {
            $('#filterTglMulai').val('');
            $('#filterTglAkhir').val('');
            table.ajax.reload();
            updateLinkCetakPdf();
        });

    }); //end (document).ready


    $(document).on("click", "#hapus", function(e) {
        var link = $(this).attr("href");
        e.preventDefault();
        bootbox.confirm("Anda yakin ingin menghapus data ini ?", function(result) {
            if (result) {
                document.location.href = link;
            }
        });
    });
</script>

</body>

</html>