<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");

?>
<style>
  .nav-tabs .nav-link.active {
    font-weight:bold;
    background-color: transparent;
    border-bottom:3px solid #dd0000;
    border-right: none;
    border-left: none;
    border-top: none;
}

</style>
  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2" id="lblnamakelas">Konfirmasi Pendaftaran Member DC</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active" id="breadcrumbnamakelas">Konfirmasi Pendaftaran Member DC</li>
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
                $pesan = $this->session->flashdata("pesan");
                if (!empty($pesan)) {
                  echo $pesan;
                }
              ?>
            </div> 
            <div class="col-12">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label for="" class="col-md-3 col-form-label">Filter Nama DC</label>
                    <div class="col-md-4">
                      <select name="iddc" id="iddc" class="form-control select2">
                        <option value="">Semua DC...</option>
                        <?php  
                          foreach ($rsDc->result() as $row) {
                            echo '
                              <option value="'.$row->iddc.'">'.$row->namadc.'</option>
                            ';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12 mb-3"><hr></div>
            <div class="col-md-12">
              <!-- datatable -->
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-condesed" id="table">
                  <thead>
                    <tr class="bg-primary" style="">
                      <th style="width: 5%; text-align: center;">No</th>
                      <th style="width: 15%; text-align: center;">Tgl Permohonan</th>
                      <th style="text-align: left;">Nama Jemaat</th>
                      <th style="text-align: center;">Nama DC</th>
                      <th style="text-align: center;">Status</th>
                      <th style="text-align: center; width: 15%;">Aksi</th>
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




<?php $this->load->view("template/footer") ?>

<?php $this->load->view('konfirmasidcm/modalKonfirmasi'); ?>


<script type="text/javascript">

  var table;
  var iddc = $('#iddc').val();

  $(document).ready(function() {

    $('.select2').select2();
    
    //defenisi datatable
    table = $("#table").DataTable({ 
        "select": true,
        "processing": true, 
        "serverSide": true, 
        "order": [], 
         "ajax": {
            "url": "<?php echo site_url('konfirmasidcm/datatablesource')?>",
            "type": "POST",
              "data": function ( d ) {
                  d.iddc = $('#iddc').val(); // Ambil nilai TERKINI saat request
              }

        },
        "columnDefs": [
                        { "targets": [ 0 ], "orderable": false, "className": "dt-body-center" },
                        { "targets": [ 1 ], "className": "dt-body-center" },
                        { "targets": [ 2 ], "className": "dt-body-left" },
                        { "targets": [ 3 ], "className": "dt-body-center" },
                        { "targets": [ 4 ], "className": "dt-body-center" },
                        { "targets": [ 5 ], "orderable": false, "className": "dt-body-center" },
        ],
 
    });

  }); //end (document).ready

  $(document).on('click', '#btnDetail', function() {
      var idpermohonan = $(this).attr("data-idpermohonan");
      loadModalKonfirmasi(idpermohonan);
  });
  

  $(document).on('change', '#iddc', function() {
      table.ajax.reload(); // Reload tabel dengan filter baru
    });

</script>

</body>
</html>

