<?php
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
  ?>

 <style>
   .select2-locked .select2-selection {
     background-color: #e9ecef !important;
     cursor: not-allowed !important;
   }
   .select2-locked .select2-selection__arrow {
     display: none !important;
   }
 </style>


 <div class="row" id="toni-breadcrumb">
   <div class="col-6">
     <h4 class="text-dark mt-2">Volunteer</h4>
   </div>
   <div class="col-6">
     <ol class="breadcrumb float-sm-right">
       <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
       <li class="breadcrumb-item"><a href="<?php echo (site_url('volunteer')) ?>">Volunteer</a></li>
       <li class="breadcrumb-item active" id="lblactive"></li>
     </ol>

   </div>
 </div>

 <div class="row" id="toni-content">
   <div class="col-md-12">



     <form action="<?php echo (site_url('volunteer/simpan')) ?>" method="post" id="form">
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

               <h3 class="text-gray" id="lbljudul">Data Volunteer</h3>
               <hr>

               <input type="hidden" name="idvolunteer" id="idvolunteer">

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Nama Jemaat</label>
                 <div class="col-md-9">
                   <select name="idjemaat" id="idjemaat" class="form-control select2">
                     <option value="">Pilih nama jemaat...</option>
                     <?php
                      // $rsjemaat = $this->db->query("select * from jemaat order by namalengkap");
                      $rsjemaat = $this->db->query("select * from jemaat where (statusjemaat != 'Hapus' or statusjemaat is null) order by namalengkap");
                      if ($rsjemaat->num_rows() > 0) {
                        foreach ($rsjemaat->result() as $rowjemaat) {
                          echo '
                                <option value="' . $rowjemaat->idjemaat . '">' . $rowjemaat->namalengkap . '</option>
                              ';
                        }
                      }
                      ?>
                   </select>
                   <small class="text-muted" id="ketjemaatterkunci" style="display:none;">
                     <i class="fa fa-lock"></i> Nama terkunci karena kamu sedang menambahkan pelayanan baru untuk orang ini. Kalau salah orang, kembali ke list dan klik "+ Pelayanan" pada nama yang benar.
                   </small>
                 </div>
               </div>

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Departement</label>
                 <div class="col-md-9">
                   <select name="iddepartement" id="iddepartement" class="form-control select2">
                     <option value="">Pilih departement...</option>
                     <?php
                      $rsdepartement = $this->db->query("select * from departement where statusaktif='Aktif' order by namadepartement");
                      if ($rsdepartement->num_rows() > 0) {
                        foreach ($rsdepartement->result() as $rowdepartement) {
                          echo '
                                <option value="' . $rowdepartement->iddepartement . '">' . $rowdepartement->namadepartement . '</option>
                              ';
                        }
                      }
                      ?>
                   </select>
                 </div>
               </div>

               <div class="form-group row">
                 <label for="" class="col-md-3 col-form-label">Pelayanan</label>
                 <div class="col-md-9">
                   <select name="idpelayanan" id="idpelayanan" class="form-control select2">
                     <option value="">Pilih departemen dulu...</option>
                   </select>
                   <small class="text-muted">Daftar pelayanan menyesuaikan Departemen yang dipilih di atas.</small>
                 </div>
               </div>

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Kategori</label>
                 <div class="col-md-9">
                  <select name="kategori" id="kategori" class="form-control">
                     <option value="Major">Major</option>
                     <option value="Minor">Minor</option>
                  </select>
                   <small class="text-muted">Major = peran inti/utama orang ini pada pelayanan tersebut, Minor = pendukung.</small>
                 </div>
               </div>

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Tanggal Bergabung</label>
                 <div class="col-md-9">
                   <input type="date" name="tanggalbergabung" id="tanggalbergabung" class="form-control">
                 </div>
               </div>

               <div class="form-group row required">
                 <label for="" class="col-md-3 col-form-label">Status Aktif</label>
                 <div class="col-md-9">
                   <select name="statusaktif" id="statusaktif" class="form-control">
                     <option value="Aktif">Aktif</option>
                     <option value="Tidak Aktif">Tidak Aktif</option>
                   </select>
                 </div>
               </div>

               <div class="form-group row">
                 <label for="" class="col-md-3 col-form-label">Keterangan</label>
                 <div class="col-md-9">
                   <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                 </div>
               </div>

             </div> <!-- ./card-body -->

             <div class="card-footer">
               <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
               <a href="<?php echo (site_url('volunteer')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
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
   var idvolunteer = "<?php echo ($idvolunteer) ?>";
   var prefill_idjemaat = "<?php echo (isset($prefill_idjemaat) ? $prefill_idjemaat : '') ?>";

   $(document).ready(function() {

     $('.select2').select2();

     // -------------------------> Fungsi load daftar pelayanan berdasarkan departemen yang dipilih
     function loadPelayanan(iddepartement, selectedValue, callback) {
       $("#idpelayanan").html('<option value="">Memuat...</option>');
       if (!iddepartement) {
         $("#idpelayanan").html('<option value="">Pilih departemen dulu...</option>').trigger('change.select2');
         if (callback) callback();
         return;
       }
       $.ajax({
           type: 'GET',
           url: '<?php echo site_url("pelayanan/get_by_departement") ?>',
           data: { iddepartement: iddepartement },
           dataType: 'json'
         })
         .done(function(result) {
           var options = '<option value="">Belum ditentukan (opsional)</option>';
           for (var i = 0; i < result.length; i++) {
             options += '<option value="' + result[i]['idpelayanan'] + '">' + result[i]['namapelayanan'] + '</option>';
           }
           $("#idpelayanan").html(options);
           if (selectedValue) {
             $("#idpelayanan").val(selectedValue);
           }
           $("#idpelayanan").trigger('change.select2');
           if (callback) callback();
         });
     }

     // -------------------------> Setiap Departemen diganti, reload Pelayanan (kosongkan pilihan lama)
     $(document).on('change', '#iddepartement', function() {
       loadPelayanan($(this).val(), null);
     });

     //---------------------------------------------------------> JIKA EDIT DATA
     if (idvolunteer != "") {
       $.ajax({
           type: 'POST',
           url: '<?php echo site_url("volunteer/get_edit_data") ?>',
           data: {
             idvolunteer: idvolunteer
           },
           dataType: 'json',
           encode: true
         })
         .done(function(result) {
           $("#idvolunteer").val(result.idvolunteer);
           $("#idjemaat").val(result.idjemaat).trigger('change');
           $("#iddepartement").val(result.iddepartement).trigger('change.select2');
           $("#kategori").val(result.kategori);
           $("#statusaktif").val(result.statusaktif);
           $("#tanggalbergabung").val(result.tanggalbergabung);
           $("#keterangan").val(result.keterangan);

           // -------------------------> Muat dulu daftar pelayanan sesuai departemen-nya, baru set pilihan yang tersimpan
           loadPelayanan(result.iddepartement, result.idpelayanan);
         });

       $("#lbljudul").html("Edit Data Volunteer");
       $("#lblactive").html("Edit");

     } else {
       $("#lbljudul").html("Tambah Data Volunteer");
       $("#lblactive").html("Tambah");

       // -------------------------> Kalau datang dari tombol "+ Pelayanan" di list, auto-pilih jemaatnya DAN kunci dropdown-nya
       if (prefill_idjemaat != "") {
         $("#idjemaat").val(prefill_idjemaat).trigger('change');

         // Kunci interaksi select2 (bukan pakai atribut disabled, supaya value tetap ikut ter-submit)
         $("#idjemaat").next('.select2-container').addClass('select2-locked');
         $("#idjemaat").on('select2:opening', function(e) {
           e.preventDefault();
         });
         $("#ketjemaatterkunci").show();
       }
     }

     //----------------------------------------------------------------- > validasi
     $("#form").bootstrapValidator({
       feedbackIcons: {
         valid: 'glyphicon glyphicon-ok',
         invalid: 'glyphicon glyphicon-remove',
         validating: 'glyphicon glyphicon-refresh'
       },
       fields: {
         idjemaat: {
           validators: {
             notEmpty: {
               message: "nama jemaat tidak boleh kosong"
             },
           }
         },
         iddepartement: {
           validators: {
             notEmpty: {
               message: "departement tidak boleh kosong"
             },
           }
         },
         kategori: {
           validators: {
             notEmpty: {
               message: "kategori tidak boleh kosong"
             },
           }
         },
         tanggalbergabung: {
           validators: {
             notEmpty: {
               message: "tanggal bergabung tidak boleh kosong"
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