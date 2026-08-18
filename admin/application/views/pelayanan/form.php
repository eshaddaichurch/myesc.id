<?php
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
  ?>


 <div class="row" id="toni-breadcrumb">
   <div class="col-6">
     <h4 class="text-dark mt-2">Pelayanan</h4>
   </div>
   <div class="col-6">
     <ol class="breadcrumb float-sm-right">
       <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
       <li class="breadcrumb-item"><a href="<?php echo (site_url('pelayanan')) ?>">Pelayanan</a></li>
       <li class="breadcrumb-item active" id="lblactive"></li>
     </ol>

   </div>
 </div>

 <div class="row" id="toni-content">
   <div class="col-md-12">



     <form action="<?php echo (site_url('pelayanan/simpan')) ?>" method="post" id="form">
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

               <h3 class="text-gray" id="lbljudul">Data Pelayanan</h3>
               <hr>

               <input type="hidden" name="idpelayanan" id="idpelayanan">

               <?php if ($idpelayanan != '') { ?>
               <div class="form-group row">
                 <label for="" class="col-md-3 col-form-label">Kode</label>
                 <div class="col-md-9">
                   <input type="text" id="tampilkodepelayanan" class="form-control" readonly>
                   <small class="text-muted">Kode dibuat otomatis, tidak bisa diubah.</small>
                 </div>
               </div>
               <?php } ?>

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Departemen</label>
                 <div class="col-md-9">
                   <select name="iddepartement" id="iddepartement" class="form-control select2">
                     <option value="">Pilih departemen...</option>
                     <?php
                      $rsgroup = $this->db->query("select * from `group` order by namagroup");
                      if ($rsgroup->num_rows() > 0) {
                        foreach ($rsgroup->result() as $rowgroup) {
                          $rsdept = $this->db->query("select * from departement where idgroup='".$rowgroup->idgroup."' and statusaktif='Aktif' order by namadepartement");
                          if ($rsdept->num_rows() > 0) {
                            echo '<optgroup label="'.$rowgroup->namagroup.'">';
                            foreach ($rsdept->result() as $rowdept) {
                              echo '<option value="'.$rowdept->iddepartement.'">'.$rowdept->namadepartement.'</option>';
                            }
                            echo '</optgroup>';
                          }
                        }
                      }
                      ?>
                   </select>
                 </div>
               </div>

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Nama Pelayanan</label>
                 <div class="col-md-9">
                   <input type="text" name="namapelayanan" id="namapelayanan" class="form-control" placeholder="Contoh: Sound (Live), Photographer, dsb">
                 </div>
               </div>

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Status Aktif</label>
                 <div class="col-md-9">
                   <select name="statusaktif" id="statusaktif" class="form-control">
                     <option value="Aktif">Aktif</option>
                     <option value="Tidak Aktif">Tidak Aktif</option>
                   </select>
                   <small class="text-muted">Kalau pelayanan ini sudah tidak dipakai lagi, pilih "Tidak Aktif" saja daripada dihapus (supaya riwayat volunteer lama tetap tersimpan).</small>
                 </div>
               </div>

             </div> <!-- ./card-body -->

             <div class="card-footer">
               <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
               <a href="<?php echo (site_url('pelayanan')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
   var idpelayanan = "<?php echo ($idpelayanan) ?>";

   $(document).ready(function() {

     $('.select2').select2();

     //---------------------------------------------------------> JIKA EDIT DATA
     if (idpelayanan != "") {
       $.ajax({
           type: 'POST',
           url: '<?php echo site_url("pelayanan/get_edit_data") ?>',
           data: {
             idpelayanan: idpelayanan
           },
           dataType: 'json',
           encode: true
         })
         .done(function(result) {
           $("#idpelayanan").val(result.idpelayanan);
           $("#tampilkodepelayanan").val(result.idpelayanan);
           $("#iddepartement").val(result.iddepartement).trigger('change');
           $("#namapelayanan").val(result.namapelayanan);
           $("#statusaktif").val(result.statusaktif);
         });

       $("#lbljudul").html("Edit Data Pelayanan");
       $("#lblactive").html("Edit");

     } else {
       $("#lbljudul").html("Tambah Data Pelayanan");
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
         iddepartement: {
           validators: {
             notEmpty: {
               message: "departemen tidak boleh kosong"
             },
           }
         },
         namapelayanan: {
           validators: {
             notEmpty: {
               message: "nama pelayanan tidak boleh kosong"
             },
           }
         },
         statusaktif: {
           validators: {
             notEmpty: {
               message: "status aktif tidak boleh kosong"
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
