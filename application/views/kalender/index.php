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
    background-color: #e9d6a8;
    font-family: 'Figtree', sans-serif;
    color: #111;
    line-height: 1.7;
    }

    html, body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .card-judul {
      padding: 10px 10px 10px 10px;
      background-color: #cdcdcd;
    }

    .card-judul span {
      margin-top: 8px;
      font-weight: bold;
      font-size: 20px;
      margin-top: 20px;
    }


    .card-event {
      margin: 0;
      padding: 0;
      /* background-color: #ff6d6d; */
      font-family: arial
    }

    .box {
      margin: 0 0;
      height: 100%;
      overflow: hidden;
      padding: 10px 0 40px 80px
    }

    .box ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      position: relative;
      transition: all 0.5s linear;
      top: 0
    }

    .box ul:last-of-type {
      top: 10px
    }

    .box ul:before {
      content: "";
      display: block;
      width: 0;
      height: 100%;
      border: 0.3px dashed;
      color: #D0B8A8;

      position: absolute;
      top: 0;
      left: 30px
    }

    .box ul li {
      margin: 20px 60px 60px;
      position: relative;
      padding: 10px 10px;
      background: rgba(227, 225, 217, 1);
      color: #000000;
      border-radius: 10px;
      line-height: 20px;
      width: 75%
    }


    .box ul li>span {
      content: "";
      display: block;
      width: 0;
      height: 100%;
      border: 1px solid;
      position: absolute;
      top: 0;
      left: -30px
    }

    .box ul li>span:before,
    .box ul li>span:after {
      content: "";
      display: block;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      background: #000000;
      border: 2px solid;
      position: absolute;
      left: -7.5px
    }

    .box ul li>span:before {
      top: -10px
    }

    .box ul li>span:after {
      top: 95%
    }

    .box .title {
      text-transform: uppercase;
      font-weight: 700;
      font-size: 12px;
      margin-bottom: 5px
    }

    .box .info:first-letter {
      text-transform: capitalize;
      line-height: 1.7
    }

    .box .name {
      margin-top: 10px;
      text-transform: capitalize;
      font-style: italic;
      text-align: right;
      margin-right: 20px
    }

    .jam {
      /* color:white; */
      font-style: italic;

    }

    .btn-daftar-kelas {
      display: inline-block;
      margin-top: 10px;
    }


    .box .time span {
      position: absolute;
      left: -120px;
      /* color: #fff; */
      font-size: 80%;
      font-weight: bold;
    }

    .box .time span:first-child {
      top: -16px
    }


    .box .time span:last-child {
      top: 1%
    }


    .arrow {
      position: absolute;
      top: 105%;
      left: 22%;
      cursor: pointer;
      height: 20px;
      width: 20px
    }

    .arrow:hover {
      -webkit-animation: arrow 1s linear infinite;
      -moz-animation: arrow 1s linear infinite;
      -o-animation: arrow 1s linear infinite;
      animation: arrow 1s linear infinite;
    }

    .box ul:last-of-type .arrow {
      position: absolute;
      top: 105%;
      left: 22%;
      transform: rotateX(180deg);
      cursor: pointer;
    }

    svg {
      width: 20px;
      height: 20px
    }

    @keyframes arrow {

      0%,
      100% {
        top: 105%
      }

      50% {
        top: 106%
      }
    }

    @-webkit-keyframes arrow {

      0%,
      100% {
        top: 105%
      }

      50% {
        top: 106%
      }
    }

    @-moz-keyframes arrow {

      0%,
      100% {
        top: 105%
      }

      50% {
        top: 106%
      }
    }

    @-o-keyframes arrow {

      0%,
      100% {
        top: 105%
      }

      50% {
        top: 106%
      }
    }
    </style>
    </head>

    <body>

    <!-- <section class="page-content section-padding"> -->
    <section class="page-content section-padding" style="flex-grow: 1;">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 card-judul">
                    <h5 class="text-center">
                      <a href="<?php echo site_url('kalender/lihatbulan/' . $bulanSebelum . '/' . $tahunSebelum . '/' . $this->encrypt->encode($menu)) ?>" class="btn btn-md float-start"><i class="fa fa-chevron-circle-left"></i></a>
                      <span><?php echo bulan($bulanEvent) . ' ' . $tahunEvent ?></span>
                      <a href="<?php echo site_url('kalender/lihatbulan/' . $bulanBerikut . '/' . $tahunBerikut . '/' . $this->encrypt->encode($menu)) ?>" class="btn btn-md float-end"><i class="fa fa-chevron-circle-right"></i></a>
                    </h5>
                  </div>
                  <div class="col-12 card-event">

                    <?php
                    if ($rsEvent->num_rows() > 0) {
                      echo '
                          <div class="box">

                            <ul id="first-list">

                          ';
                      $idjadwalevent_old = '';

                      foreach ($rsEvent->result() as $row) {
                        $button = '';
                        if ($idjadwalevent_old != $row->idjadwalevent) {
                          $sudahPernahDaftar = $this->Nextstep_model->sudahPernahDaftar($row->idjadwalevent, $this->session->userdata('idjemaat'));
                          if ($sudahPernahDaftar) {
                            $button = '<button href="#" class="btn btn-success btn-sm" data-idjadwalevent="' . $row->idjadwalevent . '" disabled>Daftar Sekarang</button>';
                          } else {
                            $button = '<button href="#" class="btn btn-success btn-sm btnDaftar" data-idjadwalevent="' . $row->idjadwalevent . '">Daftar Sekarang</button>';
                          }
                        }

                        if ($row->jenisjadwal == 'Kelas Next Step') {
                          echo '
                                <li>
                                  
                                  <span></span>
                                 
                                  <div class="title" style="font-size:18px;">' . $row->namaevent . '</div>
                                  <div class="" style="font-size:12px;">' . $row->namakelas . '</div>
                                   <div class="jam">
                                    <sub>Pukul ' . date('H:i', strtotime($row->jammulai)) . ' WIB</sub>
                                    </div>
                                  <div class="btn-daftar-kelas">
                                    ' . $button . '
                                  </div>
                                  <div class="time">
                                  <span>' . hari($row->tgljadwal) . ', ' . date('d', strtotime($row->tgljadwal)) . '</span>                                                                  
                                  </div>
                                </li>
                                ';
                        } else {

                          echo '
                                <li>
                                  
                                  <span></span>
                                 
                                  <div class="title">' . $row->namaevent . '</div>
                                   <div class="jam">
                                    <sub>Pukul ' . date('H:i', strtotime($row->jammulai)) . ' WIB</sub>
                                    </div>
                                  <div class="btn-daftar-kelas">
                                    ' . $button . '
                                  </div>
                                  <div class="time">
                                  <span>' . hari($row->tgljadwal) . ', ' . date('d', strtotime($row->tgljadwal)) . '</span>                                                                  
                                  </div>
                                </li>
                                ';
                        }
                        $idjadwalevent_old = $row->idjadwalevent;
                      }

                      echo '
                            </ul>
                          </div>

                        ';
                    } else {
                      echo '
                          <div class="text-center mt-3">Jadwal event tidak ada..</div>
                        ';
                    }
                    ?>









                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

    <script>
      $(document).ready(function() {




      });


      $(document).on('click', '.btnDaftar', function(e) {
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
                        window.open("<?php echo site_url('nextstep/kelas/') ?>" + daftarResult.kelas_slug + "/" + daftarResult.menu, "_self ");
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

      // var downArrow = document.getElementById("btn1");
      // var upArrow = document.getElementById("btn2");

      // downArrow.onclick = function() {
      //   'use strict';
      //   document.getElementById("first-list").style = "top:-620px";
      //   document.getElementById("second-list").style = "top:-620px";
      //   downArrow.style = "display:none";
      //   upArrow.style = "display:block";
      // };

      // upArrow.onclick = function() {
      //   'use strict';
      //   document.getElementById("first-list").style = "top:0";
      //   document.getElementById("second-list").style = "top:80px";
      //   upArrow.style = "display:none";
      //   downArrow.style = "display:block";
      // };
    </script>
      

      <?php $this->load->view('template/festavalive/footer'); ?>