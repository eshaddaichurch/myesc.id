
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
          position: absolute;
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
      background: linear-gradient(63deg, #fffaf5, #ffb347);
      font-family: 'Figtree', sans-serif;
      color: #111;
      line-height: 1.7;
    }

    .informasi-akun table td {
            font-size: 10px;
            padding: 0px 0px 0px 0px;
        }

        .informasi-akun h5 {
            font-size: 12px;
            color: #655f62;
            font-weight: bold;
        }

        /* .informasi-akun label {
            font-size: 13px;
            color: #6c757d;
        }
        .informasi-akun div {
            font-size: 15px;
        } */

   
        .text-orange {
            color: #fd661f;
        }

        .info-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #343a40;
        }

        .info-card {
            background-color: #fdfdfd;
            transition: 0.2s ease-in-out;
        }

        .info-card:hover {
            background-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.05);
        }

      /*whatiscare*/
    </style>
    </head>

    <body>

    <section class="page-content section-padding">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="col-12 mb-5 text-center">
                        <h3>Status: <?php echo $rowProfil->statusjemaat; ?></h3>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?php echo site_url('akun/simpanupload') ?>" method="post" id="formUpload" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h5>Foto Profil</h5>
                                        </div>
                                        <div class="col-12 text-center">
                                            <?php
                                            if (!empty($rowProfil->foto)) {
                                                echo '
                                                        <img src="' . base_url('myesc.id/admin/uploads/jemaat/' . $rowProfil->foto) . '" alt="" style="width: 80%;" class="">
                                                    ';
                                            } else {
                                                echo '
                                                        <img src="' . base_url('myesc.id/images/nofoto.png') . '" alt="" style="width: 80%;" class="">
                                                    ';
                                            }
                                            ?>

                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>



                    </div>

                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">


                                    <?php
                                    if ($rowProfil->statusjemaat == 'Registered') { ?>
                                        <!-- <div class="col-12 informasi-akun">
                                            <h5>Data Pribadi</h5>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 15%;">Nama Lengkap</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->namalengkap; ?></td>
                                                        <td style="width: 15%;">Email</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->email; ?></td>

                                                    </tr>
                                                    <tr>
                                                        <td style="width: 15%;">Jenis Kelamin</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->jeniskelamin; ?></td>
                                                        <td style="width: 15%;">Nomor HP</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->nohp; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> -->

                                        <div class="col-12 informasi-akun">
                                        <h5 class="mb-4 fw-bold text-orange">Data Pribadi</h5>

                                        <div class="row g-4">

                                            <div class="col-md-6">
                                            <div class="info-card border shadow-sm p-3 rounded-3">
                                                <div class="info-label">Nama Lengkap</div>
                                                <div class="info-value"><?php echo $rowProfil->namalengkap; ?></div>
                                            </div>
                                            </div>

                                            <div class="col-md-6">
                                            <div class="info-card border shadow-sm p-3 rounded-3">
                                                <div class="info-label">Email</div>
                                                <div class="info-value"><?php echo $rowProfil->email; ?></div>
                                            </div>
                                            </div>

                                            <div class="col-md-6">
                                            <div class="info-card border shadow-sm p-3 rounded-3">
                                                <div class="info-label">Jenis Kelamin</div>
                                                <div class="info-value"><?php echo $rowProfil->jeniskelamin; ?></div>
                                            </div>
                                            </div>

                                            <div class="col-md-6">
                                            <div class="info-card border shadow-sm p-3 rounded-3">
                                                <div class="info-label">Nomor HP</div>
                                                <div class="info-value"><?php echo $rowProfil->nohp; ?></div>
                                            </div>
                                            </div>

                                        </div>
                                        </div>



                                    <?php } else { ?>

                                        <div class="col-12 informasi-akun">
                                            <h5>Data Pribadi</h5>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 15%;">Nama</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->namalengkap; ?></td>
                                                        <td style="width: 15%;">Tempat/ Tgl.Lahir</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->tempatlahir . '/ ' . tglindonesia($rowProfil->tanggallahir) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 15%;">Jenis Kelamin</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->jeniskelamin; ?></td>
                                                        <td style="width: 15%;">Status Pernikahan</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->statuspernikahan; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 15%;">Alamat Rumah</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->alamatrumah; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-12 mt-3 informasi-akun">
                                            <h5>Kontak Darurat</h5>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 15%;">Nama</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->namadarurat; ?></td>
                                                        <td style="width: 15%;">Hubungan</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->hubungan; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 15%;">Nomor Telp.</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->notelpdarurat; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-12 mt-3 informasi-akun">
                                            <h5>Sosial Media</h5>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 15%;">Instagram</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->instagram; ?></td>
                                                        <td sty
                                                            le="width: 15%;">Facebook</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->facebook; ?></td>
                                                    </tr>
                                                    <tr>

                                                        <td style="width: 15%;">No. HP</td>
                                                        <td style="width: 5%;">:</td>
                                                        <td style="width: 30%;"><?php echo $rowProfil->nohp; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } ?>


                                    <?php  
                                        if ($rsDC->num_rows()>0) {
                                            foreach ($rsDC->result() as $row) { ?>
                                        
                                                <div class="col-12 mt-3 informasi-akun">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h5>Disciples Community</h5>
                                                        </div>
                                                        <div class="col-12">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="width: 100%;"><?php echo $row->namadc ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>

                                                        </div>
                                                    </div>
                                                </div>

                                    <?php
                                            }
                                        }
                                    ?>



                                    <div class="col-12 d-grid gap-2 mt-3">
                                        <a href="<?php echo site_url('akun/ubahprofil') ?>" class="btn btn-sm btn-primary">Ubah Profil</a>
                                        <a href="<?php echo site_url('akun/gantipassword') ?>" class="btn btn-sm btn-warning">Ubah Password</a>
                                    </div>


                                </div>



                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </section>

    <script>
        $(document).on('change', '#foto', function(e) {
            $('#formUpload').submit();
        });
    </script>
      

      <?php $this->load->view('template/festavalive/footer'); ?>