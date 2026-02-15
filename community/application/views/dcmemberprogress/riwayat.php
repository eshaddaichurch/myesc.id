<?php
  $this->load->view("template/header");
  $this->load->view("template/topmenu");
  $this->load->view("template/sidemenu");
?>

<!-- Tambahkan Font Awesome jika belum ada -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
  /* CSS untuk tampilan riwayat rating */
  .timeline {
    position: relative;
    padding: 20px 0;
    list-style: none;
  }

  .timeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 50px;
    width: 2px;
    background: #e9ecef;
    margin-left: -1.5px;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 30px;
  }

  .timeline-badge {
    position: absolute;
    left: 15px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    text-align: center;
    line-height: 50px;
    font-size: 20px;
    color: #fff;
    background: #007bff;
    z-index: 1;
  }

  .timeline-panel {
    position: relative;
    margin-left: 80px;
    padding: 20px;
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }

  .timeline-panel:before {
    content: '';
    position: absolute;
    left: -10px;
    top: 20px;
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-right: 10px solid #fff;
  }

  .rating-display {
    display: inline-flex;
    align-items: center;
    margin: 5px 0;
  }

  .rating-display .fa-star,
  .rating-display .fa-star-half-o,
  .rating-display .fa-star-o {
    color: #ffc107;
    font-size: 18px;
    margin-right: 2px;
  }

  .rating-value {
    font-weight: bold;
    color: #007bff;
    margin-left: 10px;
  }

  .rating-date {
    color: #6c757d;
    font-size: 14px;
    margin-bottom: 10px;
  }

  .rating-detail {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px dashed #e9ecef;
  }

  .detail-item {
    margin-bottom: 10px;
  }

  .detail-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
    font-size: 14px;
  }

  .detail-stars {
    display: inline-flex;
    align-items: center;
    margin-left: 10px;
  }

  .detail-stars .fa-star,
  .detail-stars .fa-star-half-o,
  .detail-stars .fa-star-o {
    font-size: 14px;
    color: #ffc107;
  }

  .detail-value {
    font-weight: 600;
    color: #28a745;
    margin-left: 10px;
    font-size: 13px;
  }

  .badge-rating {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    color: #fff;
    margin-left: 10px;
  }

  .badge-sangat-baik { background: #28a745; }
  .badge-baik { background: #17a2b8; }
  .badge-cukup { background: #ffc107; color: #212529; }
  .badge-kurang { background: #dc3545; }

  .empty-state {
    text-align: center;
    padding: 50px 20px;
    background: #f8f9fa;
    border-radius: 5px;
  }

  .empty-state i {
    font-size: 48px;
    color: #adb5bd;
    margin-bottom: 15px;
  }

  .empty-state h5 {
    color: #6c757d;
    margin-bottom: 10px;
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
        <li class="breadcrumb-item active">Riwayat</li>
      </ol>
    </div>
</div>

<div class="row" id="toni-content">
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

        <h3 class="text-gray"><?php echo $rowDCM->namalengkap ?></h3>
        <span class="text-muted">Riwayat Nilai DC Member</span>
        <hr>                    
        <input type="hidden" name="iddcmember" id="iddcmember" value="<?php echo $iddcmember ?>">                      

        <div class="row">
          <div class="col-md-12">
            <?php  
            if ($rsRiwayat->num_rows() > 0) {
              echo '<ul class="timeline">';
              
              function getRatingLabel($nilai) {
                if ($nilai >= 3.5) return 'Sangat Baik';
                if ($nilai >= 2.5) return 'Baik';
                if ($nilai >= 1.5) return 'Cukup';
                return 'Kurang';
              // Fungsi untuk mendapatkan label rating
              }

              // Fungsi untuk mendapatkan class badge
              function getBadgeClass($nilai) {
                if ($nilai >= 3.5) return 'badge-sangat-baik';
                if ($nilai >= 2.5) return 'badge-baik';
                if ($nilai >= 1.5) return 'badge-cukup';
                return 'badge-kurang';
              }
              
              $no = 1;
              foreach ($rsRiwayat->result() as $row) {


                // Hitung komponen bintang
                $full_stars = floor($row->nilairatarata);
                $half_star = ($row->nilairatarata - $full_stars) >= 0.5 ? 1 : 0;
                $empty_stars = 4 - $full_stars - $half_star;

                // Format tanggal
                $tanggal = date('d F Y', strtotime($row->tglprogress));
                $jam = date('H:i', strtotime($row->tglprogress));
                
                // Tentukan icon berdasarkan rating
                $icon = 'fa-calendar-check-o';
                if ($row->nilairatarata >= 3.5) $icon = 'fa-star';
                else if ($row->nilairatarata >= 2.5) $icon = 'fa-thumbs-up';
                else if ($row->nilairatarata >= 1.5) $icon = 'fa-meh-o';
                else $icon = 'fa-frown-o';
            ?>
                <li class="timeline-item">
                  <div class="timeline-badge">
                    <i class="fa <?php echo $icon; ?>"></i>
                  </div>
                  <div class="timeline-panel">
                    <div class="rating-date">
                      <i class="fa fa-calendar"></i> <?php echo $tanggal; ?> 
                      <i class="fa fa-clock-o ml-2"></i> <?php echo $jam; ?>
                    </div>
                    
                    <div class="d-flex align-items-center flex-wrap">
                      <div class="rating-display">
                        <?php
                        // Tampilkan bintang penuh
                        for($i = 1; $i <= $full_stars; $i++) {
                            echo '<i class="fa fa-star"></i>';
                        }
                        
                        // Tampilkan bintang setengah
                        if($half_star) {
                            echo '<i class="fa fa-star-half-o"></i>';
                        }
                        
                        // Tampilkan bintang kosong
                        for($i = 1; $i <= $empty_stars; $i++) {
                            echo '<i class="fa fa-star-o"></i>';
                        }
                        ?>
                      </div>
                      <span class="rating-value"><?php echo number_format($row->nilairatarata, 1); ?>/4</span>
                      <span class="badge-rating <?php echo getBadgeClass($row->nilairatarata); ?>">
                        <?php echo getRatingLabel($row->nilairatarata); ?>
                      </span>
                    </div>

                    <!-- Detail penilaian per kategori -->
                    <div class="rating-detail">
                      <h6 class="text-primary mb-3">
                        <i class="fa fa-list-ul"></i> Detail Penilaian:
                      </h6>
                      
                      <?php
                      // Ambil detail penilaian
                      $detail_penilaian = $this->db
                          ->select('p.pertanyaan, k.namakategori, pd.nilai')
                          ->from('dcmember_progress_det pd')
                          ->join('pertanyaanprogressdcm p', 'p.idpertanyaan = pd.idpertanyaan')
                          ->join('pertanyaanprogresskategori k', 'k.idkategori = p.idkategori')
                          ->where('pd.idprogress', $row->idprogress)
                          ->order_by('k.idkategori, p.idpertanyaan')
                          ->get();

                      if ($detail_penilaian->num_rows() > 0) {
                        $current_kategori = '';
                        
                        foreach ($detail_penilaian->result() as $detail) {
                          // Hitung bintang untuk detail
                          $detail_full = floor($detail->nilai);
                          $detail_half = ($detail->nilai - $detail_full) >= 0.5 ? 1 : 0;
                          $detail_empty = 4 - $detail_full - $detail_half;
                          
                          // Tampilkan kategori jika berubah
                          if ($current_kategori != $detail->namakategori) {
                            if ($current_kategori != '') {
                              echo '</div>'; // Tutup div sebelumnya
                            }
                            echo '<div class="detail-item">';
                            echo '<div class="detail-label">';
                            echo '<i class="fa fa-folder-open-o text-info"></i> ';
                            echo $detail->namakategori;
                            echo '</div>';
                            $current_kategori = $detail->namakategori;
                          }
                          
                          // Tampilkan pertanyaan dan rating
                          echo '<div class="ml-3 mb-2">';
                          echo '<div class="d-flex justify-content-between align-items-center">';
                          echo '<span class="text-muted small">' . $detail->pertanyaan . '</span>';
                          echo '<span class="detail-value">' . number_format($detail->nilai, 1) . '</span>';
                          echo '</div>';
                          
                          // Tampilkan bintang kecil
                          echo '<div class="detail-stars">';
                          for($i = 1; $i <= $detail_full; $i++) {
                              echo '<i class="fa fa-star"></i>';
                          }
                          if($detail_half) {
                              echo '<i class="fa fa-star-half-o"></i>';
                          }
                          for($i = 1; $i <= $detail_empty; $i++) {
                              echo '<i class="fa fa-star-o"></i>';
                          }
                          echo '</div>';
                          echo '</div>';
                        }
                        echo '</div>'; // Tutup div terakhir
                      }
                      ?>
                    </div>
                  </div>
                </li>
            <?php
                $no++;
              }
              
              echo '</ul>';
            } else {
              // Jika tidak ada riwayat
            ?>
              <div class="empty-state">
                <i class="fa fa-history"></i>
                <h5>Belum Ada Riwayat Penilaian</h5>
                <p class="text-muted">Belum ada progress yang dicatat untuk member ini.</p>
                <a href="<?php echo site_url('dcmemberprogress/form/' . $this->encrypt->encode($iddcmember)); ?>" class="btn btn-primary mt-2">
                  <i class="fa fa-plus"></i> Tambah Progress Baru
                </a>
              </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div> <!-- ./card-body -->

      <div class="card-footer">
        <a href="<?php echo(site_url('dcmemberprogress')) ?>" class="btn btn-default">
          <i class="fa fa-chevron-circle-left"></i> Kembali
        </a>
      </div>
    </div> <!-- /.card -->
  </div> <!-- /.col -->
</div> <!-- /.row -->

<?php $this->load->view("template/footer") ?>

<script type="text/javascript">
  $(document).ready(function() {
    $('.select2').select2();
    
    // Tooltip initialization
    $('[data-toggle="tooltip"]').tooltip();
  }); 
</script>

</body>
</html>