  <?php
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
  ?>
  <style>
    .namajemaatdc {
      font-size: 18px;
      font-weight: bold;
      display: block;
    }

    .table-spacenol {

      th,
      td {
        padding-top: 0px;
        padding-bottom: 10px;
        padding-left: 10px;
        padding-right: 10px;
      }
    }
  </style>

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
      <h4 class="text-dark mt-2">File DC</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item active">DCM</li>
      </ol>

    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">
      <div class="card" id="cardcontent">
        <div class="card-header" id="lbljudul">
          <h5 class="card-title">List File DC</h5>
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

            <?php  
              if ($rsResume->num_rows()>0) {
                foreach ($rsResume->result() as $row) {
                  echo '
                  <div class="col-md-3">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                            <h5><i class="fa fa-file-pdf text-danger mr-1"></i>'.$row->title.'</h5>                      
                          </div>
                          <div class="col-12">
                            <span class="text-muted text-sm" style="margin-top: -30px;">Dibuat: '.tgldatetime($row->tglpublish).'</span>
                          </div>
                          <div class="col-12 mt-3">
                          <a href="' . base_url('../admin/uploads/sharedfiles/resumedc/' . $row->fileshared) . '" class="btn btn-sm btn-primary" download="' . $row->fileshared .'"><i class="fa fa-download"></i> Download</a>
                          </div>
                          

                        </div>
                      </div>
                    </div>
                  </div>
                  ';
                }
              }
            ?>

            





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


    }); //end (document).ready
  </script>

  </body>

  </html>