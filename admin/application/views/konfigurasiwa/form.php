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
                                <form action="<?php echo site_url('konfigurasiwa/simpanWaCare') ?>" method="post" id="formCare">
                                    <div class="row mt-5">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Text WA</label>
                                                <textarea name="textwa" id="textwa" class="form-control" placeholder="Text WA" rows="10"></textarea>
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
                                <form action="<?php echo site_url('konfigurasiwa/simpanWaNextStep') ?>" method="post" id="formNextStep">
                                    <div class="row mt-5">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="">Text WA Registrasi Kelas</label>                                                
                                                <textarea name="nextstepregistrasi" id="nextstepregistrasi" class="form-control" placeholder="Text WA" rows="10"><?php echo $this->Settings->getValues('wa_nextstep_registrasi') ?></textarea>
                                              </div>               
                                              <div class="form-group">
                                                <button class="btn btn-sm btn-default btn-add-field" data-idtextarea="nextstepregistrasi" data-field="namalengkap"><i class="fa fa-tag mr-1"></i>NamaJemaat</button>
                                                <button class="btn btn-sm btn-default btn-add-field" data-idtextarea="nextstepregistrasi" data-field="nohp"><i class="fa fa-tag mr-1"></i>No Telp</button>
                                                <button class="btn btn-sm btn-default btn-add-field" data-idtextarea="nextstepregistrasi" data-field="namadc"><i class="fa fa-tag mr-1"></i>Nama DC</button>                                            
                                            </div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="form-group">
                                                <label for="">Text WA Konfirmasi</label>
                                                <textarea name="nextstepkonfirmasi" id="nextstepkonfirmasi" class="form-control" placeholder="Text WA" rows="10"><?php echo $this->Settings->getValues('wa_nextstep_konfirmasi') ?></textarea>
                                            </div>             
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-default btn-add-field" data-idtextarea="nextstepkonfirmasi" data-field="namalengkap"><i class="fa fa-tag mr-1"></i>NamaJemaat</button>
                                                <button class="btn btn-sm btn-default btn-add-field" data-idtextarea="nextstepkonfirmasi" data-field="nohp"><i class="fa fa-tag mr-1"></i>No Telp</button>
                                                <button class="btn btn-sm btn-default btn-add-field" data-idtextarea="nextstepkonfirmasi" data-field="namadc"><i class="fa fa-tag mr-1"></i>Nama DC</button>                                            
                                            </div>  
                                        </div>
    
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
                                        </div>
                                    </div>
                                </form>
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
  

  $('#formNextStep').submit(function(e){
    e.preventDefault();
    
    var form = $(this);
    var mydata = new FormData(this);

    $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: mydata,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response){
            if(response.success){
                swal("Bershasil", "Data berhasil disimpan", "success");
            }else{
              swal("Informasi", "Data gagal disimpan", "info");
            }
        },
        error: function(){
            swal({
                icon: 'error',
                title: 'Oops...',
                text: 'Terjadi kesalahan saat penyimpanan data!',
            })
        }
    });
  })


  function insertAtCursor(textareaId, value) {
        var textarea = document.getElementById(textareaId);
        var startPos = textarea.selectionStart;
        var endPos = textarea.selectionEnd;
        var scrollTop = textarea.scrollTop;

        // Dapatkan teks sebelum dan sesudah kursor
        var before = textarea.value.substring(0, startPos);
        var after = textarea.value.substring(endPos, textarea.value.length);

        // Gabungkan dengan nilai baru
        textarea.value = before + value + after;

        // Atur fokus dan posisi kursor setelah teks yang disisipkan
        var newCursorPos = startPos + value.length;
        textarea.setSelectionRange(newCursorPos, newCursorPos);
        textarea.focus();
        textarea.scrollTop = scrollTop;
    }

    $('.btn-add-field').on('click', function(e) {
        e.preventDefault();
        var field = $(this).data('field');  
        var idtextarea = $(this).data('idtextarea');

        insertAtCursor(idtextarea, '[[' + field + ']]');
    });

  
  
</script>

</body>
</html>
