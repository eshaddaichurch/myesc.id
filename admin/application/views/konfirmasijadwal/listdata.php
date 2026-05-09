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
        <h4 class="text-dark mt-2">Konfirmasi Jawal Event</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active">Konfirmasi Jawal Event</li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <div class="card" id="cardcontent">
        <div class="card-header">
          <h5 class="card-title">List Data Konfirmasi Jawal Event</h5>
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

            <div class="col-12">
              
              <!-- filter berdasarkan tanggal -->
              


               <div class="row">
                <div class="col-md-6">
                  <div class="row">
                    <div class="col-12">
                      <label for="">Filter Tanggal</label>
                    </div>
                    <div class="col-12">
                      <div class="form-group row">                
                        <div class="col-md-5">
                          <input type="date" name="tglawal" id="tglawal" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <label for="" class="col-md-2 text-center col-form-label">s/d</label>
                        <div class="col-md-5">
                          <input type="date" name="tglakhir" id="tglakhir" class="form-control" value="<?php echo date('Y-m-d', strtotime('+7 day')); ?>">
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Filter Departemen</label>
                    <select name="departement" id="departement" class="form-control select2">
                      <option value="">Semua Departement</option>
                      <?php foreach ($departement->result() as $value): ?>
                        <option value="<?php echo $value->iddepartement ?>"><?php echo $value->namadepartement ?></option>
                      <?php endforeach ?>
                    </select>                    
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="">Filter Jenis Event</label>
                    <select name="jenisjadwal" id="jenisjadwal" class="form-control select2">
                      <option value="">Semua Jenis Event</option>
                      <option value="Disciple Community">Disciple Community</option>
                      <option value="Doa Bersama">Doa Bersama</option>
                      <option value="Ibadah Jemaat">Ibadah Jemaat</option>
                      <option value="Latihan Acara/Musik">Latihan Acara/Musik</option>
                      <option value="Meeting">Meeting</option>
                      <option value="Pelayanan Jemaat">Pelayanan Jemaat</option>
                      <option value="Team Night/Fellowship">Team Night/Fellowship</option>
                      <option value="Filming">Filming</option>
                      <option value="Kelas Next Step">Kelas Next Step</option>  
                    </select>                    
                  </div>  
                </div>

               </div>

              

            </div>
            <div class="col-md-12 mt-3">
              <!-- datatable -->
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-condesed" id="table">
                  <thead>
                    <tr class="bg-primary" style="">
                      <th style="width: 5%; text-align: center;">No</th>
                      <th style="text-align: center;">Tanggal Event</th>
                      <th style="text-align: center;">Nama Event<br>Departemen</th>
                      <th style="text-align: center;">Jenis Event</th>
                      <th style="text-align: center;">Tampil<br>di Myesc.id</th>
                      <th style="text-align: center;">Status Konfirmasi</th>
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

<script type="text/javascript">

  var table;

  $(document).ready(function() {
    $('.select2').select2();

    //defenisi datatable
    table = $("#table").DataTable({ 
        "select": true,
        "processing": true, 
        "serverSide": true, 
        "order": [], 
         "ajax": {
            "url": "<?php echo site_url('konfirmasijadwal/datatablesource')?>",
            "type": "POST",
            "data": function ( d ) {
                  d.tglawal = $('#tglawal').val(); 
                  d.tglakhir = $('#tglakhir').val();
                  d.departement = $('#departement').val();
                  d.jenisjadwal = $('#jenisjadwal').val();
              }
        },
        "columnDefs": [
                        { "targets": [ 0 ], "orderable": false, "className": "dt-body-center" },
                        { "targets": [ 1 ], "className": "dt-body-center" },
                        { "targets": [ 2 ], "className": "dt-body-left" },
                        { "targets": [ 3 ], "className": "dt-body-center" },
                        { "targets": [ 4 ], "className": "dt-body-center" },
                        { "targets": [ 5 ], "className": "dt-body-center" },
                        { "targets": [ 6 ], "orderable": false, "className": "dt-body-center" },
        ],
 
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

  $(document).on('change', '#tglawal, #tglakhir, #departement, #jenisjadwal', function() {
    table.ajax.reload(); // Reload tabel dengan filter baru
  });
  

</script>

</body>
</html>

