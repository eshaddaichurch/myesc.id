 <?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Konfigurasi Whatsapp</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('group')) ?>">Group</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">

                 
        <div class="row">
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="care-tab" data-toggle="tab" data-target="#care" type="button" role="tab" aria-controls="care" aria-selected="true">Care</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="nextstep-tab" data-toggle="tab" data-target="#nextstep" type="button" role="tab" aria-controls="nextstep" aria-selected="false">Next Step</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="registrasi-tab" data-toggle="tab" data-target="#registrasi" type="button" role="tab" aria-controls="registrasi" aria-selected="false">Registrasi</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="care" role="tabpanel" aria-labelledby="care-tab">
                                <form action="<?php echo site_url('konfigurasiwa/simpanWaCare') ?>" method="post">
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <div class="form-group required">
                                                <label for="">Text WA</label>
                                                <textarea name="textwacare" id="textwacare" class="form-control" placeholder="Text WA" rows="10"></textarea>
                                            </div>               
                                        </div>
    
                                        <div class="col-12">
    
                                            <button type="submit" class="btn btn-warning btn-sm">Test Whatsapp</button>
                                            <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="nextstep" role="tabpanel" aria-labelledby="nextstep-tab">
                                
                            </div>
                            <div class="tab-pane fade" id="registrasi" role="tabpanel" aria-labelledby="registrasi-tab">
                                
                            </div>
                        </div>

                               
                    </div>

                    

                </div>

                                       

              </div> <!-- ./card-body -->

            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>





    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer") ?>



<script type="text/javascript">
  
  
  $(document).ready(function() {

    $('.select2').select2();


    $("form").attr('autocomplete', 'off');
  }); 
  

</script>

</body>
</html>
