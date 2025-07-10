
<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>

<body>

  <main>



    <?php $this->load->view('template/festavalive/topmenu'); ?>



    <style>
      @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
      @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');
      $main-green: #79dd09 !default;
      $main-green-rgb-015: rgba(121, 221, 9, 0.1) !default;
      $main-yellow: #bdbb49 !default;
      $main-yellow-rgb-015: rgba(189, 187, 73, 0.1) !default;
      $main-red: #bd150b !default;
      $main-red-rgb-015: rgba(189, 21, 11, 0.1) !default;
      $main-blue: #0076bd !default;
      $main-blue-rgb-015: rgba(0, 118, 189, 0.1) !default;

      /* This pen */


      .dark {
        background: #110f16;
      }

      /*--------------------------------------------------------------
                    # Breadcrumbs
                    --------------------------------------------------------------*/
      .breadcrumbs {
        padding: 140px 0 60px 0;
        min-height: 30vh;
        position: relative;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      }

      .breadcrumbs:before {
        content: "";
        background-color: rgba(0, 0, 0, 0.6);
        position: absolute;
        inset: 0;
      }

      .breadcrumbs h2 {
        font-size: 56px;
        font-weight: 500;
        color: #fff;
        font-family: var(--font-secondary);
      }

      .breadcrumbs ol {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0 0 10px 0;
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--color-primary);
      }

      .breadcrumbs ol a {
        color: rgba(255, 255, 255, 0.8);
        transition: 0.3s;
      }

      .breadcrumbs ol a:hover {
        text-decoration: underline;
      }

      .breadcrumbs ol li+li {
        padding-left: 10px;
      }

      .breadcrumbs ol li+li::before {
        display: inline-block;
        padding-right: 10px;
        color: #fff;
        content: "/";
      }


      .light {
        background: #f3f5f7;
      }

      a,
      a:hover {
        text-decoration: none;
        transition: color 0.3s ease-in-out;
      }

      #pageHeaderTitle {
        margin: 2rem 0;
        text-transform: uppercase;
        text-align: center;
        font-size: 2.5rem;
      }

      /* Cards */
      .postcard {
        flex-wrap: wrap;
        display: flex;

        box-shadow: 0 4px 21px -12px rgba(0, 0, 0, 0.66);
        border-radius: 10px;
        margin: 0 0 4rem 0;
        overflow: hidden;
        position: relative;
        color: #ffffff;

        &.dark {
          background-color: #18151f;
        }

        &.light {
          background-color: #e1e5ea;
        }

        .t-dark {
          color: #18151f;
        }

        a {
          color: inherit;
        }

        h1,
        .h1 {
          margin-bottom: 0.5rem;
          font-weight: 500;
          line-height: 1.2;
        }

        .small {
          font-size: 80%;
        }

        .postcard__title {
          font-size: 1.75rem;
          padding-left: 10px;
        }

        .postcard__img {
          max-height: 180px;
          width: 100%;
          object-fit: cover;
          position: relative;
        }

        .postcard__img_link {
          display: contents;
        }

        .postcard__bar {
          width: 50px;
          height: 10px;
          margin: 10px 0;
          border-radius: 5px;
          background-color: #424242;
          transition: width 0.2s ease;
        }

        .postcard__text {
          padding: 2.5rem;
          position: relative;
          display: flex;
          flex-direction: column;
        }

        .postcard__preview-txt {
          overflow: hidden;
          text-overflow: ellipsis;
          text-align: left;
          height: 100%;
        }

        .postcard__tagbox {
          display: flex;
          flex-flow: row wrap;
          font-size: 14px;
          margin: 20px 0 0 0;
          padding: 0;
          justify-content: center;

          .tag__item {

            display: inline-block;
            background: #FAF0E6;
            border-radius: 3px;
            padding: 2.5px 10px;
            margin: 0 5px 5px 0;
            cursor: default;
            user-select: none;
            transition: background-color 0.3s;

            &:hover {
              background: #FFD09B;
            }
          }
        }

        &:before {
          content: "";
          position: abslute;
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
          background-image: linear-gradient(-70deg, #424242, transparent 50%);
          opacity: 1;
          border-radius: 10px;
        }

        &:hover .postcard__bar {
          width: 100px;
        }
      }

      @media screen and (min-width: 769px) {
        .postcard {
          flex-wrap: inherit;

          .postcard__title {
            font-size: 2rem;
          }

          .postcard__tagbox {
            justify-content: start;
          }

          .postcard__img {
            max-width: 300px;
            max-height: 100%;
            transition: transform 0.3s ease;
          }

          .postcard__text {
            padding-left: 4rem;
            width: 100%;

          }

          .media.postcard__text:before {
            content: "";
            position: absolute;
            display: block;
            background: #18151f;
            top: -20%;
            height: 130%;
            width: 55px;
          }

          &:hover .postcard__img {
            transform: scale(1.1);
          }

          &:nth-child(2n+1) {
            flex-direction: row;
          }

          &:nth-child(2n+0) {
            flex-direction: row-reverse;
          }

          &:nth-child(2n+1) .postcard__text::before {
            left: -12px !important;
            transform: rotate(4deg);
          }

          &:nth-child(2n+0) .postcard__text::before {
            right: -12px !important;
            transform: rotate(-4deg);
          }
        }
      }

      @media screen and (min-width: 1024px) {
        .postcard__text {
          padding: 2rem 3.5rem;
        }

        .postcard__text:before {
          content: "";
          position: absolute;
          display: block;

          top: -20%;
          height: 130%;
          width: 55px;
        }

        .postcard.dark {
          .postcard__text:before {
            background: #18151f;
          }
        }

        .postcard.light {
          .postcard__text:before {
            background: #e1e5ea;
          }
        }
      }
    </style>


    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }



      /* body {
        margin: 0;
        font-family: 'Figtree', sans-serif;
        background-color: #fff;
        color: #444;
      } */

      body {
      margin: 0;
      padding: 0;
      background-color: #e9d6a8;
      font-family: 'Figtree', sans-serif;
      color: #111;
      line-height: 1.7;
    }

    .membership-section {
      max-width: 900px;
      margin: 0 auto;
      padding: 80px 20px;
    }

    .membership-section h1 {
      font-size: 52px;
      font-weight: 700;
      margin-bottom: 40px;
    }

    .membership-section p {
      margin-bottom: 20px;
      font-size: 18px;
    }

    .btn-membership {
      margin-top: 40px;
      display: inline-block;
      background-color: #000;
      color: #fff;
      padding: 14px 24px;
      text-decoration: none;
      font-weight: 500;
      border-radius: 4px;
      transition: background 0.3s ease;
    }

    .btn-membership:hover {
      background-color: #333;
    }

    @media (max-width: 768px) {
      .membership-section {
        padding: 60px 20px;
      }

      .membership-section h1 {
        font-size: 36px;
      }

      .membership-section p {
        font-size: 16px;
      }
    }

      /*whatiscare*/
    </style>
    </head>

    <body>

      <section class="membership-section">
        <h1>Foundation Class 1</h1>
        <p>Foundation Class 1 Salvation and Baptism (FC 1) adalah kelas dasar yang bertujuan membantu jemaat memahami secara mendalam arti keselamatan dan baptisan, dua aspek penting dalam kehidupan orang beriman. Kelas ini mengajak jemaat untuk mengenal lebih dalam anugerah keselamatan dari Yesus Kristus serta memahami peran baptisan sebagai langkah iman dalam menerima kasih karunia-Nya.</p>
        
        <p>Topik Pembelajaran</p>
        
        <p>1. Keselamatan dalam Kristus Membahas firman Tuhan mengenai keselamatan sebagai anugerah dari Allah, bukan hasil usaha manusia, dengan dasar ayat dari Efesus 2:8-9.</p>
        
        <p>2. Baptisan Air dan Roh Kudus – Memaparkan arti simbolis dan spiritual dari baptisan, sekaligus pentingnya komitmen pribadi dalam menerima baptisan sebagai wujud iman, sesuai Roma 6:3-4 dan Kisah Para Rasul 2:38.</p>
        
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
    <section class="page-content promo-section d-none d-md-block">
      <div class="container">
        <div class="row justify-content-center">

          <div class="col-12 mb-4 text-center">
            <h2 class="promo-title">Jadwal Pendaftaran Kelas</h2>
            <hr class="w-25 mx-auto">
          </div>

          <?php
          if ($rsJadwal->num_rows() > 0) {
            foreach ($rsJadwal->result() as $rowJadwal) {
              $tglmulai = date('d-m-Y', strtotime($rowJadwal->tglmulai));
              $tglselesai = date('d-m-Y', strtotime($rowJadwal->tglselesai));
              $jamMulai = date('H:i', strtotime($rowJadwal->tglmulai));
              $jamSelesai = date('H:i', strtotime($rowJadwal->tglselesai));

              $tglEvent = ($tglmulai == $tglselesai) ? $tglmulai : "$tglmulai <br><small class='text-muted'>s/d</small><br> $tglselesai";
              $jamEvent = ($jamMulai == $jamSelesai) ? $jamMulai : "$jamMulai WIB <br><small class='text-muted'>s/d</small><br> $jamSelesai WIB";

              $maxJemaat = $rowJadwal->jumlahjemaat ?: 0;
              $nJumlah = $this->db->query("SELECT COUNT(*) as jlh FROM jadwaleventregistrasi WHERE idjadwalevent='{$rowJadwal->idjadwalevent}' AND statuskonfirmasi<>'Ditolak'")->row()->jlh;
              $jumlahPeserta = ($maxJemaat == 0) ? $nJumlah : ($nJumlah == $maxJemaat ? "<span class='text-danger'>$nJumlah/$maxJemaat</span>" : "$nJumlah/$maxJemaat");

              $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar($rowJadwal->idjadwalevent, $this->session->userdata('idjemaat'));

              $button = !$sudahPernahDaftar
                ? '<a href="#" class="btn btn-success btn-lg w-100" id="btnDaftar" data-idjadwalevent="' . $rowJadwal->idjadwalevent . '">Daftar Sekarang</a>'
                : '';
          ?>
              <div class="col-md-6 col-lg-5 mb-5">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                  <img src="<?php echo base_url('myesc.id/assets/gambar/bgkelas.jpg'); ?>" class="card-img-top" alt="Banner Event" style="object-fit: cover; height: 220px;">
                  <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h4 class="fw-bold"><i class="bi bi-calendar-event me-2"></i> <?php echo $rowJadwal->namaevent ?></h4>
                      <span class="badge bg-secondary fs-6">Peserta: <?php echo $jumlahPeserta ?></span>
                    </div>
                    <p class="fs-5 mb-2"><strong>📆 Tanggal:</strong><br><?php echo $tglEvent ?></p>
                    <p class="fs-5 mb-2"><strong>⏰ Jam:</strong><br><?php echo $jamEvent ?></p>
                    <div class="mt-4"><?php echo $button ?></div>
                  </div>

                  <?php if ($sudahPernahDaftar): ?>
                    <?php
                    $rsDaftar = $this->db->query("SELECT * FROM v_jadwaleventregistrasi WHERE idjadwalevent='{$rowJadwal->idjadwalevent}' AND idjemaat='{$this->session->userdata('idjemaat')}'");
                    if ($rsDaftar->num_rows() > 0):
                      foreach ($rsDaftar->result() as $rowDaftar):
                        $status = $rowDaftar->statuskonfirmasi;
                        $tglDaftar = date('d-m-Y H:i:s', strtotime($rowDaftar->tglregistrasi));
                        $alertClass = $status == 'Menunggu' ? 'warning' : ($status == 'Disetujui' ? 'success' : 'danger');
                        $pesan = $status == 'Menunggu' ? 'Pengajuan pendaftaran kelas anda masih dalam proses <strong>Menunggu</strong>!'
                          : ($status == 'Disetujui' ? 'Pengajuan pendaftaran kelas sudah <strong>Disetujui</strong>! Silahkan datang pada waktu jadwal yang telah ditentukan.'
                            : 'Pengajuan pendaftaran kelas <strong>Ditolak</strong>!<br>' . $rowDaftar->keterangankonfirmasi);
                    ?>
                        <div class="card-footer bg-light">
                          <div class="alert alert-<?php echo $alertClass ?> mb-0" style="font-size: 0.9rem;">
                            <strong>👤 Nama Jemaat:</strong> <?php echo $rowDaftar->namalengkap ?><br>
                            <strong>🗓️ Tgl Pengajuan:</strong> <?php echo $tglDaftar ?><br>
                            <strong>Status:</strong> <?php echo $status ?><br><br>
                            <?php echo $pesan ?>
                          </div>
                        </div>
                    <?php endforeach; endif; ?>
                  <?php endif; ?>
                </div>
              </div>
          <?php
            }
          } else {
            echo '
              <div class="col-12 text-center">
                <div class="alert alert-info">Jadwal kelas ' . $rowKelas->namakelas . ' belum dibuka.</div>
              </div>';
          }
          ?>
        </div>
      </div>
    </section>


    <script>
    $(document).on('click', '#btnDaftar', function(e) {
      var idjadwalevent = $(this).attr('data-idjadwalevent');

      e.preventDefault();

      swal({
          title: "Daftar Kelas?",
          text: "Anda ingin mendaftar di kelas ini? Pastikan anda sudah memenuhi persyaratan untuk mendaftar.",
          icon: "warning",
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

    });
  </script>
      

      <?php $this->load->view('template/festavalive/footer'); ?>