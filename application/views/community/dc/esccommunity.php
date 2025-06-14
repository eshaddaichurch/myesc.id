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

      body,
      html {
        font-family: 'Figtree', sans-serif;
        background-color: #ff5008;
      }

      h1,
      h2,
      h3,
      h4,
      h5,
      h6,
      p,
      a,
      span,
      div,
      li,
      strong,
      em {
        font-family: 'Figtree', sans-serif !important;
      }

      .section-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        padding: 150px 4%;
        gap: 10px;
      }

      .section-text {
        flex: 1 1 400px;
      }

      @media (max-width: 768px) {
        .section-text {
          flex: 1 1 320px;
        }
      }


      .section-text h1 {
        font-size: 3rem;
        margin-bottom: 20px;
      }

      .section-text p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 30px;
      }

      .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #2f2fff;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
      }

      .btn:hover {
        background-color: #1a1aff;
      }

      .section-image {
        /* flex: 1 1 400px; */
        background: #eee;
        height: 300px;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .section-image img {
        max-width: 100%;
        max-height: 130%;
        object-fit: cover;
      }

      @media (max-width: 768px) {
        .section-container {
          flex-direction: column;
          text-align: center;
        }

        .section-text h1 {
          font-size: 2.2rem;
        }
      }

      /* Child Dedication Section */
      .section.light.dedication {
        background: #000000;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 40px;
        padding: 60px 20px;
      }

      @media (max-width: 768px) {
        .section.light.dedication {
          background: #000000;
          display: flex;
          flex-wrap: wrap;
          align-items: center;
          justify-content: center;
          gap: 40px;
          padding: 50px 3px;
        }
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


      .hero-section {
        position: relative;
        width: 100%;
        height: 59vh;
        background-color: black;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
      }

      @media (max-width: 768px) {
        .hero-section {
          position: relative;
          width: 100%;
          height: 85vh;
          background-color: black;
          display: flex;
          align-items: center;
          justify-content: center;
          overflow: hidden;
        }
      }


      .hero-bg {
        position: absolute;
        width: 70%;
        height: 100%;
        background-image: url('<?php echo base_url('myesc.id/assets/gambar/dc1.jpeg'); ?>');
        background-size: cover;
        background-position: center;
        z-index: 1;
        left: 15%;
      }

      .overlay {
        position: absolute;
        width: 70%;
        height: 100%;
        left: 15%;
        background: rgba(0, 0, 0, 0.5);
        /* dark overlay for readability */
        z-index: 2;
      }

      .hero-content {
        position: relative;
        z-index: 3;
        width: 70%;
        max-width: 1000px;
        padding: 40px;
      }

      .hero-content h5 {
        font-size: 1rem;
        letter-spacing: 2px;
        color: #ccc;
        margin-bottom: 10px;
      }

      .hero-content h1 {
        font-size: 4rem;
        margin: 0;
        font-weight: bold;
      }

      .hero-content h2 {
        font-size: 3.5rem;
        font-family: Georgia, serif;
        font-weight: 500;
        margin: 10px 0 30px;
      }

      .school-list {
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 2;
      }

      .hero-btn {
        display: inline-flex;
        align-items: center;
        background: white;
        color: black;
        padding: 12px 20px;
        border: none;
        font-weight: bold;
        text-decoration: none;
        margin-top: 30px;
        transition: background 0.3s;
      }

      .hero-btn:hover {
        background: #ff5008;
      }

      .hero-btn span {
        margin-left: 10px;
        font-size: 1.2rem;
      }

      @media (max-width: 768px) {
        .hero-content h1 {
          font-size: 2.5rem;
        }

        .hero-content h2 {
          font-size: 2rem;
        }

        .hero-content {
          width: 100%;
          padding: 20px;
        }
      }

      .school-list div {
        animation: blink 1s infinite;
      }

      @keyframes blink {

        0%,
        100% {
          opacity: 1;
        }

        50% {
          opacity: 0;
        }
      }
    </style>
    </head>

    <body>

      <!-- Konten -->

      <section class="section-container" id="small-groups" data-aos="fade-up">
        <div class="section-text">
          <h1 style="color: #ffffff;">Disciples Community</h1>
          <p style="color: #ffffff;">
            Disciples Community adalah komunitas sel di ESC. DC adalah tempat dimana setiap anggota dibimbing untuk mengalami perubahan hidup menjadi serupa dengan Kristus dan diperlengkapi untuk menjadi pemurid sebagai bagian dari perwujudan Amanat Agung.
          </p>
          <!-- <a href="#" class="btn">
        View All Groups →
      </a> -->
        </div>
        <div class="section-image">
          <img src="<?php echo base_url('myesc.id/assets/gambar/dc1.jpeg'); ?>" alt="Small Groups">
        </div>
      </section>

      <!-- Section: Child Dedication -->
      <div class="section light dedication">
        <div class="dedication-video">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/ZqULgqLXYz8?si=3y7krL3iUjdPuCp4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>

        <div class="dedication-text">
          <p style="color: #ffffff; text-align: center;">
            "Karena itu pergilah, jadikanlah semua bangsa murid-Ku dan baptislah mereka dalam nama Bapa dan Anak dan Roh Kudus,
            dan ajarlah mereka melakukan segala sesuatu yang telah Kuperintahkan kepadamu. Dan ketahuilah, Aku menyertai kamu senantiasa sampai kepada akhir zaman.”
          </p>
          <blockquote style="color: #ffffff;">
            <br>
            - Matius 28:19-20
          </blockquote>
        </div>
      </div>


      <section class="hero-section">
        <div class="hero-bg"></div>
        <div class="overlay"></div>
        <div class="hero-content">
          <h5>Visi DC</h5>
          <h1 style="color: #ffffff;">Terjadi Perubahan Hidup</h1>
          <h2 style="color: #ffffff;">Dan Melahirkan Pemurid baru</h2>
          <div class="school-list">
            <div style="color: #ff5008;">ESC Disciples Community</div>
            <div style="color: #ffffff;">ESC Disciples Community</div>
            <div style="color: #ffffff;">ESC Disciples Community</div>
          </div>
          <a href="<?php echo site_url('disciples_community/list'); ?>" class="hero-btn"> Lihat Semua DC <span>→</span></a>
          <p>
            <a href="<?php echo base_url('myesc.id/assets/gambar/formulir.pdf'); ?>" class="download-btn hero-btn" style="margin-left: 0px;" download>
              Download Pedoman DC <span>→</span>
            </a>
          </p>
        </div>
      </section>




      <?php $this->load->view('template/festavalive/footer'); ?>