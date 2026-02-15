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

    /* CSS untuk menampilkan rating bintang dengan Font Awesome */
    .rating-display {
      display: inline-flex;
      align-items: center;
      margin-right: 10px;
    }

    .rating-display .fa-star,
    .rating-display .fa-star-half-o,
    .rating-display .fa-star-o {
      color: #ffc107;
      font-size: 20px;
      margin-right: 2px;
    }

    .rating-summary {
      background-color: #f8f9fa;
      border-radius: 5px;
      padding: 10px;
      margin-top: 10px;
    }

    .avg-rating {
      font-size: 20px;
      font-weight: bold;
      color: #007bff;
      display: block;
      margin-top: 10px;
    }

    .rating-container {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      gap: 10px;
    }
    
    .rating-value {
      font-size: 16px;
      font-weight: 600;
      color: #495057;
      margin-left: 5px;
    }
    
    .rating-text {
      font-size: 14px;
      color: #6c757d;
    }

    .riwayat-progress {
      display: block;
      margin-top: 10px;
    }
  </style>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <div class="row" id="toni-breadcrumb">
    <div class="col-6">
      <h4 class="text-dark mt-2">DCM Progress</h4>
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
          <h5 class="card-title">List Member</h5>
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
            if ($rsDcmember->num_rows() > 0) {
              foreach ($rsDcmember->result() as $row) {
                if (!empty($row->foto)) {
                  $foto = base_url('../admin/uploads/jemaat/' . $row->foto);
                } else {
                  $foto = base_url('images/user-01.png');
                }

                // Ambil data rating dari database
                $ratings = $this->db->select('nilairatarata')
                                    ->from('dcmember_progress')
                                    ->where('dcmember_progress.iddcmember', $row->iddcmember)
                                    ->order_by('tglprogress', 'desc')
                                    ->limit(1)
                                    ->get()
                                    ->row();

                $avg_rating = !empty($ratings->nilairatarata) ? floatval($ratings->nilairatarata) : 0;
                
                // Hitung komponen rating untuk ditampilkan dalam bintang
                $full_stars = floor($avg_rating); // Jumlah bintang penuh
                $half_star = ($avg_rating - $full_stars) >= 0.5 ? 1 : 0; // Apakah ada bintang setengah?
                $empty_stars = 4 - $full_stars - $half_star; // Jumlah bintang kosong
                
                // Hitung persentase untuk tampilan alternatif
                $percentage = ($avg_rating / 4) * 100;

                echo '
                <div class="col-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12 mb-2">
                          <span class="namajemaatdc">' . $row->namalengkap . '</span>
                          <span class="">' . $row->statuskeanggotaan . '</span>
                        </div>
                        <div class="col-4">
                          <img src="' . $foto . '" alt="" style="width: 100%;">
                        </div>
                        <div class="col-8">
                          <div class="row">
                            <div class="col-12">
                              <div class="">' . $row->jeniskelamin . ' (' . $row->umur . ' Tahun)</div>
                            </div>
                            <div class="col-12">
                              <a href="' . site_url('dcmemberprogress/form/' . $this->encrypt->encode($row->iddcmember)) . '" class="btn btn-sm btn-success mt-2 mb-2">Tambah Progress Member</a>
                            </div>
                          </div>
                        </div>
                        <div class="col-12">';
                        
                // Tampilkan rating bintang dengan Font Awesome
                if($avg_rating > 0) {
                  echo '
                          <div class="rating-summary">
                            <div class="rating-container">                              
                              <div class="rating-display">';
                  
                  // Tampilkan bintang penuh
                  for($i = 1; $i <= $full_stars; $i++) {
                      echo '<i class="fa fa-star"></i>';
                  }
                  
                  // Tampilkan bintang setengah (jika ada)
                  if($half_star) {
                      echo '<i class="fa fa-star-half-o"></i>';
                  }
                  
                  // Tampilkan bintang kosong
                  for($i = 1; $i <= $empty_stars; $i++) {
                      echo '<i class="fa fa-star-o"></i>';
                  }
                  
                  echo '
                              </div>
                              <div class="rating-value">
                                ' . number_format($avg_rating, 1) . '
                              </div>
                              <div class="rating-text">
                                (Nilai : ' . number_format($percentage, 1) . '%)
                              </div>
                            </div>
                          </div>
                          <a href="' . site_url('dcmemberprogress/riwayat/' . $this->encrypt->encode($row->iddcmember)) . '" class="mt-3 mb-2 riwayat-progress"><i class="fa fa-history"></i> Lihat Riwayat Progress</a>';
                } else {
                  // Jika belum ada rating
                  echo '
                          <div class="rating-summary">
                            <div class="rating-container">
                              <div class="rating-display">';
                  
                  // Tampilkan semua bintang kosong
                  for($i = 1; $i <= 4; $i++) {
                      echo '<i class="fa fa-star-o" style="color: #ddd;"></i>';
                  }
                  
                  echo '
                              </div>
                              <div class="rating-text text-muted">
                                <i class="fa fa-info-circle"></i> Belum ada penilaian
                              </div>
                            </div>
                          </div>';
                }
                
                echo '
                        </div>
                      </div>
                    </div>
                  </div>
                </div>';
              }
            } else {
              echo '<div class="col-12"><div class="alert alert-warning">Tidak ada data member</div></div>';
            }
            ?>
          </div> <!-- /.row -->
        </div> <!-- ./card-body -->
      </div> <!-- /.card -->
    </div> <!-- /.col -->
  </div> <!-- /.row -->

  <?php $this->load->view("template/footer") ?>

  <script type="text/javascript">
    var table;

    $(document).ready(function() {
      // Inisialisasi tooltip jika diperlukan
      $('[data-toggle="tooltip"]').tooltip();
    }); //end (document).ready
  </script>

  </body>
  </html>