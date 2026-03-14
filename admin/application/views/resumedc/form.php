<?php
$this->load->view("template/header");
$this->load->view("template/topmenu");
$this->load->view("template/sidemenu");
?>

<div class="row" id="toni-breadcrumb">
  <div class="col-6">
    <h4 class="text-dark mt-2">Resume DC</h4>
  </div>
  <div class="col-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
      <li class="breadcrumb-item"><a href="<?php echo (site_url('resumedc')) ?>">Resume DC</a></li>
      <li class="breadcrumb-item active" id="lblactive"></li>
    </ol>

  </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-12">



    <form action="<?php echo (site_url('resumedc/simpan')) ?>" method="post" id="form" enctype="multipart/form-data">

      <input type="hidden" name="idshared" id="idshared" value="<?php echo $idshared; ?>">

      <div class="row">
        <div class="col-md-12">
          <div class="card" id="cardcontent">
            <div class="card-header">
              <h5 class=" card-title" id="lbljudul"></h5>
              <span class="text-lg float-right">ID: #<span id="lblID">None</span></span>
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
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Title</label>
                    <div class="col-md-9">
                      <input type="text" name="title" id="title" class="form-control" placeholder="Title/ Judul File">
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">Status</label>
                    <div class="col-md-9">
                      <select name="status" id="status" class="form-control select2">
                        <option value="Draft">Draft</option>
                        <option value="Publish">Publish</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group row">
                    <label for="" class="col-md-3 col-form-label">Deskripsi Singkat</label>
                    <div class="col-md-9">
                      <textarea name="deskripsisingkat" id="deskripsisingkat" class="form-control" placeholder="Deskripsi"></textarea>
                    </div>
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-group row required">
                    <label for="" class="col-md-3 col-form-label">File Resume</label>
                    <div class="col-md-9 row">
                      <div class="col-12">
                        <input type="file" name="fileshared" id="fileshared" title="Pilih File" accept=".pdf">
                        <input type="hidden" name="fileshared_lama" id="fileshared_lama">
                      </div>
                      <div class="col-12 mt-2">
                        <a href="" id="fileshared_link" target="_blank"></a>
                      </div>
                    </div>
                  </div>
                </div>

              

                
              </div>

            </div> <!-- ./card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
              <a href="<?php echo (site_url('resumedc')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
  var idshared = "<?php echo $idshared ?>";


  $(document).ready(function() {

    $('.select2').select2();

    //---------------------------------------------------------> JIKA EDIT DATA
    if (idshared != "") {
      $.ajax({
          type: 'POST',
          url: '<?php echo site_url("resumedc/get_edit_data") ?>',
          data: {
            idshared: idshared
          },
          dataType: 'json',
          encode: true
        })
        .done(function(result) {
          console.log(result);

          $("#lblID").html(result.idshared);
          $("#idshared").val(result.idshared);
          $("#title").val(result.title);
          $("#status").val(result.status).trigger('change');
          $("#deskripsisingkat").val(result.deskripsisingkat);
          $("#fileshared_lama").val(result.fileshared);

          $('#fileshared_link').html(result.fileshared);
          $('#fileshared_link').prop('href', '<?= base_url("uploads/sharedfiles/resumedc/") ?>' + result.fileshared);

        });


      $("#lbljudul").html("Edit Data Disciples Community");
      $("#lblactive").html("Edit");

    } else {
      $("#lbljudul").html("Tambah Data Disciples Community");
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
        title: {
          validators: {
            notEmpty: {
              message: "title/judul tidak boleh kosong"
            },
          }
        },
      }
    });
    //------------------------------------------------------------------------> END VALIDASI DAN SIMPAN


    $("form").attr('autocomplete', 'off');
    
  }); //end (document).ready


</script>

</body>

</html>