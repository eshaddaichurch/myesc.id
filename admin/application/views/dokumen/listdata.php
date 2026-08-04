<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');

?>

<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Review Dokumen</h4>
    </div>
    <div class="col-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
            <li class="breadcrumb-item active">Review Dokumen</li>
        </ol>
    </div>
</div>

<div class="row" id="toni-content">

    <!-- Info box ringkasan status -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-0"><?php echo $jumlahMenunggu; ?></h3>
                <span class="text-warning">Menunggu Review</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-0"><?php echo $jumlahDisetujui; ?></h3>
                <span class="text-success">Disetujui</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="mb-0"><?php echo $jumlahDitolak; ?></h3>
                <span class="text-danger">Ditolak</span>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card" id="cardcontent">
            <div class="card-header">
                <h5 class="card-title">List Dokumen Jemaat</h5>
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

                    <!-- FITUR BARU: filter jenis dokumen -->
                    <div class="col-md-4 mb-3">
                        <label for="filterJenisDokumen">Jenis Dokumen</label>
                        <select id="filterJenisDokumen" class="form-control">
                            <option value="">Semua Jenis Dokumen</option>
                            <?php if ($rsJenisDokumen->num_rows() > 0) {
                                foreach ($rsJenisDokumen->result() as $rowJenis) { ?>
                                    <option value="<?php echo $rowJenis->kodedokumen ?>"><?php echo $rowJenis->namadokumen ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-condesed" id="table">
                                <thead>
                                    <tr class="bg-primary">
                                        <th style="width: 5%; text-align: center;">No</th>
                                        <th style="text-align: left;">Nama Jemaat</th>
                                        <th style="text-align: center;">Jenis Dokumen</th>
                                        <th style="text-align: center;">Tgl Upload</th>
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

<?php $this->load->view('template/footer') ?>

<script type="text/javascript">
    var table;

    $(document).ready(function() {
        table = $("#table").DataTable({
            "select": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('dokumen/datatablesource') ?>",
                "type": "POST",
                // FITUR BARU: kirim filter jenis dokumen setiap reload
                "data": function(d) {
                    d.kodedokumen = $('#filterJenisDokumen').val();
                }
            },
            "columnDefs": [{
                    "targets": [0],
                    "orderable": false,
                    "className": "dt-body-center"
                },
                {
                    "targets": [1],
                    "className": "dt-body-left"
                },
                {
                    "targets": [2],
                    "className": "dt-body-center"
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
                    "orderable": false,
                    "className": "dt-body-center"
                },
            ],
        });

        // FITUR BARU: filter berubah -> reload tabel
        $('#filterJenisDokumen').on('change', function() {
            table.ajax.reload();
        });
    }); //end (document).ready
</script>

</body>

</html>