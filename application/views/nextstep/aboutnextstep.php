<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>

<body>

  <main>



    <?php $this->load->view('template/festavalive/topmenu'); ?>



    <style>
      @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
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



      body {
        margin: 0;
        /* font-family: 'Helvetica Neue', sans-serif; */
        font-family: 'Figtree', sans-serif;
        background-color: #fff;
        color: #444;
      }

      .section {
        padding: 60px 20px;
        text-align: center;
      }

      .section.light {
        background-color: #141414;
      }

      h1,
      h2 {
        color: #333;
        margin-bottom: 20px;
      }

      h1 {
        font-size: 26px;
        font-weight: 700;
      }

      h2 {
        font-size: 22px;
        font-weight: 700;
      }

      p {
        font-size: 16px;
        line-height: 1.6;
        max-width: 800px;
        margin: 0 auto 20px;
      }

      .button {
        display: inline-block;
        padding: 10px 24px;
        border: 1px solid #999;
        border-radius: 24px;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 1px;
        color: #ef5008;
        background-color: transparent;
        transition: all 0.3s ease;
        text-decoration: none;
      }

      .button:hover {
        background-color: #ef5008;
        color: #fff;
      }

      /* Child Dedication Section */
      .section.light.dedication {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 40px;
        padding: 60px 20px;
      }

      .dedication-text {
        flex: 1 1 400px;
        max-width: 600px;
        text-align: left;
      }

      .dedication-text blockquote {
        font-style: italic;
        color: #333;
        margin-top: 20px;
        border-left: 4px solid #ef5008;
        padding-left: 16px;
      }

      .dedication-video {
        flex: 1 1 400px;
        max-width: 560px;
      }

      .dedication-video iframe {
        width: 100%;
        height: 315px;
        border: none;
      }



      /*aboutcare*/
      .musik-section {
        padding: 60px 20px;
        text-align: center;
        background-color: #ffffff;
      }

      .musik-section h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 10px;
        color: #ef5008;
      }

      .subjudul {
        font-size: 1.3rem;
        color: #666;
        margin-bottom: 40px;
      }

      .musik-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
      }

      .musik-card {
        border-radius: 12px;
        width: 300px;
        text-align: center;
      }

      .musik-card img {
        width: 100%;
        margin-bottom: 15px;
      }

      .musik-card h3 {
        font-size: 1.2rem;
        font-weight: bold;
        margin: 10px 0 10px;
      }

      .musik-card p {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 15px;
      }

      .musik-card button {
        border: 1px solid #ccc;
        padding: 15px 70px;
        border-radius: 30px;
        background: transparent;
        font-weight: bold;
        color: #555;
        cursor: pointer;
        transition: all 0.3s;
      }

      .musik-card button:hover {
        background-color: #ef5008;
        color: white;
        border-color: #555;
      }

      /*aboutcare*/

      /*whatiscare*/
      .who-is-care {
        background-color: #1c1c1c;
        color: #fff;
        padding: 257px 20px;
        text-align: center;
      }

      @media (max-width: 768px) {
        .who-is-care {
          background-color: #1c1c1c;
          color: #fff;
          padding: 130px 20px;
          text-align: center;
        }
      }

      .who-is-care h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 150px;
        color: #ef5008;
      }

      @media (max-width: 768px) {
        .who-is-care h2 {
          font-size: 2.5rem;
          font-weight: bold;
          margin-bottom: 70px;
          color: #ef5008;
        }
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
      }

      .content {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        justify-content: center;
      }

      .left,
      .right {
        flex: 1 1 500px;
        max-width: 600px;
        text-align: left;
      }

      .left p,
      .right p {
        margin-bottom: 20px;
        line-height: 1.8;
        color: #ccc;
      }

      /*whatiscare*/
    </style>
    </head>

    <body>



      <!-- Konten -->
      <section class="who-is-care">
        <div class="container">
          <h2>ESC NEXT STEP</h2>
          <div class="content">
            <div class="left">
              <p style="text-align: justify;">
                ESC Next Step adalah Wadah Bidang Pengajaran di El Shaddai Church (ESC) yang bertujuan mempersiapkan jemaat untuk bertumbuh dalam iman, sehingga mereka dapat menjadi serupa dengan Kristus, sebagaimana dinyatakan dalam Roma 8:29, “Sebab semua orang yang dipilih-Nya dari semula, mereka juga ditentukanNya dari semula untuk menjadi serupa dengan gambaran Anak-Nya.
              </p>
              <p style="text-align: justify;">
                Dengan Visi ESC "Menjadi Jemaat yang Serupa dengan Kristus Yesus" dan Misi ESC untuk menyelamatkan jiwa-jiwa, menjadi murid Kristus yang memuridkan, serta hidup saling mengasihi (Yohanes 13:34-35), Next Step menawarkan serangkaian Tahap atau Langkah yang terarah untuk menuntun jemaat ke dalam kedewasaan rohani sesuai Visi dan Misi ESC.
              </p>
            </div>
            <div class="right">
              <div class="dedication-video">
                <iframe width="560" height="315"
                  src="https://www.youtube.com/embed/ZqULgqLXYz8?autoplay=1&mute="
                  title="YouTube video player"
                  frameborder="0"
                  allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  referrerpolicy="strict-origin-when-cross-origin"
                  allowfullscreen>
                </iframe>

              </div>
            </div>
          </div>
        </div>
      </section>


      <section class="musik-section">
        <h2>NEXT STEP</h2>
        <p class="subjudul" style="color: #000000;">Seluruh Kelas Next Step</p>
        <div class="musik-container">
          <div class="musik-card">

            <img src="<?php echo base_url('myesc.id/assets/gambar/fc1.png'); ?>" alt="Deskripsi gambar">
            <h3>FOUNDATION CLASS 1</h3>
            <!-- <p>kami siap untuk mendoakan Anda..</p> -->
            <a href="<?= site_url('nextstep/kelas/foundation_class_1') ?>">
              <button type="button">Visit</button>
            </a>

          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/fc2.png'); ?>" alt="Deskripsi gambar">
            <h3>FOUNDATION CLASS 2</h3>
            <!-- <p>Tuhan hadir untuk membantu Anda mengalami kelepasan dan pemulihan yang sejati..</p> -->
            <a href="<?= site_url('nextstep/kelas/foundation_class_2') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/fc3.png'); ?>" alt="Deskripsi gambar">
            <h3>FOUNDATION CLASS 3</h3>
            <!-- <p>Pergerakan pemuda di Hillsong Church, yang disajikan melalui musik.</p> -->
            <a href="<?= site_url('nextstep/kelas/foundation_class_3') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/mc.png'); ?>" alt="Deskripsi gambar">
            <h3>MEMBERSHIP CLASS</h3>
            <!-- <p>Hidup bersama kebenaran alkitabiah yang disesuaikan dengan anak-anak melalui nyanyian.</p> -->
            <a href="<?= site_url('nextstep/kelas/membership_class') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/vc.png'); ?>" alt="Deskripsi gambar">
            <h3>VOULUNTEER CLASS</h3>
            <!-- <p>Hidup bersama kebenaran alkitabiah yang disesuaikan dengan anak-anak melalui nyanyian.</p> -->
            <a href="<?= site_url('nextstep/kelas/volunteer_class') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/gd1.png'); ?>" alt="Deskripsi gambar">
            <h3>GRADE 1</h3>
            <!-- <p>Hidup bersama kebenaran alkitabiah yang disesuaikan dengan anak-anak melalui nyanyian.</p> -->
            <a href="<?= site_url('nextstep/kelas/grade_1') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/gd2.png'); ?>" alt="Deskripsi gambar">
            <h3>GRADE 2</h3>
            <!-- <p>Hidup bersama kebenaran alkitabiah yang disesuaikan dengan anak-anak melalui nyanyian.</p> -->
            <a href="<?= site_url('nextstep/kelas/grade_2') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/gd3.png'); ?>" alt="Deskripsi gambar">
            <h3>GRADE 3</h3>
            <!-- <p>Hidup bersama kebenaran alkitabiah yang disesuaikan dengan anak-anak melalui nyanyian.</p> -->
            <a href="<?= site_url('nextstep/kelas/grade_3') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
          <div class="musik-card">
            <img src="<?php echo base_url('myesc.id/assets/gambar/mc1.png'); ?>" alt="Deskripsi gambar">
            <h3>MARRIAGE CLASS</h3>
            <!-- <p>Hidup bersama kebenaran alkitabiah yang disesuaikan dengan anak-anak melalui nyanyian.</p> -->
            <a href="<?= site_url('nextstep/kelas/marriage_class') ?>">
              <button type="button">Visit</button>
            </a>
          </div>
        </div>
      </section>


      <?php $this->load->view('template/festavalive/footer'); ?>