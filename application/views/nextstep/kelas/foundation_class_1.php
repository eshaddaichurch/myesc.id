
<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>

<body>

  <main>



    <?php $this->load->view('template/festavalive/topmenu'); ?>



    <style>

      /* ===== EQUIP CLASS STYLE ===== */

      .equip-section{
        padding:120px 0;
        background:#0b0b0c;
        color:#fff;
      }

      .equip-header{
        max-width:800px;
        margin-bottom:50px;
      }

      .equip-badge{
        display:inline-block;
        padding:6px 14px;
        background:#2a1a0f;
        border-radius:20px;
        font-size:12px;
        letter-spacing:1px;
        margin-bottom:15px;
      }

      .equip-title{
        font-size:48px;
        font-weight:700;
        margin-bottom:15px;
      }

      .equip-desc{
        color:#a1a1aa;
        font-size:18px;
      }

      .schedule-title{
        font-size:26px;
        font-weight:600;
        margin:50px 0 30px 0;
      }

      .class-card{
        background:#151518;
        border-radius:16px;
        overflow:hidden;
        border:1px solid #27272a;
        transition:all .3s ease;
      }

      .class-card:hover{
        transform:translateY(-6px);
        border-color:#ff5a1f;
      }

      .class-img{
        width:100%;
        height:200px;
        object-fit:cover;
      }

      .class-body{
        padding:24px;
      }

      .class-title{
        font-size:20px;
        font-weight:600;
        margin-bottom:10px;
      }

      .class-capacity{
        font-size:13px;
        color:#a1a1aa;
        float:right;
      }

      .class-info{
        font-size:14px;
        color:#cfcfd4;
        margin:6px 0;
      }

      .class-info i{
        color:#ff5a1f;
        margin-right:8px;
      }

      .btn-daftar{
        width:100%;
        margin-top:20px;
        padding:12px;
        border-radius:8px;
        background:#ff5a1f;
        border:none;
        color:#fff;
        font-weight:600;
        transition:.3s;
      }

      .btn-daftar:hover{
        background:#e14d16;
      }

      .help-box{
        margin-top:60px;
        background:#18181b;
        border:1px solid #2a2a2e;
        border-radius:16px;
        padding:30px;
        display:flex;
        justify-content:space-between;
        align-items:center;
      }

      .help-box h4{
        margin:0;
        font-size:20px;
      }

      .help-box p{
        margin:5px 0 0 0;
        color:#a1a1aa;
      }

      .help-btn{
        border:1px solid #ff5a1f;
        padding:12px 24px;
        border-radius:10px;
        color:#ff5a1f;
        text-decoration:none;
        font-weight:600;
      }

      .help-btn:hover{
        background:#ff5a1f;
        color:#fff;
      }

      @media(max-width:768px){

      .equip-title{
        font-size:32px;
      }

      .help-box{
        flex-direction:column;
        gap:20px;
        text-align:center;
      }

      }

      /*whatiscare*/
    </style>
    </head>

    <body>

      <section class="membership-section">
        <h1>Foundation Class 1</h1>
        <p>Foundation Class 1 Salvation and Baptism (FC 1) adalah kelas dasar yang bertujuan membantu jemaat memahami secara mendalam arti keselamatan dan baptisan, dua aspek penting dalam kehidupan orang beriman. Kelas ini mengajak jemaat untuk mengenal lebih dalam anugerah keselamatan dari Yesus Kristus serta memahami peran baptisan sebagai langkah iman dalam menerima kasih karunia-Nya.</p>
        
        <p>Topik Pembelajaran :</p>
        
        <p>1. Keselamatan dalam Kristus Membahas firman Tuhan mengenai keselamatan sebagai anugerah dari Allah, bukan hasil usaha manusia, dengan dasar ayat dari Efesus 2:8-9.</p>
        
        <p>2. Baptisan Air dan Roh Kudus Memaparkan arti simbolis dan spiritual dari baptisan, sekaligus pentingnya komitmen pribadi dalam menerima baptisan sebagai wujud iman, sesuai Roma 6:3-4 dan Kisah Para Rasul 2:38.</p>
        
        <p>Kelas ini dikemas secara interaktif dengan diskusi dan tanya jawab, memungkinkan setiap jemaat untuk menggali konsep-konsep penting, bertanya, dan berbagi pengalaman guna memperdalam iman. Setelah mengikuti kelas ini, jemaat diharapkan semakin siap melangkah dalam iman dan menerima baptisan sebagai bentuk ketaatan perubahan hidup dalam Kristus.</p>


      </section>


    <!-- Untuk Mobile -->
    <section class="page-content section-padding d-md-none d-sm-block">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card" data-aos="zoom-in">
              <div class="card-body">
                <div class="row">

                  <?php
                  if ($rsJadwal->num_rows() > 0) {
                    foreach ($rsJadwal->result() as $rowJadwal) {
                      $tglmulai = date('d-m-Y', strtotime($rowJadwal->tglmulai));
                      $tglselesai = date('d-m-Y', strtotime($rowJadwal->tglselesai));

                      $jamMulai = date('H:i', strtotime($rowJadwal->tglmulai));
                      $jamSelesai = date('H:i', strtotime($rowJadwal->tglselesai));

                      $tglEvent = ($tglmulai == $tglselesai) ? $tglmulai : "$tglmulai s/d $tglselesai";
                      $jamEvent = ($jamMulai == $jamSelesai) ? $jamMulai : "$jamMulai WIB s/d $jamSelesai WIB";

                      $maxJemaat = $rowJadwal->jumlahjemaat ?: 0;

                      $nJumlah = $this->db->query("
                        SELECT COUNT(*) AS jlh FROM jadwaleventregistrasi
                        WHERE idjadwalevent='" . $rowJadwal->idjadwalevent . "' AND statuskonfirmasi<>'Ditolak'
                      ")->row()->jlh;

                      $jumlahPeserta = ($maxJemaat == 0) ? $nJumlah : (
                        $nJumlah == $maxJemaat ?
                        '<span class="text-danger">' . $nJumlah . '/' . $maxJemaat . '</span>' :
                        $nJumlah . '/' . $maxJemaat
                      );

                      $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar($rowJadwal->idjadwalevent, $this->session->userdata('idjemaat'));

                      $button = $sudahPernahDaftar ? '' : '<a href="#" class="btn btn-success btn-sm" data-idjadwalevent="' . $rowJadwal->idjadwalevent . '" id="btnDaftar">Daftar Sekarang</a>';

                      $rsLokasi = $this->db->query("SELECT * FROM jadwaleventdetailtanggal WHERE idjadwalevent = '" . $rowJadwal->idjadwalevent . "' LIMIT 1");
                      $namaLokasi = ($rsLokasi->num_rows() > 0) ? $rsLokasi->row()->lokasievent : '';

                      echo '
                        <div class="col-12" data-aos="fade-up">
                          <h5>' . $rowJadwal->namaevent . '
                            ' . ($sudahPernahDaftar ? '<span class="badge bg-success badge-status">Sudah Daftar</span>' : '<span class="badge bg-secondary badge-status">Baru</span>') . '
                          </h5>
                        </div>
                        <div class="col-12"><i class="fas fa-map-marker-alt me-2"></i> ' . $namaLokasi . '</div>
                        <div class="col-12"><i class="fa fa-calendar me-2"></i> ' . $tglEvent . '</div>
                        <div class="col-12"><i class="far fa-clock me-2"></i> ' . $jamEvent . '</div>
                        <div class="col-12"><i class="fas fa-user-check me-2"></i> ' . $jumlahPeserta . '</div>
                      ';

                      if ($sudahPernahDaftar) {
                        $rsDaftar = $this->db->query("SELECT * FROM v_jadwaleventregistrasi WHERE idjadwalevent='" . $rowJadwal->idjadwalevent . "' AND idjemaat='" . $this->session->userdata('idjemaat') . "'");
                        if ($rsDaftar->num_rows() > 0) {
                          foreach ($rsDaftar->result() as $rowDaftar) {
                            $status = $rowDaftar->statuskonfirmasi;
                            $alertClass = $status == 'Menunggu' ? 'warning' : ($status == 'Disetujui' ? 'success' : 'danger');
                            $pesan = '';

                            if ($status == 'Menunggu') {
                              $pesan = 'Pengajuan pendaftaran kelas anda masih dalam proses <strong>Menunggu</strong>!';
                            } elseif ($status == 'Disetujui') {
                              $pesan = 'Pengajuan pendaftaran kelas sudah <strong>Disetujui</strong>!<br>Silahkan datang pada waktu jadwal yang telah ditentukan.';
                            } elseif ($status == 'Ditolak') {
                              $pesan = 'Pengajuan pendaftaran kelas <strong>Ditolak</strong>!<br>' . $rowDaftar->keterangankonfirmasi;
                            }

                            echo '
                              <div class="col-12 mt-3 ps-3">
                                <div class="alert alert-' . $alertClass . '" role="alert">
                                  <strong>Status Pengajuan : ' . $status . '</strong><br><br>' . $pesan . '
                                </div>
                              </div>';
                          }
                        }
                      }

                      echo '
                        <div class="col-12 mt-3">' . $button . '</div>
                        <hr class="my-4">';
                    }
                  } else {
                    echo '<div class="text-center">Jadwal kelas belum dibuka...</div>';
                  }
                  ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>




       <!-- SECTION: Jadwal Kelas (PENEMPATAN CARD DI SINI) -->
       <section class="equip-section d-none d-md-block">

        <div class="container">

          <!-- HEADER -->
          <div class="equip-header">
            <span class="equip-badge">EQUIP PROGRAM</span>

            <h1 class="equip-title">
              Foundation Class 1
            </h1>

            <p class="equip-desc">
              Temukan makna mendalam dari keselamatan dan langkah ketaatan melalui baptisan.
              Mari bertumbuh bersama dalam fondasi iman yang kuat dalam perjalanan spiritual Anda.
            </p>
          </div>


          <!-- TITLE -->
          <h3 class="schedule-title">
            📅 Jadwal Kelas Mendatang
          </h3>


          <div class="row">

        <?php
        if ($rsJadwal->num_rows() > 0) {

          foreach ($rsJadwal->result() as $rowJadwal) {

            $tglmulai   = date('d F Y', strtotime($rowJadwal->tglmulai));
            $jamMulai   = date('H:i', strtotime($rowJadwal->tglmulai));
            $jamSelesai = date('H:i', strtotime($rowJadwal->tglselesai));

            $maxJemaat = $rowJadwal->jumlahjemaat ?: 0;

            $nJumlah = $this->db->query("
              SELECT COUNT(*) AS jlh 
              FROM jadwaleventregistrasi
              WHERE idjadwalevent = '{$rowJadwal->idjadwalevent}'
              AND statuskonfirmasi <> 'Ditolak'
            ")->row()->jlh;

            $jumlahPeserta = ($maxJemaat == 0)
              ? $nJumlah
              : $nJumlah . '/' . $maxJemaat;

            $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar(
              $rowJadwal->idjadwalevent,
              $this->session->userdata('idjemaat')
            );

            $button = !$sudahPernahDaftar
              ? '<a href="#" class="btn-daftar" id="btnDaftar" data-idjadwalevent="'.$rowJadwal->idjadwalevent.'">Daftar Sekarang</a>'
              : '';

            $rsLokasi = $this->db->query("
              SELECT * 
              FROM jadwaleventdetailtanggal
              WHERE idjadwalevent = '{$rowJadwal->idjadwalevent}'
              LIMIT 1
            ");

            $namaLokasi = ($rsLokasi->num_rows() > 0)
              ? $rsLokasi->row()->lokasievent
              : "";
        ?>

            <!-- CARD -->
            <div class="col-md-6 mb-4">

              <div class="class-card">

                <!-- IMAGE -->
                <img 
                  src="<?= base_url('myesc.id/assets/gambar/bgkelas.jpg'); ?>" 
                  class="class-img"
                >

                <!-- BODY -->
                <div class="class-body">

                  <!-- TITLE -->
                  <div class="class-title">
                    <?= $rowJadwal->namaevent ?>

                    <span class="class-capacity">
                      Peserta: <?= $jumlahPeserta ?>
                    </span>
                  </div>

                  <!-- DATE -->
                  <div class="class-info">
                    <i class="bi bi-calendar"></i>
                    <?= $tglmulai ?>
                  </div>

                  <!-- TIME -->
                  <div class="class-info">
                    <i class="bi bi-clock"></i>
                    <?= $jamMulai ?> - <?= $jamSelesai ?> WIB
                  </div>

                  <!-- LOCATION -->
                  <div class="class-info">
                    <i class="bi bi-geo-alt"></i>
                    <?= $namaLokasi ?>
                  </div>

                  <!-- BUTTON -->
                  <?= $button ?>

                </div>

              </div>

            </div>

        <?php
          }
        } else {
        ?>

          <div class="col-12 text-center">
            <div class="alert alert-info">
              Jadwal kelas belum dibuka.
            </div>
          </div>

        <?php
        }
        ?>

          </div>


          <!-- HELP BOX -->
          <div class="help-box">

            <div>
              <h4>Butuh bantuan pendaftaran?</h4>

              <p>
                Hubungi hotline Equip pada tombol "Hubungi Kami" jika Anda mengalami kesulitan saat
                mendaftar kelas Equip.
              </p>
            </div>

            <a href="https://wa.me/6285183023883" target="_blank" class="help-btn">
              Hubungi Kami
            </a>

          </div>


        </div>
        </section>

    <!-- jQuery dulu -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>




<script>
    $(document).on('click', '#btnDaftar', function(e) {
      var idjadwalevent = $(this).attr('data-idjadwalevent');

      e.preventDefault();

      $.ajax({
        url: '<?= site_url('nextstep/ajaxCeStatusWhatsAPP') ?>',
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {

        if (response.statusverifikasiwa) {


          swal({
            title: "Daftar Kelas?",
            text: "Anda ingin mendaftar di kelas ini? Pastikan anda sudah memenuhi persyaratan untuk mendaftar.",
            icon: "info",
            buttons: ["Batal!", "Ya!"],
            dangerMode: true,
          })
          .then((daftarkelas) => {
            if (daftarkelas) {

              $.ajax({
                  url: '<?php echo site_url('nextstep/daftar') ?>',
                  type: 'POST',
                  dataType: 'json',
                  data: {
                    'idjadwalevent': idjadwalevent
                  },
                })
                .done(function(daftarResult) {
                  console.log(daftarResult);

                  if (daftarResult.success) {
                    swal("Berhasil", "Pengajuan pendaftaran kelas next step anda berhasil disimpan. Periksa kembali status pengajuan pendaftaran anda dalam 2x24 Jam", "success")
                      .then(function() {
                        window.open("<?php echo site_url('nextstep/kelas/' . $kelas_slug . '/' . $this->encrypt->encode($menu)) ?>", "_self");
                      });
                  } else {
                    swal("Gagal", daftarResult.msg, "info");
                  }
                })
                .fail(function() {
                  console.log("error");
                });

            }
          });

          
        }else{
          swal({
            title: "Nomor WhatsApp Belum Terverifikasi",
            text: "Silahkan verifikasi nomor whatsapp terlebih dahulu!",
            icon: "info",            
          })
          .then(() => {
            window.location.href = '<?php echo site_url('akun/ubahprofil') ?>';
          });
        }
      })
      .fail(function() {
        console.log('error');
        swal("Gagal", "Terjadi kesalahan", "error");
      });
      
      

    });
  </script>
      

      <?php $this->load->view('template/festavalive/footer'); ?>