<?php
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>

<style type="text/css">
  /* CSS untuk Star Rating - DIPERBAIKI */
  .rate {
    display: inline-flex;
    margin: 10px 0;
    direction: rtl; /* RTL untuk reverse urutan tanpa row-reverse */
    text-align: left;
  }

  .rate input[type="radio"] {
    display: none;
  }

  .rate label {
    cursor: pointer;
    width: 35px;
    height: 35px;
    margin: 0 3px;
    font-size: 35px;
    color: #ccc;
    transition: all 0.3s ease;
  }

  /* Bintang default */
  .rate label::before {
    content: "★";
    display: block;
  }

  /* Hover effect - bintang yang di-hover dan di kanannya (lebih tinggi) */
  .rate label:hover,
  .rate label:hover ~ label {
    color: #ffc107;
    transform: scale(1.15);
  }

  /* Checked effect - bintang yang dipilih dan di kanannya */
  .rate input[type="radio"]:checked ~ label {
    color: #ffc107;
    transform: scale(1.15);
  }

  /* Small text instruksi */
  .rate + small {
    display: block;
    margin-top: 5px;
    margin-left: 5px;
    color: #666;
    font-size: 0.85rem;
  }

  /* Garis separator */
  .separator {
    display: block;
    margin: 15px 0;
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0));
  }

  /* Kategori heading */
  .kategori-heading {
    background-color: #f8f9fa;
    padding: 10px 15px;
    border-left: 4px solid #007bff;
    margin: 20px 0 15px 0;
    border-radius: 4px;
  }


  /* Tambahkan CSS untuk menampilkan error */
.has-error {
  border-left: 3px solid #dc3545;
  padding-left: 10px;
  background-color: #fff8f8;
  border-radius: 4px;
  transition: all 0.3s ease;
  box-shadow: 0 0 5px rgba(220, 53, 69, 0.2);
}

.rating-error {
  color: #dc3545;
  font-size: 0.85rem;
  margin-top: 5px;
  padding-left: 5px;
  font-weight: 500;
  animation: fadeIn 0.3s ease;
}

