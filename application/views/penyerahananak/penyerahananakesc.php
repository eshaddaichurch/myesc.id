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

      body,
      html {
        font-family: 'Arial', sans-serif;
        overflow-x: hidden;
        /* Tambahkan ini */
      }

      .parallax-section {
        background-image: url('<?php echo base_url("assets/gambar/penyerahan12.jpg"); ?>');
        height: 70vh;
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
      }

      .parallax-divider {
        background-image: url('<?php echo base_url("assets/gambar/penyerahan12.JPG"); ?>');
        height: 170px;
        /* Tinggi pemisah */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      }


      .parallax-section h1 {
        font-size: 48px;
        /* background: rgba(0,0,0,0.5); */
        padding: 20px 40px;
        border-radius: 10px;
      }

      body {
        margin: 0;
        font-family: 'Helvetica Neue', sans-serif;
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
        font-size: 18px;
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


      .who-is-care {
        background-color: #ffffff;
        color: #fff;
        padding: 80px 20px;
        text-align: center;
        font-family: 'Helvetica Neue', sans-serif;
      }

      .who-is-care h2 {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 40px;
        color: #ef5008;
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
        color: #000000;
      }

      .slide {
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
      }

      .slide.active {
        opacity: 1;
      }
    </style>
    </head>

    <body>

      <!-- Parallax Header -->
      <div class="parallax-section">
        <h1 style="color: #ffffff;">Penyerahan Anak</h1>
      </div>

      <!-- Konten -->

      <!-- Section: Child Dedication -->
      <div class="section light dedication">
        <div class="dedication-text">
          <p style="color: #ffffff;">
            "Tetapi Yesus berkata: "Biarkanlah anak-anak itu, janganlah menghalang-halangi mereka datang kepada-Ku; sebab orang-orang yang seperti itulah yang empunya Kerajaan Sorga."
          </p>
          <blockquote style="color: #ffffff;">
            <br>
            - Matius 19:14
          </blockquote>
        </div>

        <div class="dedication-video">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/ZqULgqLXYz8?si=3y7krL3iUjdPuCp4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>


      <!-- PARALLAX DIVIDER -->
      <!-- <div class="parallax-divider"></div> -->




      <section class="who-is-care">
        <div class="container">
          <h2>Penyerahan Anak</h2>
          <div class="content">
            <div class="right">
              <div class="dedication-slideshow" style="width: 560px; height: 315px; overflow: hidden; position: relative; border-radius: 8px;">
                <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan11.JPG'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
                <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan12.JPG'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
                <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan10.JPG'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
                <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan9.JPG'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
                <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan8.JPG'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
                <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan7.JPG'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
                <img src="<?php echo base_url('myesc.id/assets/gambar/penyerahan.jpg'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
              </div>
            </div>
            <div class="left">
              <p>
                GBI El Shaddai tidak mempraktikkan baptisan terhadap anak-anak yang masih kecil, melainkan menyerahkan mereka kepada Tuhan dalam sebuah upacara khusus sebagai bentuk iman dan dedikasi rohani orang tua kepada Allah.
              <p>
                Anak-anak dapat diserahkan kepada Tuhan mulai usia delapan hari hingga dua belas tahun, sebagaimana dicatat dalam Lukas 2:21-52.
              <p>

                <a href="<?php echo site_url('penyerahananak/tambah'); ?>" class="button">Ajukan Permohonan</a>
              </p>
            </div>
          </div>
        </div>
      </section>

      <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');

        setInterval(() => {
          slides[currentSlide].classList.remove('active');
          slides[currentSlide].style.opacity = '0';
          currentSlide = (currentSlide + 1) % slides.length;
          slides[currentSlide].classList.add('active');
          slides[currentSlide].style.opacity = '1';
        }, 2000);
      </script>



      <?php $this->load->view('template/festavalive/footer'); ?>