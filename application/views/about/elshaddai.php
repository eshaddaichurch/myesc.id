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
        @import url('https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Figtree', sans-serif;
            background-color: #fafafa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6, p, a, span, div, li, strong, em {
            font-family: 'Figtree', sans-serif !important;
        }

        .section {
        max-width: 1372px;
        margin: 0 auto;
        padding: 200px 10px;
        }

        .fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .fade-in.visible {
        opacity: 1;
        transform: translateY(0);
        }

        .title {
        font-size: 36px;
        font-weight: 700;
        color: #ff5008;
        margin-bottom: 20px;
        }

        .subsection h2 {
        font-size: 28px;
        color: #ff5008;
        margin-bottom: 10px;
        }


        .value-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
        margin-top: 30px;
        }

        /* Individual cards */
        .value-cards .card {
        flex: 1 1 200px;
        max-width: 250px;
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 12px;
        background-color: #ffffff;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        }

        .value-cards .card:hover {
        transform: translateY(-5px);
        }


        .card {
        background-color: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
        flex-basis: calc(33.33% - 24px);
        margin-bottom: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

       

        ul {
        padding-left: 20px;
        line-height: 1.8;
        }

        .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        align-items: center;
        justify-content: center;
        animation: fadeInModal 0.3s ease-out;
        }

        .modal-content {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        max-width: 500px;
        text-align: center;
        position: relative;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
        }

        @keyframes fadeInModal {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
        }

        .modal-close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
        }

        .carousel-container {
        margin-top: 40px;
        overflow: hidden;
        position: relative;
        }

        .carousel-track {
        display: flex;
        transition: transform 0.5s ease-in-out;
        }

        .carousel-item {
        min-width: 100%;
        box-sizing: border-box;
        border-radius: 12px;
        overflow: hidden;
        }

        .carousel-item img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        }

        .carousel-buttons {
        margin-top: 10px;
        text-align: center;
        }

        .carousel-buttons button {
        background-color: #ff5008;
        border: none;
        color: white;
        padding: 8px 16px;
        margin: 0 5px;
        border-radius: 6px;
        cursor: pointer;
        }

        .carousel-buttons button:hover {
        background-color: #e76e00;
        }

        @media (max-width: 768px) {
        .title {
            font-size: 32px;
        }
        .card {
            flex-basis: calc(50% - 24px);
        }
        .pastor-card {
            flex-basis: 100%;
            max-width: none;
        }
        }

            /* Slideshow */
        .slideshow-container {
        position: relative;
        max-width: 100%;
        height: auto;
        margin: auto;
        overflow: hidden;
        }

        .slide {
        display: none;
        text-align: center;
        }

        .slide.active {
        display: block;
        }

        .slide-img,
        .slide-video {
        width: 100%;
        height: auto;
        max-height: 600px;
        object-fit: cover;
        border-radius: 10px;
        }

        .dots {
        text-align: center;
        margin-top: 10px;
        }

        .dot {
        height: 12px;
        width: 12px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.6s ease;
        cursor: pointer;
        }

        .dot.active {
        background-color: #717171;
        }


        /* Profil Gereja */
        .profil-gereja-section {
        display: flex;
        justify-content: center;
        padding: 60px 30px;
        background: #f5f5f5;
        }
        .profil-container {
        display: flex;
        flex-direction: row;
        gap: 30px;
        max-width: 1200px;
        align-items: flex-start;
        }
        .profil-left {
        flex: 1;
        }
        .profil-image {
        width: 100%;
        border-radius: 10px;
        }
        .profil-right {
        flex: 2;
        }
        .profil-right h2 {
        font-size: 2rem;
        margin-bottom: 20px;
        }

        .vision-mission-section {
            background-color: #111111; /* Warna background gelap */
            color: #ffffff;
            padding: 80px 20px;
        }

        .container-vm {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 60px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .vm-box {
            flex: 1 1 400px;
            max-width: 500px;
        }

        .vm-label {
            font-size: 1.9rem;
            letter-spacing: 1px;
            color: #9CA3AF; /* abu-abu muda */
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .vm-title {
            font-size: 2.75rem;
            font-weight: 600;
            line-height: 1.5;
        }

        @media (max-width: 768px) {
          .vm-title {
              font-size: 1.75rem;
              font-weight: 600;
              line-height: 1.5;
          }
        }


        .fade-in-section {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .fade-in-section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .vm-title {
            transition: opacity 0.5s ease;
        }
        

        .prev, .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 24px;
        transition: 0.3s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
        z-index: 10;
        }
        .next {
        right: 0;
        border-radius: 3px 0 0 3px;
        }
        .prev:hover, .next:hover {
        background-color: rgba(0,0,0,0.6);
        }


        .fade-in-section {
            opacity: 0;
            transform: translateY(50px);
            transition: opacity 1s ease-out, transform 1s ease-out;
        }

        .fade-in-section.visible {
            opacity: 1;
            transform: translateY(0);
        }


        .value-accordion {
            display: flex;
            height: 300px;
            overflow: hidden;
            border-radius: 16px;
            border: 1px solid #ccc;
            flex-direction: row; /* default horizontal */
        }

        .value-panel {
          flex: 1;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          background: #f9f9f9;
          color: #000000;
          cursor: pointer;
          transition: flex 1.5s ease;
          position: relative;
          overflow: hidden;
          border-right: 1px solid #ddd;
        }

        /* Responsive untuk mobile */
        @media (max-width: 768px) {
            .value-accordion {
                flex-direction: column; /* ubah jadi vertikal */
                height: auto; /* biar tinggi mengikuti konten */
            }

            .value-panel {
                flex: none; /* biar tinggi konten tidak terpotong */
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd; /* garis antar panel di bawah */
            }
        }
              

        .value-panel:last-child {
        border-right: none;
        }

        .value-panel.active {
        flex: 3;
        background: linear-gradient(to bottom right, #ffffff, #e6e6e6);
        }

        .panel-title {
          position: absolute;
          top: 20px;
          left: 20px;
          z-index: 2;
          font-size: 24px;
          font-weight: bold;
          letter-spacing: 2px;
          background: white;
          padding: 8px 14px;
          border-radius: 8px;
          box-shadow: 0 2px 6px rgba(0,0,0,0.1);
          pointer-events: none; /* Supaya tidak menghalangi klik */
        }


        .panel-content {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease;
        text-align: center;
        padding: 20px;
        position: relative;
        z-index: 1;
        padding-top: 60px; /* beri jarak agar tidak tumpang tindih dengan inisial */
        }

        @media (max-width: 768px) {
          .panel-content {
          opacity: 0;
          transform: translateY(20px);
          transition: opacity 0.5s ease, transform 0.5s ease;
          text-align: center;
          padding: 20px;
          position: relative;
          z-index: 1;
          padding-top: 99px; /* beri jarak agar tidak tumpang tindih dengan inisial */
          }
        }

        .value-panel.active .panel-content {
        opacity: 1;
        transform: translateY(0);
        }

        .icon-svg {
        font-size: 32px;
        margin-bottom: 10px;
        }


        /* pastor*/
        .pastor-section {
        padding: 60px 20px;
        text-align: center;
        background-color: #f9f9f9;
        }

        .section-title {
        font-size: 3.5rem;
        margin-bottom: 45px;
        color: #222;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 13vh; /* seluruh tinggi layar */
        text-align: center;
        }

        @media (max-width: 768px) {
          .section-title {
          font-size: 2.5rem;
          margin-bottom: 45px;
          color: #222;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 13vh; /* seluruh tinggi layar */
          text-align: center;
          }
        }

        .carousel-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 40px;
        }

        .pastor-card {
        width: 300px;
        height: 450px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
        background: #fff;
        }

        .pastor-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.3s ease;
        }

        .pastor-caption {
        position: absolute;
        bottom: 0;
        background: rgba(0,0,0,0.6);
        width: 100%;
        padding: 12px;
        color: white;
        font-size: 1.1rem;
        text-align: center;
        }

        .carousel-btn {
        width: 50px;
        height: 50px;
        font-size: 28px;
        border: none;
        background-color: #5c6bc0;
        color: white;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.3s ease;
        }

        .carousel-btn:hover {
        background-color: #3f51b5;
        }


        .paragraf-profil {
          /* font-size: 1.5rem; */
          line-height: 1.7;
          margin-bottom: 15px;
          text-align: justify;
        }


        .rediscover-section {
          /* background-color: #5a7740; */
          background-image: url('<?php echo base_url("myesc.id/assets/gambar/jesus.jpg"); ?>');
          color: white;
          text-align: center;
          padding: 215px 20px;
        }

        .rediscover-section .content {
          max-width: 800px;
        
        }

        .title {
          font-size: 60px;
          margin-bottom: 10px;
        }

        .subtitle {
          font-size: 24px;
          font-weight: bold;
          text-transform: uppercase;
          margin-bottom: 30px;
          letter-spacing: 2px;
        }

        .description {
          font-size: 18px;
          line-height: 1.6;
          margin-bottom: 40px;
          
        }

        .btn-learn {
          display: inline-block;
          background-color: white;
          color: #000000;
          text-decoration: none;
          font-weight: bold;
          padding: 12px 30px;
          border-radius: 4px;
          box-shadow: 0 4px 6px rgba(0,0,0,0.1);
          transition: background 0.3s ease;
        }

        .btn-learn:hover {
          background-color: #f0f0f0;
        }



        .profile-card {
          display: flex;
          cursor: pointer;
          background: white;
          border-radius: 16px;
          overflow: hidden;
          box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
          max-width: 1000px;
          width: 100%;
          transition: transform 0.3s;
          margin: auto; /* Biar posisi tengah */
        }

        .profile-card:hover {
          transform: scale(1.02);
        }

        .profile-image {
          flex: 1 1 400px;
          min-width: 130px;
        }

        .profile-image img {
          width: 100%;
          height: 100%;
          object-fit: cover;
        }

        .profile-content {
          flex: 1 40 300px;
          padding: 30px;
          background: #fafafa;
          display: flex;
          flex-direction: column;
          justify-content: center;
        }

        .profile-content h3 {
          font-size: 24px;
          margin-bottom: 10px;
        }

        .profile-content blockquote {
          font-style: italic;
          font-size: 18px;
          line-height: 1.5;
          color: #444;
          margin: 10px 0;
        }

        .profile-content p {
          font-size: 18px;
          line-height: 1.5;
          color: #444;
          margin: 10px 0;
        }

        /* Responsive untuk Mobile */
        @media (max-width: 768px) {
          .profile-card {
            flex-direction: column;
          }

          .profile-image,
          .profile-content {
            width: 100%;
          }

          .profile-content {
          flex: 1 1 300px;
          padding: 30px;
          background: #fafafa;
          display: flex;
          flex-direction: column;
          justify-content: center;
          }

          .profile-content h3 {
            font-size: 20px;
          }

          .profile-content blockquote,
          .profile-content p {
            font-size: 16px;
          }
        }

    </style>
  
    


    <section class="rediscover-section">
      <div class="content">
        <h1 style="font-size: 5.2rem; margin-bottom: 20px; color: #ffffff; font-weight: bold;">Our Owner</h1>
        <h2 class="subtitle" style="font-size: 2.2rem; margin-bottom: 20px; color: #ffffff; font-weight: bold;">JESUS</h2>
        <p style="color: #ffffff;">
          Pemilik dari ESC adalah Tuhan Yesus Kristus.
        </p>
        <!-- <a href="#" class="btn-learn">Lebih Mengenal Jesus →</a> -->
        <a href="<?php echo site_url('jesus/index'); ?>" class="btn-learn">Lebih Mengenal Jesus →</a>
      </div>
    </section>
      
      
    
    <!-- Profil Gereja Section -->
    <section class="profil-gereja-section fade-in-section" style="display: flex; justify-content: center; padding: 60px 30px; background: #fafafa;">
        <div class="profil-container" style="display: flex; flex-direction: row; gap: 30px; max-width: 1200px; align-items: flex-start; flex-wrap: wrap;">
          <div class="profil-left" style="flex: 1; min-width: 300px;">
            <h2 style="font-size: 5.2rem; margin-bottom: 20px; color: #ff5008; font-weight: bold;">ESC</h2>
            <h2 style="font-size: 1.2rem; margin-bottom: 20px; color: #ff5008; font-weight: bold;">EL SHADDAI CHURCH</h2>
          </div>
          <div class="profil-right" style="flex: 2; min-width: 300px;">
            <p class="paragraf-profil">
              ESC diawali dengan datangnya Ps. Yehezkiel Wilan dan Keluarga ke kota Pontianak untuk merintis pelayanan baru dari Gereja lokal GBI Bethany Jakarta pada bulan Juni 1996.
            </p>
            <p class="paragraf-profil">
              Gereja yang masih muda dimulai dengan 3 keluarga di sebuah ruko yang disewa di jalan Nusa Indah 1, sekitar area supermarket Pontisari. Dengan jiwa-jiwa yang Tuhan kirimkan, ibadah raya minggu pindah ke hotel Kapuas Palace, lalu pindah ke gedung Pelni, kemudian pindah lagi ke restoran Gajah Mada, 
            </p>
            <p class="paragraf-profil">
              hingga pada akhirnya dengan bertambahnya jiwa-jiwa yang Tuhan percayakan dan atas penyertaan Tuhan, pada tahun 2009 Tuhan izinkan ESC memiliki gedung sendiri yang bertempat di Jln. Prof. M. Yamin No.1a Kota Baru.
            </p>
            <p class="paragraf-profil">
              ESC merupakan singkatan dari EL SHADDAI CHURCH, dimana nama ini dipakai sebagai Jati Diri di dalam era digital atau dunia maya.
            </p>
            <p class="paragraf-profil">
              Pada awal Gereja ini berjalan menggunakan nama GBI Bethany, lalu berubah menjadi GBI Rayon 16 dan pada tahun 2009 menjadi GBI EL SHADDAI hingga sekarang. Nama EL SHADDAI dipilih sebagai nama Tuhan ketika memperkenal kan diri kepada Abraham di kitab Kejadian 17, SHADDAI artinya adalah Maha Kuasa, EL SHADDAI sama dengan Allah Maha Kuasa. Nama El Shaddai menginspirasikan bahwa Allah itu Maha Kuasa dan Dialah yang sanggup membangun Gereja-Nya seperti yang dikehendaki-Nya.

            </p>
          </div>
        </div>
      </section>
      

       <!-- Slideshow Section -->
      <section class="slideshow-section">
        <div class="slideshow-container">
          
          <div class="slide active">
            <video autoplay muted loop playsinline class="slide-video">
              <!-- <source src="assets/gambar/aniv.mp4" type="video/mp4"> -->
              <source src="<?php echo base_url('myesc.id/assets/gambar/aniv.mp4'); ?>" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
      </section>
    
  
  <!-- Visi -->

    <section class="vision-mission-section">
        <div class="container-vm fade-in-section">
            <div class="vm-box">
                <p class="vm-label">OUR VISION</p>
                <h2 class="vm-title" id="vision-text" style="color: #ff5008;">
                    Membangun Generasi Yang Menghidupi Amanat Agung
                </h2>
            </div>
            <div class="vm-box">
                <p class="vm-label">OUR MISSION</p>
                <h2 class="vm-title" id="mission-text" style="color: #ff5008;">
                    Menyelamatkan Jiwa-Jiwa Dan Menjadi Murid Kristus Yang Saling Mengasihi Melalui Komunitas
                </h2>
            </div>
        </div>
    </section>

  <!-- Nilai-Nilai -->
    <!-- Nilai-Nilai -->
    <section class="section fade-in values-section">
        <h2 class="section-title">Our Values</h2>
        <div class="value-accordion">
          
          <div class="value-panel active">
            <div class="panel-title" style="color: #ff5008;">L</div>
            <div class="panel-content">
                <h3>
                    <p>Love</p>
                </h3>
              <p style="font-size: 20px;">"Jika kamu mengasihi Tuhan."</p>
            </div>
          </div>
      
          <div class="value-panel">
            <div class="panel-title" style="color: #ff5008;">O</div>
            <div class="panel-content">
                <h3>
                    <p>Obedience</p>
                </h3>
              <p style="font-size: 20px;">"Ketaatan kepada Yesus Kristus Tuhan dan Firman-Nya adalah keharusan bagi Jemaat ESC."</p>
            </div>
          </div>
      
          <div class="value-panel">
            <div class="panel-title" style="color: #ff5008;">R</div>
            <div class="panel-content">
                <h3>
                    <p>Relevant</p>
                </h3>
              <p style="font-size: 20px;">"Firman Allah tidak berubah selama-lamanya, namun cara Allah berkomunikasi dengan manusia relevan dengan zaman"</p>
            </div>
          </div>
      
          <div class="value-panel">
            <div class="panel-title" style="color: #ff5008;">D</div>
            <div class="panel-content">
                <h3>
                    <p>Discipleship</p>
                </h3>
              <p style="font-size: 20px;">"Jemaat ESC harus melakukan amanat agung dan perintah utama melalui komunitas murid / Disciple Community."</p>
            </div>
          </div>

          <div class="value-panel">
            <div class="panel-title" style="color: #ff5008;">Jesus</div>
            <div class="panel-content">
              <p style="font-size: 20px;">"Yesus Kristus ialah pusat dari segalanya."</p>
            </div>
          </div>

        </div>
    </section>
      
    
  
  
    <section style="padding: 40px 20px; background-color: #fafafa;">
        <!-- <h2 style="text-align: center; font-size: 32px; margin-bottom: 40px; color: #222;">Our Pastors</h2> -->
        <h2 class="section-title">Our Leadership </h2>
      
        <div style="display: flex; flex-direction: column; gap: 30px; align-items: center;">
      
          <!-- Pastor 1 -->
          <div class="profile-card">
            <div class="profile-image">
              <img src="<?php echo base_url('myesc.id/assets/gambar/gembala.jpg'); ?>" alt="Deskripsi gambar">
              <!-- <img src="myesc.id/assets/gambar/gembala.jpg" alt="Deskripsi gambar"> -->
            </div>
          
            <div class="profile-content">
              <h3>Ps. Yehezkiel Wilan & Ps. Sandra Nappoe</h3>
              
              <blockquote>Senior Pastor.</blockquote>
              <p>
                Ps. Wilan dan Ps. Sandra dipercayakan oleh Tuhan untuk membuka pelayanan di Pontianak dan telah melayani sebagai Gembala Senior dari tahun 1996 hingga saat ini. Dimulai dari 3 keluarga sampai sekarang dipercayakan Tuhan 5000 lebih Jemaat dan membina 20 Gereja yang tersebar di Kalimantan Barat. Beliau dikaruniai 2 orang anak, bernama Chara Caroline dan David Ryan Wilando.
              </p>
            </div>
          </div>
          

          <!-- Pastor 2 -->
          <div class="profile-card">
            <div class="profile-image">
              <img src="<?php echo base_url('myesc.id/assets/gambar/GH_David & Istri.jpg'); ?>" alt="Deskripsi gambar">
            </div>
          
            <div class="profile-content">
              <h3>Ps. David Ryan Wilando & Nindya Elysa</h3>
              
              <blockquote>Group Head Office.</blockquote>
              <p>
                
              </p>
            </div>
          </div>

          <!-- Pastor 3 -->
          <div class="profile-card">
            <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/GH_thian & istri.jpg'); ?>" alt="Deskripsi gambar">
            </div>
          
            <div class="profile-content">
              <h3>Ps. Jozethian Watta & Dona Dorina</h3>
              
              <blockquote> Group Head Creative.</blockquote>
              <p>
                
              </p>
            </div>
          </div>


          <!-- Pastor 4 -->
          <div class="profile-card">
            <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/GH_Lampos & Istri.jpg'); ?>" alt="Deskripsi gambar">
            </div>
          
            <div class="profile-content">
              <h3>Ps. Lampos Rajagukguk & Shangrila Djehadut</h3>
              
              <blockquote> Group Head Community.</blockquote>
              <p>
                
              </p>
            </div>
          </div>

          <!-- Pastor 5 -->
          <div class="profile-card">
            <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/GH_Johanes & Istri.jpg'); ?>" alt="Deskripsi gambar">
            </div>
          
            <div class="profile-content">
              <h3>Ps. johannes Johari & Erni Suryadi</h3>
              
              <blockquote> Group Head Care.</blockquote>
              <p>
                
              </p>
            </div>
          </div>

          <!-- Pastor 6 -->
          <div class="profile-card">
            <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/'); ?>" alt="Deskripsi gambar">
            </div>
          
            <div class="profile-content">
              <h3>Ps. Stevanus Rivan Tampi & Istri</h3>
              
              <blockquote>  Group Head Next Step.</blockquote>
              <p>
                
              </p>
            </div>
          </div>

          <!-- Pastor 7 -->
          <div class="profile-card">
            <div class="profile-image">
            <img src="<?php echo base_url('myesc.id/assets/gambar/'); ?>" alt="Deskripsi gambar">
            </div>
          
            <div class="profile-content">
              <h3>Eiva Rade Sitio</h3>
              
              <blockquote>  Group Head Finance.</blockquote>
              <p>
                
              </p>
            </div>
          </div>

          <!-- Pastor 8 -->

        </div>
      
       
      </section>
      
      
      
    
      
  
  
  <script>
    function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    }

    let currentIndex = 0;
    function moveCarousel(direction) {
    const track = document.querySelector('.carousel-track');
    const totalItems = track.children.length;
    currentIndex = (currentIndex + direction + totalItems) % totalItems;
    track.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    document.addEventListener('DOMContentLoaded', function () {
    const elements = document.querySelectorAll('.fade-in');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
        });
    }, { threshold: 0.1 });
    elements.forEach(el => observer.observe(el));
    });

            // Efek Fade-In Saat Scroll
    document.addEventListener('DOMContentLoaded', function () {
        const faders = document.querySelectorAll('.fade-in');

        function checkVisibility() {
            const triggerBottom = window.innerHeight * 0.85;
            faders.forEach(fader => {
                const faderTop = fader.getBoundingClientRect().top;
                if (faderTop < triggerBottom) {
                    fader.classList.add('visible');
                }
            });
        }

        window.addEventListener('scroll', checkVisibility);
        checkVisibility();
    });

    // slide vidio
    let slideIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');

    function showSlide(index) {
    if (index >= slides.length) slideIndex = 0;
    else if (index < 0) slideIndex = slides.length - 1;
    else slideIndex = index;

    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));

    slides[slideIndex].classList.add('active');
    dots[slideIndex].classList.add('active');
    }

    function plusSlides(n) {
    showSlide(slideIndex + n);
    }

    function currentSlide(n) {
    showSlide(n);
    }

    document.addEventListener("DOMContentLoaded", () => {
    showSlide(slideIndex);
    });
    
    // visi misi
    document.addEventListener("DOMContentLoaded", function () {
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target); // agar animasi hanya sekali muncul
                }
            });
        }, { threshold: 0.3 });

        const target = document.querySelector('.fade-in-section');
        if (target) {
            observer.observe(target);
        }
    });


    document.addEventListener("DOMContentLoaded", function () {
        const vision = document.getElementById("vision-text");
        const mission = document.getElementById("mission-text");

        const indo = {
            vision: "Membangun Generasi Yang Menghidupi Amanat Agung",
            mission: "Menyelamatkan Jiwa-Jiwa Dan Menjadi Murid Kristus Yang Saling Mengasihi Melalui Komunitas"
        };

        const english = {
            vision: "Building Generations that live out the Great Commission",
            mission: "Saving Souls and Making Disciples of Christ Who Love One Another Through Community"
        };

        let isEnglish = false;

        setInterval(() => {
            // Animasi fade-out
            vision.style.opacity = 0;
            mission.style.opacity = 0;

            setTimeout(() => {
                if (isEnglish) {
                    vision.textContent = indo.vision;
                    mission.textContent = indo.mission;
                } else {
                    vision.textContent = english.vision;
                    mission.textContent = english.mission;
                }

                // Animasi fade-in
                vision.style.opacity = 1;
                mission.style.opacity = 1;

                isEnglish = !isEnglish;
            }, 500); // waktu transisi sebelum mengganti teks
        }, 5000); // tiap 2 detik toggle bahasa
    });


    document.addEventListener('DOMContentLoaded', function () {
    const fadeInSection = document.querySelectorAll('.fade-in-section');
    const appearOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const appearOnScroll = new IntersectionObserver(function (entries, observer) {
      entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      });
    }, appearOptions);

    fadeInSection.forEach(section => {
      appearOnScroll.observe(section);
    });
    });


   
    // visi misi
    document.querySelectorAll('.value-panel').forEach(panel => {
        panel.addEventListener('mouseenter', () => {
        document.querySelectorAll('.value-panel').forEach(p => p.classList.remove('active'));
        panel.classList.add('active');
        });
    });


  </script>

      <?php $this->load->view('template/festavalive/footer'); ?>