.has-success {
  border-left: 3px solid #28a745;
  padding-left: 10px;
  background-color: #f8fff8;
  border-radius: 4px;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Style untuk label saat error */
.has-error .font-weight-bold {
  color: #dc3545;
}

/* Tambahan untuk feedback visual */
.rate label {
  transition: all 0.2s ease;
}

.has-error .rate label {
  color: #ff6b6b;
}

</style>

<div class="row" id="toni-breadcrumb">
    <div class="col-6">
        <h4 class="text-dark mt-2">Progress DCM</h4>
    </div>
    <div class="col-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="<?php echo(site_url()) ?>">Home</a></li>
        <li class="breadcrumb-item"><a href="<?php echo(site_url('dcmemberprogress')) ?>">Progress DCM</a></li>
        <li class="breadcrumb-item active">Tambah</li>
      </ol>
    </div>
</div>

<div class="row" id="toni-content">
  <div class="col-md-12">
    <form action="<?php echo(site_url('dcmemberprogress/simpan')) ?>" method="post" id="form">                      
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

              <h3 class="text-gray"><?php echo $rowDCM->namalengkap ?></h3><span>Progress DC Member</span><hr>                    
              <input type="hidden" name="iddcmember" id="iddcmember" value="<?php echo $iddcmember ?>">                      

              <div class="row">

                <?php  
                  $idkategori_old = '';
                  $nomor = 1;
                  $validasi_fields = array();

                  if ($rsPertanyaan->num_rows() > 0) {
                    foreach ($rsPertanyaan->result() as $row) {

                      // Tampilkan kategori jika berubah
                      if ($idkategori_old != $row->idkategori) {
                        if ($nomor > 1) {
                          echo '<div class="col-12"><div class="separator"></div></div>';
                        }
                        echo '
                          <div class="col-12">
                            <h5 class="kategori-heading">' . $row->namakategori . '</h5>
                          </div>
                        ';
                      }

                      // Generate field name untuk validasi
                      $field_name = 'rate_' . $row->idpertanyaan;
                      $validasi_fields[] = $field_name;

                      echo '
                        <div class="col-12 mb-3">
                          <label for="" class="font-weight-bold">' . $nomor++ . '. ' . $row->pertanyaan . '</label>
                          <!-- Rating bintang visual -->
                          <div class="rate">
                            <input type="radio" id="star4_'.$row->idpertanyaan.'" name="rate_'.$row->idpertanyaan.'" value="4" />
                            <label for="star4_'.$row->idpertanyaan.'" title="Sangat Baik (4)"></label>
                            
                            <input type="radio" id="star3_'.$row->idpertanyaan.'" name="rate_'.$row->idpertanyaan.'" value="3" />
                            <label for="star3_'.$row->idpertanyaan.'" title="Baik (3)"></label>
                            
                            <input type="radio" id="star2_'.$row->idpertanyaan.'" name="rate_'.$row->idpertanyaan.'" value="2" />
                            <label for="star2_'.$row->idpertanyaan.'" title="Cukup (2)"></label>
                            
                            <input type="radio" id="star1_'.$row->idpertanyaan.'" name="rate_'.$row->idpertanyaan.'" value="1" />
                            <label for="star1_'.$row->idpertanyaan.'" title="Kurang (1)"></label>
                          </div>
                          <small class="text-muted">Klik bintang untuk memberikan rating (1-4)</small>
                        </div>
                      ';

                      $idkategori_old = $row->idkategori;
                    }
                  } else {
                    echo '<div class="col-12"><div class="alert alert-warning">Tidak ada pertanyaan tersedia</div></div>';
                  }
                ?>
                
              </div>
              
            </div> <!-- ./card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary float-right"><i class="fa fa-save"></i> Simpan</button>
              <a href="<?php echo(site_url('dcmemberprogress')) ?>" class="btn btn-default float-right mr-1 ml-1"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
            </div>
          </div> <!-- /.card -->
        </div> <!-- /.col -->
      </div>
    </form>
  </div>
</div> <!-- /.row -->

<?php $this->load->view("template/footer") ?>


<script type="text/javascript">
  var iddcmember = "<?php echo $iddcmember ?>";
  
  $(document).ready(function() {
    $('.select2').select2();

    // Validasi manual saat submit
    $('#form').on('submit', function(e) {
      // e.preventDefault(); // HAPUS ini, jangan di-prevent default
      console.log("Validasi dimulai");
      
      var isValid = true;
      var firstError = null;
      
      <?php foreach ($validasi_fields as $field): ?>
      var ratingValue = $('input[name="<?php echo $field ?>"]:checked').val();
      
      if (!ratingValue) {
          isValid = false;
          
          // Highlight field yang error
          var $fieldGroup = $('input[name="<?php echo $field ?>"]').first().closest('.col-12.mb-3');
          $fieldGroup.addClass('has-error');
          
          // Tambah pesan error
          if ($fieldGroup.find('.rating-error').length === 0) {
              $fieldGroup.append('<div class="rating-error text-danger mt-1">Rating harus dipilih</div>');
          }
          
          // Catat error pertama untuk scroll
          if (!firstError) {
              firstError = $fieldGroup;
          }
          
          console.log('Field <?php echo $field ?> belum diisi');
      } else {
          // Remove error jika sudah diisi
          var $fieldGroup = $('input[name="<?php echo $field ?>"]').first().closest('.col-12.mb-3');
          $fieldGroup.removeClass('has-error');
          $fieldGroup.find('.rating-error').remove();
      }
      <?php endforeach; ?>
      
      // Jika tidak valid, cegah submit dan scroll ke error
      if (!isValid) {
          e.preventDefault(); // Cegah submit
          console.log("Validasi gagal");
          
          // Scroll ke error pertama dengan animasi
          if (firstError) {
              $('html, body').animate({
                  scrollTop: firstError.offset().top - 100
              }, 500);
          }
          
          return false; // Pastikan submit dibatalkan
      }
      
      // Jika valid, biarkan form submit
      console.log("Validasi sukses, form akan disubmit");
      return true; // Form akan dilanjutkan submit
    });

    // Hapus pesan error saat radio dipilih (real-time validation)
    $('input[type=radio]').on('change', function() {
        var $fieldGroup = $(this).closest('.col-12.mb-3');
        $fieldGroup.removeClass('has-error');
        $fieldGroup.find('.rating-error').remove();
    });

    $("form").attr('autocomplete', 'off');
  }); 
</script>


</body>
</html>