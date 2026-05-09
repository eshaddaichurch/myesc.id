 <?php  
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>


<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Pengaturan Aplikasi</h4>
    </div>  
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('pengaturan')) ?>">Pengaturan Aplikasi</a></li>
        <li class="breadcrumb-item active" id="lblactive"></li>
      </ol>
      
    </div>
  </div>

  <div class="row" id="toni-content">
    <div class="col-md-12">



      <form action="<?php echo(site_url('pengaturan/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">                      
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="cardcontent">
              <div class="card-body">

                  <div class="col-md-12">
                    <?php 
                      $pesan = $this->session->flashdata("pesan");
                      if (!empty($pesan)) {
                        echo $pesan;
                      }
                    ?>
                  </div> 

                  <h3 class="text-gray">Data Pengaturan</h3><hr>                    

                  <input type="hidden" name="ltambah" id="ltambah" value = "<?php echo $ltambah ?>">

                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Prefix</label>
                    <div class="col-md-9">
                      <input type="text" name="prefix" id="prefix" class="form-control" placeholder="Prefix" autofocus="">
                    </div>
                  </div>         
                  
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Value</label>
                    <div class="col-md-9">
                      <textarea name="values" id="values" class="form-control" placeholder="Value" rows="4"></textarea>
                    </div>
                  </div>   
                  
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Deskripsi</label>
                    <div class="col-md-9">
                      <textarea name="deskripsi" id="deskripsi" class="form-control" placeholder="Deskripsi" rows="2"></textarea>
                    </div>
                  </div>   
                  
                  

                                       

              </div> <!-- ./card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?php echo(site_url('pengaturan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
              </div>
            </div> <!-- /.card -->
          </div> <!-- /.col -->
        </div>
      </form>





    </div>
  </div> <!-- /.row -->
  <!-- Main row -->



<?php $this->load->view("template/footer") ?>



<script type="text/javascript">
  
  var prefix = "<?php echo($prefix) ?>";

  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if ( prefix != "" ) { 
          $.ajax({
              type        : 'POST', 
              url         : '<?php echo site_url("pengaturan/get_edit_data") ?>', 
              data        : {prefix: prefix}, 
              dataType    : 'json', 
              encode      : true
          })      
          .done(function(result) {
            // console.log(result);
            $("#prefix").val(result.prefix);
            $("#prefix").attr("readonly", true);
            $("#values").val(result.values);
            $("#deskripsi").val(result.deskripsi);            
            $("#values").focus();
          }); 


          $("#lbljudul").html("Edit Data Group");
          $("#lblactive").html("Edit");

    }else{
          $("#lbljudul").html("Tambah Data Group");
          $("#lblactive").html("Tambah");
    }     

    //----------------------------------------------------------------- > validasi
    $("#form").bootstrapValidator({
      feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
      },
      fields: {
        prefix: {
          validators: {
            notEmpty: {
              message: "prefix tidak boleh kosong"
            },
            stringLength: {
              max: 50,
              message: "prefix maksimal 50 karakter"
            },
            regexp: {
              regexp: /^[a-z0-9\-_]+$/,
              message: "prefix hanya boleh berisi huruf kecil (a-z), angka (0-9), dan simbol (- atau _)"
            }
          }
        },
        values: {
          validators:{
            notEmpty: {
                message: "value tidak boleh kosong"
            },
          }
        },
        deskripsi: {
          validators:{
            notEmpty: {
                message: "deskripsi tidak boleh kosong"
            },
          }
        },
      }
    });
  //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    $("#rtrw").mask("000/000", {placeholder:"000/000"});
  }); //end (document).ready
  

</script>

</body>
</html>
