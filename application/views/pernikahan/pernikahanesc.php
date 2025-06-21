<!--text/x-generic carekonseling.php ( PHP script, UTF-8 Unicode text, with very long lines )-->
<?php

use PhpParser\Node\Stmt\Echo_;

$this->load->view('template/festavalive/header'); ?>

<body>

  <main>



    <?php $this->load->view('template/festavalive/topmenu'); ?>



    <style>
      @import url("https://fonts.googleapis.com/css2?family=Baloo+2&display=swap");
      @import url("https://fonts.googleapis.com/css2?family=Great+Vibes&family=Georgia&display=swap");
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
        background-image: url('<?php echo base_url("assets/gambar/pernikahan1.jpg"); ?>');
        height: 70vh;
        /* Default untuk desktop */
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

      /* Tambahkan ini untuk tampilan mobile */
      @media (max-width: 768px) {
        .parallax-section {
          height: 50vh;
          /* Lebih pendek di layar kecil */
        }
      }



      .parallax-divider {
        position: relative;
        height: 400px;
        /* default untuk desktop */
        background-image: url('<?php echo base_url("assets/gambar/bgpernikahan1.jpg"); ?>');
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        text-align: center;
      }

      /* Untuk layar kecil seperti handphone */
      @media (max-width: 767px) {
        .parallax-divider {
          height: 150px;
          /* atau 200px, sesuaikan dengan konten */
          background-attachment: scroll;
          /* fallback karena background-attachment: fixed sering tidak berfungsi di mobile */
        }
      }


      .parallax-divider p {
        font-size: 19px;
        color: #ffffff;
        /* putih terang */
        max-width: 70%;
        line-height: 1.6;
        position: relative;
        transition: transform 0.5s ease-out, opacity 0.5s ease-out;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
        /* bayangan agar teks tetap kontras */
      }

      #parallax-text {
        color: #ffffff;
        font-size: 12px;
        /* default untuk handphone */
        text-align: center;
        line-height: 1.6;
        max-width: 100%;
        margin: 0 auto;
        position: relative;
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
        transition: transform 0.5s ease-out, opacity 0.5s ease-out;
      }

      /* Ukuran font lebih besar untuk tablet dan desktop */
      @media (min-width: 768px) {
        #parallax-text {
          font-size: 20px;
        }
      }

      @media (min-width: 1024px) {
        #parallax-text {
          font-size: 25px;
        }
      }


      .parallax-text-wrapper {
        padding: 100px;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        /* efek blur untuk kesan modern */
      }

      /* Tambahkan media query untuk layar besar (desktop) */
      @media (min-width: 768px) {
        .parallax-text-wrapper {
          padding: 70px;
        }
      }



      .parallax-section h1 {
        font-size: 48px;
        /* background: rgba(0,0,0,0.5); */
        padding: 40px 40px;
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
        background-color: #fefefe;
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
        font-size: 17px;
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
        color: #ff6db8;
        background-color: transparent;
        transition: all 0.3s ease;
        text-decoration: none;
      }

      .button:hover {
        background-color: #ff6db8;
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
        background-color: #fefefe;
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


      /*perhatian*/
      .itineraries {
        max-width: 2000px;
        background-color: #e7e3d6;
        margin: auto;
        padding: 32px 330px;
      }

      /* Media Query untuk perangkat dengan lebar layar kurang dari 768px (tablet atau mobile) */
      @media (max-width: 768px) {
        .itineraries {
          padding: 32px 16px;
          /* Mengurangi padding agar lebih pas di layar kecil */
          max-width: 100%;
          /* Membuat lebar konten lebih responsif */
        }
      }

      /* Media Query untuk perangkat dengan lebar layar kurang dari 480px (smartphone) */
      @media (max-width: 480px) {
        .itineraries {
          padding: 16px;
          /* Mengurangi padding lebih jauh */
        }
      }


      .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
      }

      .header h1 {
        font-size: 48px;
        font-family: serif;
      }

      .filter {
        cursor: pointer;
        font-size: 16px;
      }

      .itinerary {
        background-color: #f6f6f6;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 20px;
        transition: 0.3s;
      }

      .summary {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        cursor: pointer;
        flex-wrap: wrap;
      }

      .summary .left,
      .summary .right {
        min-width: 200px;
      }

      .summary h2 {
        margin: 0 0 5px 0;
        font-size: 20px;
      }

      .summary p {
        margin: 0;
        color: #555;
      }

      .toggle-icon {
        font-size: 20px;
        margin-left: 10px;
        transition: transform 0.3s;
      }

      .details {
        display: none;
        padding: 20px;
        border-top: 1px solid #ddd;
        background-color: #fff;
        animation: fadeIn 0.3s ease-in-out;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
        }

        to {
          opacity: 1;
        }
      }

      .summary.active .toggle-icon {
        transform: rotate(180deg);
      }

      @media (max-width: 600px) {
        .summary {

          align-items: flex-start;
        }

        .header {
          flex-direction: column;
          align-items: flex-start;
        }

        .header h1 {
          font-size: 36px;
          margin-bottom: 10px;
        }
      }

      .indented-list {
        margin-left: 92px;
        /* atau padding-left */
        margin-bottom: 36px;
      }

      /*perhatian*/

      .download-btn {
        display: inline-flex;
        align-items: center;
        background-color: #000000;
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background 0.3s;
      }

      /* Media Query untuk perangkat dengan lebar layar kurang dari 768px (tablet atau mobile) */
      @media (max-width: 768px) {
        .download-btn {
          margin-left: 16px;
          /* Memberikan margin kiri untuk menggeser tombol lebih ke kiri */
          margin-right: 16px;
          /* Memberikan margin kanan agar tidak terlalu mepet ke tepi */
        }
      }

      /* Media Query untuk perangkat dengan lebar layar kurang dari 480px (smartphone) */
      @media (max-width: 480px) {
        .download-btn {
          margin-left: 8px;
          /* Mengurangi margin kiri lebih dekat ke tepi */
          margin-right: 8px;
          /* Mengurangi margin kanan agar pas di layar kecil */
        }
      }


      .download-btn:hover {
        background-color: #ff6db8;
      }

      .download-btn svg {
        margin-right: 8px;
      }

      /* Awalnya elemen tidak terlihat */
      .scroll-animate {
        opacity: 0;
        transform: translateY(40px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
      }

      /* Ketika terlihat di layar */
      .scroll-animate.visible {
        opacity: 1;
        transform: translateY(0);
      }


      .dedication-invitation {
        position: relative;
        background-color: #fffafc;
        padding: 60px 20px;
        text-align: center;
        overflow: hidden;
      }

      .dedication-text-box {
        background: white;
        border-radius: 12px;
        padding: 40px 24px;
        max-width: 700px;
        margin: auto;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        position: relative;
        z-index: 1;
      }

      .dedication-text-box h2 {
        font-family: 'Great Vibes', cursive;
        font-size: 36px;
        color: #ff6db8;
        margin-bottom: 20px;
      }

      .dedication-text-box p {
        font-family: 'Georgia', serif;
        font-size: 16px;
        color: #444;
        line-height: 1.8;
        text-align: justify;
      }

      /* Hiasan bunga */
      .flower {
        position: absolute;
        width: 145px;
        top: -77px;
        z-index: 0;
        opacity: 0.8;
      }

      .flower-left {
        left: 10px;
        transform: rotate(-10deg);
      }

      .flower-right {
        right: 10px;
        transform: rotate(10deg);
      }

      .dedication-text-box {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-in-out;
      }
    </style>
    </head>

    <body>

      <!-- Parallax Header -->
      <!--<div class="parallax-section">-->
      <!--  <h1 style="color: #fff;">Permohonan Doa</h1>-->
      <!--</div>-->

      <!-- Konten -->

      <!-- Parallax Header -->
      <div class="parallax-section">
        <h1 style="color: #fefefe;">Pemberkatan Pernikahan</h1>
      </div>

      <!-- Konten -->

      <!-- Section: Child Dedication -->
      <div class="section light dedication">
        <section class="dedication-invitation">
          <img src="<?php echo base_url('myesc.id/assets/gambar/bunga1.jpg'); ?>" alt="bunga kiri" class="flower flower-left">

          <div class="dedication-text-box">
            <h2>Shalom, Saudara terkasih!</h2>
            <p>
              Dengan penuh sukacita, kami mengundang Saudara yang telah merindukan momen sakral untuk mengikat janji suci dalam pemberkatan pernikahan di Gereja GBI El Shaddai.
            </p>
            <p>
              Melalui video singkat berikut, Saudara akan dibimbing untuk memahami proses, persiapan, serta makna mendalam dari pernikahan yang diteguhkan dalam kasih dan kebenaran Firman Tuhan.
            </p>
          </div>

          <img src="<?php echo base_url('myesc.id/assets/gambar/bunga1.jpg'); ?>" alt="bunga kanan" class="flower flower-right">
        </section>

        <div class="dedication-video">
          <iframe width="560" height="315" src="https://www.youtube.com/embed/ZqULgqLXYz8?si=3y7krL3iUjdPuCp4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
      </div>


      <!-- PARALLAX DIVIDER -->
      <div class="parallax-divider">
        <div class="parallax-text-wrapper">
          <p id="parallax-text">
            “Sebab itu laki-laki akan meninggalkan ayahnya dan ibunya dan bersatu dengan isterinya, sehingga keduanya menjadi satu daging.”<br>
            - Kejadian 2:24
          </p>
        </div>
      </div>

      <section class="who-is-care" style="padding: 60px 20px; background-color: #fffafc;">
        <div class="container" style="max-width: 1000px; margin: auto;">
          <h2 style="color: #ff6db8; font-family: 'Great Vibes', cursive; font-size: 36px; text-align: center; margin-bottom: 40px;">
            Pemberkatan Pernikahan
          </h2>
          <div class="content" style="display: flex; flex-wrap: wrap; gap: 40px; align-items: center; justify-content: center;">

            <!-- Right Side (Image) -->
            <div class="right scroll-animate" style="flex: 1; min-width: 280px;">
              <div class="dedication-slideshow" style="width: 100%; max-width: 560px; height: 315px; overflow: hidden; position: relative; border-radius: 8px; box-shadow: 0 8px 20px rgba(0,0,0,0.1);">
                <img src="<?php echo base_url('myesc.id/assets/gambar/marriage2.jpg'); ?>" class="slide active" style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
              </div>
            </div>

            <!-- Left Side (Text) -->
            <div class="left scroll-animate" style="flex: 1; min-width: 280px;">
              <p style="font-family: Georgia, serif; font-size: 16px; color: #444; line-height: 1.8; text-align: justify; margin-bottom: 16px;">
                Pemberkatan pernikahan adalah upacara rohani di mana sepasang calon suami-istri menyatakan janji setia mereka di hadapan Tuhan dan jemaat.
              </p>
              <p style="font-family: Georgia, serif; font-size: 16px; color: #444; line-height: 1.8; text-align: justify; margin-bottom: 24px;">
                Dalam momen ini, gereja bukan hanya menjadi saksi, tetapi juga mendoakan dan meneguhkan pernikahan sebagai perjanjian kudus yang diberkati Tuhan.
              </p>
              <a href="<?php echo site_url('pernikahan/tambah'); ?>" class="button">Ajukan Permohonan</a>
            </div>

          </div>
        </div>
      </section>

      <!-- Section 2: Ajakan Kirim Doa -->
      <section class="itineraries">
        <div class="header">
          <h1>Hal Yang Perlu Diperhatikan</h1>
        </div>

        <div class="itinerary">
          <div class="summary" onclick="toggleDetails(this)">
            <!-- <div class="left">
            <h2>Steve Backlund</h2>
            <p>Revive SF</p>
          </div> -->
            <div class="right">
              <h2>Persyaratan dan Informasi Pemberkatan Nikah.</h2>
            </div>
            <div class="toggle-icon">▼</div>
          </div>
          <div class="details">
            <p><strong>1:</strong> Berkas wajib diserahkan 5 bulan sebelum hari H di receptionist ataupun pada jam kantor gereja.</p>
            <p><strong>2:</strong> Silahkan Mendownload file Formulir Pernikahan.</p>
            <p><strong>3:</strong> Formulir akan diterima jika sudah lengkap.</p>
            <p><strong>4:</strong> Silahkan Ajukan Pemberkatan Pernikahan Pada Tombol Ajukan Permohonan.</p>
            <br>
            <a href="<?php echo base_url('myesc.id/assets/gambar/formulir.pdf'); ?>" class="download-btn" style="margin-left: 0px;" download>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24">
                <path d="M12 16l4-5h-3V4h-2v7H8z" />
                <path d="M20 18H4v-2h16v2z" />
              </svg>
              Download Formulir
            </a>
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

        window.addEventListener('scroll', function() {
          const parallax = document.querySelector('.parallax-divider');
          const text = document.getElementById('parallax-text');
          const rect = parallax.getBoundingClientRect();

          if (rect.top < window.innerHeight && rect.bottom > 0) {
            const scrollPercent = Math.min(1, Math.max(0, 0 - rect.top / (window.innerHeight * 0.2)));
            const translateY = scrollPercent * 50;
            const opacity = Math.max(1.5, 1 - scrollPercent * 0.8); // tetap terlihat

            text.style.transform = `translateY(${translateY}px)`;
            text.style.opacity = opacity;
            text.style.visibility = 'visible';
          } else {
            text.style.opacity = 0;
            text.style.visibility = 'hidden';
          }
        });

        function toggleDetails(element) {
          const details = element.nextElementSibling;
          const icon = element.querySelector('.toggle-icon');

          element.classList.toggle('active');
          details.style.display = details.style.display === 'block' ? 'none' : 'block';
        }


        const scrollElements = document.querySelectorAll('.scroll-animate');

        function handleScrollAnimation() {
          scrollElements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
              el.classList.add('visible');
            }
          });
        }

        window.addEventListener('scroll', handleScrollAnimation);
        window.addEventListener('load', handleScrollAnimation); // untuk saat pertama kali tampil



        const textBox = document.querySelector('.dedication-text-box');
        window.addEventListener('scroll', () => {
          const rect = textBox.getBoundingClientRect();
          if (rect.top < window.innerHeight) {
            textBox.style.opacity = '1';
            textBox.style.transform = 'translateY(0)';
          }
        });
      </script>

      <?php $this->load->view('template/festavalive/footer'); ?>