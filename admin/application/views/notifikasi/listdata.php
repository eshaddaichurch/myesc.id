<?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");

?>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Notifikasi</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active">Notifikasi</li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <div class="card" id="cardcontent">
        <div class="card-header">
          <h5 class="card-title">List Data Notifikasi</h5>
        </div>
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

            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-12">
                  <label for="">Tanggal Notifikasi</label>
                </div>
                <div class="col-md-5">
                  <input type="date" name="tglawal" id="tglawal" class="form-control" value="<?php echo date('Y-m-d') ?>">
                </div>
                <label for="" class="col-md-1 col-form-label">S/D</label>
                <div class="col-md-5">
                  <input type="date" name="tglakhir" id="tglakhir" class="form-control" value="<?php echo date('Y-m-d') ?>">
                </div>

              </div>
            </div>
            <div class="col-md-12">
              <!-- datatable -->
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-condesed text-sm" id="table">
                  <thead>
                    <tr class="" style="">
                      <th style="width: 5%; text-align: center;">No</th>
                      <th style="text-align: center;">Deskripsi</th>
                      <th style="width: 20%; text-align: center;">Tanggal</th>
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
            "url": "<?php echo site_url('notifikasi/datatablesource')?>",
            "type": "POST",
            "data": function ( d ) {
                  d.tglawal = $('#tglawal').val();
                  d.tglakhir = $('#tglakhir').val();
              }
        },
        "columnDefs": [
                        { "targets": [ 0 ], "orderable": false, "className": "dt-body-center" },
                        { "targets": [ 1 ], "className": "dt-body-left" },
                        { "targets": [ 2 ], "orderable": false, "className": "dt-body-center" },
        ],
 
    });


    $(document).on('change', '#tglawal', function() {
      table.ajax.reload();      
    });

    $(document).on('change', '#tglakhir', function() {
      table.ajax.reload();      
    });

  }); //end (document).ready

  

</script>

</body>
</html>

