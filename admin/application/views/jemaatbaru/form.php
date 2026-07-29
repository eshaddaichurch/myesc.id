<?php
$this->load->view('template/header');
$this->load->view('template/topmenu');
$this->load->view('template/sidemenu');
?>


 <div class="row" id="toni-breadcrumb">
     <div class="col-6">
         <h4 class="text-dark mt-2">Jemaat Baru</h4>
     </div>
     <div class="col-6">
         <ol class="breadcrumb float-sm-right">
             <li class="breadcrumb-item"><a href="<?php echo (site_url()) ?>">Home</a></li>
             <li class="breadcrumb-item"><a href="<?php echo (site_url('jemaatbaru')) ?>">Jemaat Baru</a></li>
             <li class="breadcrumb-item active" id="lblactive">Detail</li>
         </ol>

     </div>
 </div>

 <div class="row" id="toni-content">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card" id="cardcontent">
                            <div class="card-body">

                                <div class="col-md-12">
                                    <?php
                                    $pesan = $this->session->flashdata('pesan');
                                    if (!empty($pesan)) {
                                        echo $pesan;
                                    }
                                    ?>
                         </div>

                         <h3 class="text-gray">Data Jemaat</h3>
                         <hr>

                         <!--
                            CATATAN: idcarejemaatbaru dipertahankan sebagai data-attribute
                            (bukan hidden input form) karena halaman ini sekarang murni
                            read-only, tidak ada submit/simpan lagi.
                         -->
                         <div class="form-group row">
                             <div class="col-12">
                                 <div class="table-responsive">
                                     <table class="table">
                                         <tbody>
                                             <tr>
                                                 <td style="width: 20%;">Nama</td>
                                                 <td style="width: 5%;">:</td>
                                                 <td style="width: 75%;"><?php echo $rowJemaatBaru->namajemaat; ?></td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 20%;">Jenis Kelamin</td>
                                                 <td style="width: 5%;">:</td>
                                                 <td style="width: 75%;"><?php echo $rowJemaatBaru->jeniskelamin; ?></td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 20%;">Tanggal Daftar</td>
                                                 <td style="width: 5%;">:</td>
                                                 <td style="width: 75%;"><?php echo formatHariTanggal($rowJemaatBaru->tglinsert); ?></td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 20%;">Email</td>
                                                 <td style="width: 5%;">:</td>
                                                 <td style="width: 75%;"><?php echo $rowJemaatBaru->email; ?></td>
                                             </tr>
                                             <tr>
                                                 <td style="width: 20%;">No HP</td>
                                                 <td style="width: 5%;">:</td>
                                                 <td style="width: 75%;"><?php echo $rowJemaatBaru->nohp; ?></td>
                                             </tr>
                                             <!-- <tr>
                                                 <td style="width: 20%;">Status</td>
                                                 <td style="width: 5%;">:</td>
                                                 <td style="width: 75%;"><?php echo $rowJemaatBaru->status; ?></td>
                                             </tr> -->
                                         </tbody>

                                     </table>
                                 </div>
                             </div>

                             <?php if (!empty($rowJemaatBaru->keterangan)) { ?>
                             <div class="col-12 mt-3">
                                 <div class="form-group">
                                     <label>Keterangan</label>
                                     <div class="form-control" style="height:auto; min-height: 80px; background-color:#f8f9fa;">
                                         <?php echo nl2br(htmlspecialchars($rowJemaatBaru->keterangan)); ?>
                                     </div>
                                 </div>
                             </div>
                             <?php } ?>
                         </div>

                     </div> <!-- ./card-body -->

                     <div class="card-footer">
                         <a href="<?php echo (site_url('jemaatbaru')) ?>" class="btn btn-default float-right"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
                     </div>
                 </div> <!-- /.card -->
             </div> <!-- /.col -->
         </div>

     </div>
 </div> <!-- /.row -->
 <!-- Main row -->



 <?php $this->load->view('template/footer') ?>



 <script type="text/javascript">
     $(document).ready(function() {
         $('.select2').select2();
     }); //end (document).ready
 </script>

 </body>

 </html>